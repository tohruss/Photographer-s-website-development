@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/services.css') }}">
@endsection

@section('content')
    <div>
        <p>Мои избранные услуги</p>
        <p>Здесь вы можете посмотреть все услуги, которые добавили в избранное</p>
    </div>

    <div class="priceContent">
        @if($services->isEmpty())
            <p>У вас пока нет избранных услуг.</p>
        @else

            <div>
                <h3 class="category-title">Избранные услуги</h3>
                <div>
                    @foreach($services as $service)
                        <div>
                            @if($service->is_available)
                                <span class="status-available">Доступно</span>
                            @else
                                <span class="status-unavailable">Недоступно</span>
                            @endif

                            @auth
                                <div class="favorite-star-container">
                                    <form action="{{ route('favorites.remove', $service->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="favorite-star-btn unfavorited" title="Удалить из избранного">
                                            <span class="star-icon"></span>
                                        </button>
                                    </form>
                                </div>
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
    </div>
@endsection
