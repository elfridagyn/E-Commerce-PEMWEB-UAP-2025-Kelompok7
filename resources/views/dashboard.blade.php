@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<p>Halo {{ auth()->user()->name }}! Ini adalah dashboard admin.</p>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total User</h5>
            <p>{{ $users }}</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Store</h5>
            <p>{{ $stores }}</p>
        </div>
    </div>
</div>
@endsection
