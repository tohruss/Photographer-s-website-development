@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/contact.css') }}">
@endsection
@section('content')
<main>
    <div class="wrapper">
    </div>
    <div>
        <div class="contant-text">
            <p>Меня зовут Дима. Я учусь и работаю в Томске. Родился в городе Колпашево.  </p>
            <p>Чтобы связаться со мной нужно</p>
        </div>
        <div class="buttoms-contact">
            <a href="https://t.me/t8enty" target="_blank">Написать в Telegram</a>
            <a href="https://vk.com/t8ent3n" target="_blank">Написать в Vk</a>
            <a href="https://wa.me/79138446924" target="_blank">Написать в WhatsApp</a>
        </div>
    </div>
</main>
@endsection
