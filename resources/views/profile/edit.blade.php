@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/profile/edit.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="avatar-wrapper">
                        @if(auth()->user()->userInfo?->avatar)
                            <img draggable="false" src="{{ Storage::url(auth()->user()->userInfo->avatar) }}" alt="Аватар" class="rounded-circle">
                        @else
                            <img draggable="false" src="{{ asset('img/Group30.svg') }}" alt="Аватар по умолчанию" class="rounded-circle">
                        @endif
                            <div>
                                <label for="avatar" class="form-label">Фото профиля</label>
                                <input type="file" name="avatar" id="avatar" class="form-control-file" accept="image/*">
                                @error('avatar')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                    </div>

                    <div class="user-body">
                        <div class="user-info">
                            <div>
                                <label for="name" class="form-label">Введите ваше Имя</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', auth()->user()->userInfo?->name) }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="surname" class="form-label">Введите вашу Фамилию</label>
                                <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname', auth()->user()->userInfo?->surname) }}">
                                @error('surname')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="form-label">Введите ваш телефон</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', auth()->user()->userInfo?->tel) }}" placeholder="+7 (999) 123-45-67">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="user-button">
                            <div>
                                <button type="submit">Сохранить изменения</button>
                            </div>
                            <div class="buttoms">
                                <a href="{{ route('profile') }}">Отмена</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
