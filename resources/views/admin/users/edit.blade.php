@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<h3>Edit User</h3>

<form action="/admin/users/{{ $user->id }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="seller" {{ $user->role == 'seller' ? 'selected' : '' }}>Seller</option>
            <option value="buyer" {{ $user->role == 'buyer' ? 'selected' : '' }}>Buyer</option>
        </select>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection
