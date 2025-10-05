@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/style.css') }}">
@endsection

@section('content')
<main>
    <div class="main-contant">
        <div>
            <p>В чем заключаются принципы моей работы? </p>
            <p>Я начинающий фотограф:</p>
            <ul>
                <li>Делаю кадр интересным, запоминающимся.</li>
                <li>Вообще не использую пластику для изменения лица и фигуры.</li>
                <li>Я считаю, что реальность фотографии - это самое главное.</li>
                <li>Могу помочь с подбором локаций. </li>
                <li>Позитивный человек, со мной атмосферно.</li>
            </ul>
        </div>
        <div class="buttoms">
            <a href="{{ route('services') }}">Узнать цену</a>
            <a href="{{ route('contacts') }}">Хочу фотосессию</a>
        </div>
    </div>

    <div class="contant-block">
        <div class="contant-text">
            <p>Если вы заинтересовались моим творчеством и хотите со мной поработать</p>
            <p>С уважением, ваш будущий фотограф</p>
        </div>
        <div class="buttoms-contact">
            <a href="https://t.me/t8enty" target="_blank">Написать в Telegram</a>
            <a href="https://vk.com/t8ent3n" target="_blank">Написать в Vk</a>
            <a href="https://wa.me/79138446924" target="_blank">Написать в WhatsApp</a>
        </div>
    </div>
</main>
@endsection

