@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pagesCss/bookings.css') }}">
@endsection

@section('content')
    <div class="container">
        <livewire:admin-booking-requests />
    </div>
@endsection
