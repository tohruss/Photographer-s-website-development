@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/auth/verify-email.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <h2 class="card-header">Забыли пароль?</h2>
            <div class="card-body">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div>
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit">Отправить ссылку для сброса</button>
                </form>

                @if (session('status'))
                    <div>{{ session('status') }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection
