<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\CategoryOfEquipment;
use App\Http\Requests\EquipmentRequest; // ← подключаем FormRequest
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function index()
    {
        $categories = CategoryOfEquipment::with([
            'equipments' => fn($query) => $query->with('user:id,login')
        ])->get(['id', 'name']);

        return view('equipment', [
            'categories' => $categories,
            'user' => auth()->user(),
        ]);
    }

    public function store(EquipmentRequest $request)
    {
        $path = $request->file('photo')->store('equipment', 'public');

        Equipment::createWithCategories([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $path,
        ], $request->categorys_id);

        return redirect()->route('equipment')
            ->with('success', 'Оборудование успешно добавлено!');
    }


    public function update(EquipmentRequest $request, string $id)
    {
        $equipment = Equipment::findOrFail($id);

        if ($request->hasFile('photo')) {
            $equipment->updatePhoto($request->file('photo'));
        }

        $equipment->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $equipment->categories()->sync($request->categorys_id);

        return redirect()->route('equipment')
            ->with('success', 'Оборудование обновлено!');
    }

    public function destroy(string $id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->deletePhoto();
        $equipment->delete();

        return redirect()->route('equipment')
            ->with('success', 'Оборудование удалено!');
    }


    public function createCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories_of_equipment,name',
        ], [
            'name.required' => 'Название категории обязательно',
            'name.unique' => 'Категория с таким названием уже существует',
        ]);

        CategoryOfEquipment::create(['name' => $validated['name']]);

        return redirect()->route('equipment')
            ->with('success', 'Категория создана!');
    }

    public function updateCategory(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories_of_equipment,name,' . $id,
        ], [
            'name.required' => 'Название категории обязательно',
            'name.unique' => 'Категория с таким названием уже существует',
        ]);

        $category = CategoryOfEquipment::findOrFail($id);
        $category->update(['name' => $validated['name']]);

        return redirect()->route('equipment')
            ->with('success', 'Категория обновлена!');
    }

    public function deleteCategory(string $id)
    {
        $category = CategoryOfEquipment::findOrFail($id);
        $category->safeDelete();

        return redirect()->route('equipment')
            ->with('success', 'Категория удалена!');
    }
}
