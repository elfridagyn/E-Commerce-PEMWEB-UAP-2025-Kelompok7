@extends('layouts.admin')

@section('title', 'Verifikasi Toko')

@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <tr>
        <th>Nama Toko</th>
        <th>Pemilik</th>
        <th>Aksi</th>
    </tr>

    @foreach($stores as $store)
    <tr>
        <td>{{ $store->name }}</td>
        <td>{{ $store->user->name }}</td>
        <td>
            <a href="{{ url('admin/verification/verify/'.$store->id) }}" class="btn btn-success btn-sm">Verifikasi</a>
            <a href="{{ url('admin/verification/reject/'.$store->id) }}" class="btn btn-danger btn-sm">Tolak</a>
        </td>
    </tr>
    @endforeach
</table>

@endsection
