@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/comments.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagesCss/popupWindow2.css') }}">
@endsection
@section('content')
    <div class="container">
        <livewire:review-modal />
        <livewire:review-list />
    </div>
@endsection
