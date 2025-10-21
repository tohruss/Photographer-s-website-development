@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/services.css') }}">
@endsection

@section('content')
    <div>
        <p>Стоимость фотосъемки и видеосъемки</p>
        <p>Здесь вы можете посмотреть все услуги и условия, включающиеся в стоимость</p>
    </div>
    @auth
        @if($user->isAdmin())
            <div class="admin-controls">
                <h3>Панель администратора</h3>
                <form action="{{ url('/admin/services') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="title" placeholder="Название услуги" required>
                    <textarea name="description" placeholder="Описание услуги"></textarea>
                    <input type="number" step="100" name="price" placeholder="Цена (в рублях)" required>
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

                    <button type="submit">Добавить услугу</button>
                </form>

                <hr>

                <form action="{{ url('/admin/services/categories') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Название новой категории" required>
                    <button type="submit">Добавить категорию</button>
                </form>
            </div>
        @endif
    @endauth

    <div class="priceContent">
        @forelse($categories as $category)
            @if($category->services->isNotEmpty())
                <div>
                    <h3 class="category-title">{{ $category->name }}
                        @auth
                            @if($user->isAdmin())
                                <a href="{{ route('admin.service.category.edit', $category->id) }}" class="redact-info">Редактировать &#9997;</a>
                                <form action="{{ route('admin.service.delete-category', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return confirm('Удалить категорию «{{ $category->name }}»? Оборудование без других категорий станет недоступным.')">	&times;</button>
                                </form>
                            @endif
                        @endauth
                    </h3>

                    <div>
                        @foreach($category->services as $service)
                            <div>
                                @if($service->is_available)
                                    <span class="status-available">Доступно</span>
                                @else
                                    <span class="status-unavailable">Недоступно</span>
                                @endif
                                @auth
                                    @if($user->isAdmin())
                                        <div class="service-ed">
                                            <a href="{{ route('service-edit', $service->id) }}" class="redact-info">Редактировать &#9997;</a>
                                            <form action="{{ url('/admin/services/' . $service->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-btn" onclick="return confirm('Удалить услугу?')">	&times;</button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                                @auth
                                    @unless($user->isAdmin())
                                    <div class="favorite-star-container">
                                        @php
                                            $isFavorited = \App\Models\FavoriteService::where('user_id', auth()->id())->where('service_id', $service->id)->exists();
                                        @endphp
                                        @if($isFavorited)
                                            <form action="{{ route('favorites.remove', $service->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="favorite-star-btn unfavorited" title="Удалить из избранного">
                                                    <span class="star-icon"></span>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('favorites.add', $service->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="favorite-star-btn favorited" title="Добавить в избранное">
                                                    <span class="star-icon"></span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    @endunless
                                @endauth
                                <img src="{{ $service->photo_url }}" alt="{{ $service->title }}" class="imgPr">
                                <p class="title-service">{{ $service->title }}</p>
                                <p>{{ number_format($service->price, 0, '', ' ') }} руб.</p>
                                @if($service->description)
                                    <ul>
                                        {!! nl2br(e(str_replace("\n", "\n • ", $service->description))) !!}
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @empty
            <p>Услуги пока не добавлены.</p>
        @endforelse
    </div>

@endsection
