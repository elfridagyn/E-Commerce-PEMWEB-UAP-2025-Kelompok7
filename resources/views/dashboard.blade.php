<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Auth::user()->role === 'admin')
            <h1>Dashboard Admin</h1>
            <p>Selamat datang, {{ Auth::user()->name }}! Anda login sebagai Admin.</p>
        @elseif(Auth::user()->role === 'user')
            <h1>Dashboard User</h1>
            <p>Selamat datang, {{ Auth::user()->name }}! Anda login sebagai User.</p>
        @elseif(Auth::user()->role === 'seller')
            <h1>Dashboard Penjual</h1>
            <p>Selamat datang, {{ Auth::user()->name }}! Anda login sebagai Penjual.</p>
        @endif
    </div>
@endsection
