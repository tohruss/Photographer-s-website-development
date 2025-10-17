@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/auth/verify-email.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <h2 class="card-header">Сброс пароля</h2>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div>
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password">Новый пароль</label>
                        <input id="password" type="password" name="password" required>
                        @error('password')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation">Подтвердите пароль</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required>
                    </div>

                    <button type="submit">Сбросить пароль</button>
                </form>
            </div>
        </div>
    </div>
@endsection
