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
                        <img src="{{ Storage::url($user->userInfo->avatar) }}" alt="Аватар" class="rounded-circle">
                    @else
                        <img src="{{ asset('img/Group30.svg') }}" alt="Аватар по умолчанию" class="rounded-circle">
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
                            <a href="{{ route('favorites') }}">Просмотр отзывов</a>
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
    </div>
@endsection
