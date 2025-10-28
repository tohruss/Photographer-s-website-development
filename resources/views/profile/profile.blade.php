@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/profile/profile.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="avatar-wrapper">
                    @if($user->userInfo?->avatar)
                        <img draggable="false" src="{{ Storage::url($user->userInfo->avatar) }}" alt="Аватар" class="rounded-circle">
                    @else
                        <img draggable="false" src="{{ asset('img/Group30.svg') }}" alt="Аватар по умолчанию" class="rounded-circle">
                    @endif
                </div>
                <div class="user-body">
                    <div class="user-info">
                        <div>
                            <strong>ФИО:</strong> {{ $user->userInfo?->name }} {{ $user->userInfo?->surname }}
                        </div>

                        <div>
                            <strong>Логин:</strong> {{ $user->login }}
                        </div>

                        <div>
                            <strong>Email:</strong> {{ $user->email }}
                        </div>

                        <div>
                            <strong>Тел:</strong> {{ $user->userInfo?->tel ?? 'Не указан' }}
                        </div>
                    </div>

                    <div class="user-button">
                        <div>
                            @if($user->isAdmin())
                                <a href="{{ route('admin.reviews') }}">Просмотр отзывов</a>
                            @else
                                <a href="{{ route('favorites') }}">Просмотр избранного</a>
                            @endif
                        </div>

                        <div class="buttoms">
                            <a href="{{ route('profile.edit') }}">Редактировать профиль</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="promocods">
            <h2>ПРОМОКОДЫ</h2>
            <div class="promo-list">
                <div class="promo-card" data-promo="TOHRUSS">
                    <img draggable="false" src="/img/500.png" alt="Промокод TOHRUSS" style="width:100%; display:block;">
                    <div class="copy-feedback">Скопировано!</div>
                </div>
                <div class="promo-card" data-promo="PHOTO2025">
                    <img draggable="false" src="/img/1000.png" alt="Промокод PHOTO2025" style="width:100%; display:block;">
                    <div class="copy-feedback">Скопировано!</div>
                </div>
                <div class="promo-card" data-promo="FC25">
                    <img draggable="false" src="/img/1500.png" alt="Промокод FC25" style="width:100%; display:block;">
                    <div class="copy-feedback">Скопировано!</div>
                </div>
            </div>
        </div>
    </div>
@endsection
