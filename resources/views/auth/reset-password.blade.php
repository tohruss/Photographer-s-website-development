@extends('layouts.app')

@section('content')
    <h2>Сброс пароля</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Новый пароль</label>
            <input id="password" type="password" name="password" required>
            @error('password')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Подтвердите пароль</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Сбросить пароль</button>
    </form>
@endsection
