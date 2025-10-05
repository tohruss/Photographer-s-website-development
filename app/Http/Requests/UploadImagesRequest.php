<?php

namespace App\Http\Requests;

class UploadImagesRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'images.*.required' => 'Изображение обязательно',
            'images.*.image' => 'Файл должен быть изображением',
            'images.*.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif',
            'images.*.max' => 'Размер изображения не должен превышать 5MB',
        ];
    }
}
