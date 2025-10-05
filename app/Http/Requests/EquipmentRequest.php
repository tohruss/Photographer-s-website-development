<?php

namespace App\Http\Requests;



class EquipmentRequest extends ApiRequest
{

    public mixed $category_id;

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'categorys_id' => 'required|array',
            'categorys_id.*' => 'exists:categories_of_equipment,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название обязательно',
            'photo.required' => 'Фото обязательно',
            'photo.image' => 'Файл должен быть изображением',
            'photo.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif',
            'photo.max' => 'Размер изображения не должен превышать 5MB',
            'categorsy_id.required' => 'Выберите хотя бы одну категорию',
            'categorys_id.*.exists' => 'Одна из выбранных категорий не существует',
        ];
    }
}
