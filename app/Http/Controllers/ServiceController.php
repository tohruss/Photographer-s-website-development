<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\CategoryOfService;
use App\Http\Requests\ServiceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Получить все услуги, сгруппированные по категориям (публичный доступ).
     */
    public function index(): JsonResponse
    {
        $categories = CategoryOfService::with([
            'services' => fn ($query) => $query->select('id', 'title', 'price', 'description', 'photo')
                ->with(['usersFavorited:id'])
        ])
            ->get(['id', 'name']);

        $categories->each(function ($category) {
            $category->services->each(function ($service) {
                $service->photo_url = Storage::url($service->photo);
                unset($service->photo);
            });
        });

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }


    public function store(ServiceRequest $request): JsonResponse
    {
        $path = $request->file('photo')->store('services', 'public');

        $service = Service::create([
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'photo' => $path,
        ]);

        $service->categories()->attach($request->categorys_id);

        return response()->json([
            'success' => true,
            'message' => 'Услуга добавлена',
            'data' => $service,
        ], 201);
    }


    public function update(string $id, ServiceRequest $request): JsonResponse
    {
        $service = Service::findOrFail($id);

        if ($request->hasFile('photo')) {
            if (Storage::disk('public')->exists($service->photo)) {
                Storage::disk('public')->delete($service->photo);
            }
            $path = $request->file('photo')->store('services', 'public');
            $service->photo = $path;
        }

        $service->update([
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        $service->categories()->sync($request->categorys_id);

        return response()->json([
            'success' => true,
            'message' => 'Услуга обновлена',
            'data' => $service,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $service = Service::findOrFail($id);

        if (Storage::disk('public')->exists($service->photo)) {
            Storage::disk('public')->delete($service->photo);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Услуга удалена',
        ]);
    }


    public function categories(): JsonResponse
    {
        $categories = CategoryOfService::all(['id', 'name']);

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }


    public function createCategory(): JsonResponse
    {
        $validated = request()->validate([
            'name' => 'required|string|unique:categories_of_services,name',
        ]);

        $category = CategoryOfService::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Категория создана',
            'data' => $category,
        ], 201);
    }


    public function updateCategory(string $id): JsonResponse
    {
        $category = CategoryOfService::findOrFail($id);

        $validated = request()->validate([
            'name' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('categories_of_services')->ignore($category->id),
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
        $category = CategoryOfService::findOrFail($id);

        $category->services()->detach();
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Категория удалена',
        ]);
    }
}
