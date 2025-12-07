@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<h3 class="mb-3">Manajemen User</h3>

<a href="/admin/users/create" class="btn btn-primary mb-3">Tambah User</a>

<table class="table table-striped">
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role }}</td>
        <td>
            <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-warning btn-sm">Edit</a>

            <form action="/admin/users/{{ $user->id }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
