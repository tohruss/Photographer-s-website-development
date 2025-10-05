<?php

namespace App\Http\Requests;


class UserInfoRequest extends ApiRequest
{
    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'name' => 'sometimes|string|regex:/^[A-Za-zА-Яа-яЁё\s]+$/u|max:255',
            'surname' => 'sometimes|string|regex:/^[A-Za-zА-Яа-яЁё\s]+$/u|max:255',
            'phone' => 'nullable|string|regex:/^\+7(\d{10})$/',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Имя должно быть строкой',
            'name.regex' => 'Имя должно содержать только буквы и пробелы',
            'surname.string' => 'Фамилия должна быть строкой',
            'surname.regex' => 'Фамилия должна содержать только буквы и пробелы',
            'phone.regex' => 'Телефон должен быть в формате: +7-XXX-XXX-XX-XX',
            'avatar.required' => 'Пожалуйста, выберите изображение',
            'avatar.image' => 'Файл должен быть изображением',
            'avatar.mimes' => 'Разрешены только: jpeg, png, jpg, gif',
            'avatar.max' => 'Максимальный размер — 2 МБ',
        ];
    }
}
