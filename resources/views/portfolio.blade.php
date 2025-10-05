@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/portfolio.css') }}">
@endsection

@section('content')
    <main>
        @auth
            @if($user->isAdmin())
                <div class="admin-controls">
                    <h3>Панель администратора</h3>
                    <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="images[]" multiple accept="image/*" required>
                        <button type="submit">Добавить изображения в портфолио</button>
                    </form>
                </div>
            @endif
        @endauth

        <div class="portfolio-grid">
            @foreach($portfolioItems as $item)
                <div class="portfolio-item">
                    <img draggable="false" src="{{ $item->photo_url }}" alt="Фото портфолио">

                    @auth
                        @if($user->isAdmin())
                            <form action="{{ route('admin.portfolio.destroy', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn"
                                        onclick="return confirm('Удалить это изображение?')">×</button>
                            </form>
                        @endif
                    @endauth
                </div>
            @endforeach
        </div>
    </main>
    <div id="modal" class="modal-overlay">
        <button class="modal-close">&times;</button>
        <img id="modal-image" class="modal-image" src="" alt="Полный размер">
    </div>
@endsection
