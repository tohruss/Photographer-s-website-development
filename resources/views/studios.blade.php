@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/studio.css') }}">
@endsection

@section('content')
    <main>
        <div>
            <p>Фотостудии, которые можно арендовать в Томске</p>
        </div>
        <div>
            <div>
                <a href="https://photoplace.pro/tomsk/akvarel_tomsk/1" target="_blank">
                    <img draggable="false" src="{{ asset('img/акварель1.png') }}" alt="акварель">
                </a>
                <a href="https://photoplace.pro/tomsk/akvarel_tomsk/1" target="_blank">“АКВАРЕЛЬ” зал №1</a>
            </div>
            <div>
                <a href="https://photoplace.pro/tomsk/akvarel_tomsk/2-ciklorama" target="_blank">
                    <img draggable="false" src="{{ asset('img/акварель2.png') }}" alt="акварель">
                </a>
                <a href="https://photoplace.pro/tomsk/akvarel_tomsk/2-ciklorama" target="_blank">“АКВАРЕЛЬ” зал №2</a>
            </div>
            <div>
                <a href="https://томсон.рф/zal-sfera" target="_blank">
                    <img draggable="false" src="{{ asset('img/томсон_сфера.png') }}" alt="томсон">
                </a>
                <a href="https://томсон.рф/zal-sfera" target="_blank">“ТОМСОН” зал СФЕРА</a>
            </div>
            <div>
                <a href="https://томсон.рф/zal-edison" target="_blank">
                    <img draggable="false" src="{{ asset('img/томсон_эдисон.png') }}" alt="томсон">
                </a>
                <a href="https://томсон.рф/zal-edison" target="_blank">“ТОМСОН” зал ЭДИСОН</a>
            </div>
            <div>
                <a href="https://studioflat101.com/58/" target="_blank">
                    <img draggable="false" src="{{ asset('img/sf58.png') }}" alt="sf58">
                </a>
                <a href="https://studioflat101.com/58/" target="_blank">SF зал 58</a>
            </div>
            <div>
                <a href="https://studioflat101.com/60/" target="_blank">
                    <img draggable="false" src="{{ asset('img/sf60.png') }}" alt="sf60">
                </a>
                <a href="https://studioflat101.com/60/" target="_blank">SF зал 60</a>
            </div>
        </div>
    </main>
@endsection
