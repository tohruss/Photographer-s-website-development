<?php

namespace App\Http\Requests;

class ServiceRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'categorys_id' => 'required|array',
            'categorys_id.*' => 'exists:categories_of_services,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название услуги обязательно',
            'price.required' => 'Цена обязательна',
            'price.numeric' => 'Цена должна быть числом',
            'photo.required' => 'Фото обязательно',
            'photo.image' => 'Файл должен быть изображением',
            'photo.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif',
            'photo.max' => 'Размер изображения не должен превышать 5MB',
            'categorys_id.required' => 'Выберите хотя бы одну категорию',
            'categorys_id.*.exists' => 'Одна из выбранных категорий не существует',
        ];
    }
}
