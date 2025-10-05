@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/loginRegister.css') }}">
@endsection

@section('content')

    <div class="auth-container">
        <h2 class="title-form">Зарегистрируйте свой аккаунт</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('registration') }}">
            @csrf

            <div class="lable-form-container">
                <label for="login">Введите ваш логин</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}" required>
                @error('login') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="lable-form-container">
                <label for="email">Введите электронную почту</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="lable-form-container">
                <label for="password">Введите пароль</label>
                <input type="password" id="password" name="password" required>
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="lable-form-container">
                <label for="password_confirmation">Введите пароль повторно</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
@endsection
