<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\CategoryOfEquipment;
use App\Http\Requests\EquipmentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    /**
     * Получить всё оборудование, сгруппированное по категориям (публичный доступ).
     */
    public function index(): JsonResponse
    {
        $categories = CategoryOfEquipment::with([
            'equipments' => fn ($query) => $query->select('id', 'user_id', 'title', 'photo', 'description')
                ->with(['user:id,name'])
        ])
            ->get(['id', 'name']);

        $categories->each(function ($category) {
            $category->equipments->each(function ($eq) {
                $eq->photo_url = Storage::url($eq->photo);
                unset($eq->photo);
            });
        });

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }


    public function store(EquipmentRequest $request): JsonResponse
    {
        $path = $request->file('photo')->store('equipment', 'public');

        $equipment = Equipment::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $path,
        ]);

        $equipment->categories()->attach($request->categorys_id);

        return response()->json([
            'success' => true,
            'message' => 'Оборудование добавлено',
            'data' => $equipment,
        ], 201);
    }

    /**
     * Обновить оборудование (только админ).
     */
    public function update(string $id, EquipmentRequest $request): JsonResponse
    {
        $equipment = Equipment::findOrFail($id);

        if ($request->hasFile('photo')) {
            if (Storage::disk('public')->exists($equipment->photo)) {
                Storage::disk('public')->delete($equipment->photo);
            }
            $path = $request->file('photo')->store('equipment', 'public');
            $equipment->photo = $path;
        }

        $equipment->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $equipment->categories()->sync($request->categorys_id);

        return response()->json([
            'success' => true,
            'message' => 'Оборудование обновлено',
            'data' => $equipment,
        ]);
    }

    /**
     * Удалить оборудование (только админ).
     */
    public function destroy(string $id): JsonResponse
    {
        $equipment = Equipment::findOrFail($id);

        if (Storage::disk('public')->exists($equipment->photo)) {
            Storage::disk('public')->delete($equipment->photo);
        }

        $equipment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Оборудование удалено',
        ]);
    }


    public function categories(): JsonResponse
    {
        $categories = CategoryOfEquipment::all(['id', 'name']);

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }


    public function createCategory(): JsonResponse
    {
        $validated = request()->validate([
            'name' => 'required|string|unique:categories_of_equipment,name',
        ]);

        $category = CategoryOfEquipment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Категория создана',
            'data' => $category,
        ], 201);
    }


    public function updateCategory(string $id): JsonResponse
    {
        $category = CategoryOfEquipment::findOrFail($id);

        $validated = request()->validate([
            'name' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('categories_of_equipment')->ignore($category->id),
            ],
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Категория обновлена',
            'data' => $category,
        ]);
    }


    public function deleteCategory(string $id): JsonResponse
    {
        $category = CategoryOfEquipment::findOrFail($id);

        $category->equipments()->detach();
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Категория удалена',
        ]);
    }
}
