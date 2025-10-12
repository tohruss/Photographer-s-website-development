@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/devices.css') }}">
@endsection

@section('content')
    <main>
        <div class="admin-controls">
            <h3>Редактировать категорию оборудования</h3>

            <form action="{{ route('admin.equipment.category.update', $editingCategory->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label for="name">Название категории:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $editingCategory->name) }}" required>

                @if ($errors->any())
                    <div style="color: red">
                        <ul style="list-style: none">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <button type="submit">Сохранить изменения</button>
                    <button><a href="{{ route('equipment') }}" style="text-decoration: none;color: white">Отмена</a></button>
                </div>
            </form>
        </div>
    </main>
@endsection
