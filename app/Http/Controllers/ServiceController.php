<?php

namespace App\Http\Controllers;

use App\Models\CategoryOfService;
use App\Models\Service;
use App\Http\Requests\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{

    public function index(){
        $categories = CategoryOfService::with('services')->get(['id', 'name']);

        return view('service', [
            'categories' => $categories,
            'user' => auth()->user(),
        ]);
    }

    public function store(ServiceRequest $request)
    {
        $path = $request->file('photo')->store('services', 'public');

        $service = Service::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'photo' => $path,
            'is_available' => true,
        ]);

        $service->categories()->attach($request->category_id);

        return redirect()->route('services')
            ->with('success', 'Услуга успешно добавлена!');
    }

    public function edit(string $id)
    {
        $service = Service::with('categories')->findOrFail($id);
        $categories = CategoryOfService::all(['id', 'name']);

        return view('service-edit', [
            'service' => $service,
            'categories' => $categories,
            'user' => auth()->user(),
        ]);
    }

    public function update(ServiceRequest $request, string $id){

        $service = Service::findOrFail($id);

        if ($request->hasFile('photo')) {
            $service->updatePhoto($request->file('photo'));
        }
        $service->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' =>$request->price,
        ]);

        $service->categories()->sync([$request->category_id]);

        return redirect()->route('services')
            ->with('success', 'Услуга обновлена!');
    }

    public function destroy(string $id)
    {
        $equipment = Service::findOrFail($id);
        $equipment->deletePhoto();
        $equipment->delete();

        return redirect()->route('services')
            ->with('success', 'Услуга удалена!');
    }

    public function createCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories_of_services,name',
        ], [
            'name.required' => 'Название категории обязательно',
            'name.unique' => 'Категория с таким названием уже существует',
        ]);

        CategoryOfService::create(['name' => $validated['name']]);

        return redirect()->route('services')
            ->with('success', 'Категория создана!');
    }

    public function editCategory(string $id)
    {
        $category = CategoryOfService::findOrFail($id);
        $categories = CategoryOfService::all(['id', 'name']);

        return view('equipment-category-edit', [
            'categories' => $categories,
            'user' => auth()->user(),
            'editingCategory' => $category,
        ]);
    }

    public function updateCategory(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories_of_equipment,name,' . $id,
        ], [
            'name.required' => 'Название категории обязательно',
            'name.unique' => 'Категория с таким названием уже существует',
        ]);

        $category = CategoryOfService::findOrFail($id);
        $category->update(['name' => $validated['name']]);

        return redirect()->route('services')
            ->with('success', 'Категория обновлена!');
    }

    public function deleteCategory(string $id)
    {
        $category = CategoryOfService::findOrFail($id);
        $category->safeDelete();

        return redirect()->route('services')
            ->with('success', 'Категория удалена!');
    }
}


