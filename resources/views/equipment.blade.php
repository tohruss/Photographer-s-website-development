@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/devices.css') }}">
@endsection

@section('content')
    <main>
        @auth
            @if($user->isAdmin())
                <div class="admin-controls">
                    <h3>Панель администратора</h3>
                    <form action="{{ url('/admin/equipment') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="title" placeholder="Название оборудования" required>
                        <textarea name="description" placeholder="Описание (необязательно)"></textarea>
                        <input type="file" name="photo" accept="image/*" required>

                        <label>Категории:</label>
                        <div class="category-checkboxes">
                            @foreach($categories as $category)
                                <label>
                                    <input type="radio" name="category_id[]" value="{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            @endforeach
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul style="color:red;list-style-type: none">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="submit">Добавить оборудование</button>
                    </form>

                    <hr>

                    <form action="{{ url('/admin/equipment/categories') }}" method="POST">
                        @csrf
                        <input type="text" name="name" placeholder="Название новой категории" required>
                        <button type="submit">Добавить категорию</button>
                    </form>
                </div>
            @endif
        @endauth

        <div class="light_sources">
            @forelse($categories as $category)
                @if($category->equipments->isNotEmpty())
                    <h3 class="category-title">{{ $category->name }}
                        @auth
                            @if($user->isAdmin())
                                <form action="{{ route('admin.equipment.delete-category', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return confirm('Удалить категорию «{{ $category->name }}»? Оборудование без других категорий станет недоступным.')">	&times;</button>
                                </form>
                            @endif
                        @endauth
                    </h3>

                    @foreach($category->equipments as $item)
                        <div class="equipment-card">
                            @if($item->is_available)
                                <span class="status-available">Доступно</span>
                            @else
                                <span class="status-unavailable">Недоступно</span>
                            @endif
                            <img src="{{ $item->photo_url }}" alt="{{ $item->title }}" draggable="false">
                            <h4 class="equipment-title">{{ $item->title }}</h4>
                            @if($item->description)
                                <p class="equipment-description">{{ $item->description }}</p>
                            @endif


                            @auth
                                @if($user->isAdmin())
                                        <a href="{{ route('equipment-edit', $item->id) }}" class="edit-btn">Редактировать</a>
                                    <form action="{{ url('/admin/equipment/' . $item->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" onclick="return confirm('Удалить это оборудование?')">	&times;</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                @endif
            @empty
                <p class="no-equipment">Оборудование пока не добавлено.</p>
            @endforelse
        </div>
    </main>
@endsection
