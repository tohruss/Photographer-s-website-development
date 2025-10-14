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
            'category_id' => 'required|exists:categories_of_equipment,id',
        ];

        if ($this->isMethod('post')) {
            $rules['photo'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        } elseif ($this->hasFile('photo')) {
            $rules['photo'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
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
            'photo.max' => 'Размер изображения не должен превышать 2MB',
            'category_id.required' => 'Выберите одну категорию',
        ];
    }
}
