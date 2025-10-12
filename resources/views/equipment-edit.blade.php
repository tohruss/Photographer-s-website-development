@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/devices.css') }}">
@endsection

@section('content')
    <main>
        <div class="admin-controls">
            <h3>Редактировать оборудование</h3>

            <form action="{{ route('admin.equipment.update', $equipment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="text" name="title" value="{{ old('title', $equipment->title) }}" placeholder="Название оборудования" required>

                <textarea name="description" placeholder="Описание (необязательно)">{{ old('description', $equipment->description) }}</textarea>

                <div>
                    <img src="{{ $equipment->photo_url }}" alt="{{ $equipment->title }}" style="max-width: 200px; height: auto;">
                    <p>Текущее изображение</p>
                </div>

                <input type="file" name="photo" accept="image/*">

                <label>Категория:</label>
                <div class="category-radios">
                    @foreach($categories as $category)
                        <label>
                            <input type="radio" name="category_id" value="{{ $category->id }}"
                                   {{ $equipment->categories->first()->id == $category->id ? 'checked' : '' }} required>
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
                <button><a href="{{ route('equipment') }}" style="text-decoration: none;color: white">Отмена</a></button>
            </form>
        </div>
    </main>
@endsection
