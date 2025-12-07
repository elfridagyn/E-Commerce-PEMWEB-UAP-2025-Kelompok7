@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftarkan Toko</h3>

    <form action="{{ route('seller.store.save') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Toko</label>
            <input type="text" name="store_name" class="form-control">
        </div>

        <div class="mb-3">
            <label>No Telepon</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
