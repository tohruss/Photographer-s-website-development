@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/devices.css') }}">
@endsection

@section('content')
    <main>
        <div class="admin-controls">
            <h3>Редактировать услугу</h3>

            <form action="{{ route('admin.service.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <img src="{{ $service->photo_url }}" alt="{{ $service->title }}" style="max-width: 400px;">
                    <p>Текущее изображение</p>
                </div>
                <input type="file" name="photo" accept="image/*">

                <input type="text" name="title" value="{{ old('title', $service->title) }}" placeholder="Название услуги" required>

                <input type="number" step="100" name="price" value="{{ old('price', $service->price) }}" placeholder="Цена (в рублях)" required>

                <textarea name="description" placeholder="Описание (необязательно)">{{ old('description', $service->description) }}</textarea>

                <label>Категория:</label>
                <div class="category-radios">
                    @foreach($categories as $category)
                        <label>
                            <input type="radio" name="category_id" value="{{ $category->id }}"
                                   {{ $service->categories->first()->id == $category->id ? 'checked' : '' }} required>
                            {{ $category->name }}
                        </label>
                    @endforeach
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger" style="color: red; margin-top: 10px;">
                        <ul style="list-style: none; padding-left: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit">Сохранить изменения</button>
                <button><a href="{{ route('services') }}" style="text-decoration: none; color: white;">Отмена</a></button>
            </form>
        </div>
    </main>
@endsection
