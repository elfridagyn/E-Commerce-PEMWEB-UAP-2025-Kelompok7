@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Daftar Metode Pengiriman</h2>

    <a href="{{ route('shipping_types.create') }}" class="btn btn-primary mb-3">
        + Tambah Metode Pengiriman
    </a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pengiriman</th>
                <th>Biaya</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shippingTypes as $index => $type)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $type->name }}</td>
                    <td>Rp {{ number_format($type->cost, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('shipping_types.edit', $type->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('shipping_types.destroy', $type->id) }}" 
                              method="POST" 
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus metode ini?')" 
                                    class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if ($shippingTypes->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">Belum ada metode pengiriman.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
