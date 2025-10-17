@extends('layouts.app')

@section('content')
    <h2>Забыли пароль?</h2>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
            <span>{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">Отправить ссылку для сброса</button>
    </form>
    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif
@endsection
