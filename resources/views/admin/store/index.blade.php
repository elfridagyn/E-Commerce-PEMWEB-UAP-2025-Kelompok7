@extends('layouts.admin')

@section('content')
<h3>Verifikasi Toko</h3>

<table class="table">
    <tr>
        <th>Nama Toko</th>
        <th>Pemilik</th>
        <th>Telepon</th>
        <th>Aksi</th>
    </tr>

    @foreach($stores as $store)
    <tr>
        <td>{{ $store->store_name }}</td>
        <td>{{ $store->user->name }}</td>
        <td>{{ $store->phone }}</td>
        <td>
            <a href="{{ route('admin.store.approve', $store->id) }}" class="btn btn-success">Approve</a>
            <a href="{{ route('admin.store.reject', $store->id) }}" class="btn btn-danger">Reject</a>
        </td>
    </tr>
    @endforeach
</table>
@endsection
