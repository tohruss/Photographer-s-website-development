@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/loginRegister.css') }}">
@endsection
@section('content')
    <div class="auth-container">
        <h2 class="title-form">Войдите в свой аккаунт</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="lable-form-container">
                <label for="login">Введите ваш логин</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}" required>
                @error('login') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="lable-form-container">
                <label for="password">Введите пароль</label>
                <input type="password" id="password" name="password" required>
                @error('password') <span class="error">{{ $message }}</span> @enderror
                <a href="#">Забыли пароль?</a>
            </div>

            <button type="submit">Войти</button>
        </form>

        <hr>
        <p style="text-align: center;">или</p>
        <button type="button" style="width: 100%; background: #e8d5d5; border: none; padding: 12px; margin-top: 10px;">
            Войти через Яндекс
        </button>
    </div>
@endsection
