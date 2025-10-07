<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
{


    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'categorys_id' => 'required|array',
            'categorys_id.*' => 'exists:categories_of_equipment,id',
        ];

        if ($this->isMethod('post')) {
            $rules['photo'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
        } elseif ($this->hasFile('photo')) {
            $rules['photo'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название обязательно',
            'photo.required' => 'Фото обязательно',
            'photo.image' => 'Файл должен быть изображением',
            'photo.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif',
            'photo.max' => 'Размер изображения не должен превышать 5MB',
            'categorys_id.required' => 'Выберите хотя бы одну категорию',
            'categorys_id.*.exists' => 'Одна из выбранных категорий не существует',
        ];
    }
}
