@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/auth/verify-email.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Подтвердите ваш email</div>
                    <div class="card-body">
                        <p>Перед тем как продолжить, пожалуйста, проверьте вашу почту на наличие письма с подтверждением.</p>
                        <p>Если вы не получили письмо — <a href="{{ route('verification.send') }}" onclick="event.preventDefault(); document.getElementById('resend-form').submit();">нажмите здесь, чтобы отправить снова</a>.</p>

                        <form id="resend-form" method="POST" action="{{ route('verification.send') }}" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
