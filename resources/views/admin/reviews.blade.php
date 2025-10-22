@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/adminMiderationReviews.css') }}">
@endsection
@section('content')
    <div class="container admin-reviews-page">
        <h2>Модерация отзывов</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @foreach($reviews as $review)
            <div class="admin-review-card">
                <div class="avatar-wrapper">
                    @if($review->user?->userInfo?->avatar)
                        <img src="{{ Storage::url($review->user->userInfo->avatar) }}" alt="Аватар" class="rounded-circle">
                    @else
                        <img draggable="false" src="{{ asset('img/Group30.svg') }}" alt="Аватар по умолчанию" class="rounded-circle">
                    @endif
                </div>
                <div class="content">
                    <div class="author-name">
                        {{ $review->user?->userInfo?->name ?? 'Аноним' }}
                    </div>
                    <div class="comment">{{ $review->comment }}</div>
                    <div class="meta">
                        <strong>Лайков:</strong> {{ $review->reviewLike->where('like', 1)->count() }} &nbsp;&nbsp;
                        <strong>Статус:</strong> {{ $review->is_approved ? 'Одобрен' : 'На модерации' }}
                    </div>
                    <div class="actions">
                        @if(!$review->is_approved)
                            <form action="{{ route('reviews.approve', [$review->id, true]) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-action btn-approve">✅ Одобрить</button>
                            </form>
                        @endif

                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete">🗑️ Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
