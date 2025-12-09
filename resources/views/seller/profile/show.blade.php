@extends('seller.profile')

@section('title', 'Profil Toko')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
.container {
    max-width: 900px;
    margin: auto;
}

.profile-card {
    background: rgba(255,255,255,0.45);
    backdrop-filter: blur(12px);
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
}

.profile-header {
    text-align: center;
    margin-bottom: 25px;
}

.profile-header img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid #c96a7f;
    object-fit: cover;
}

.status {
    margin-top: 10px;
    display: inline-block;
    padding: 8px 20px;
    border-radius: 30px;
    font-weight: 600;
}

.pending { background: #f1c40f; color: #6b4d00; }
.approved { background: #2ecc71; color: #145a32; }
.rejected { background: #e74c3c; color: white; }

.section {
    margin-top: 30px;
}

.section h3 {
    color: #6b2b38;
    margin-bottom: 15px;
}

.info {
    margin-bottom: 10px;
}

.label {
    font-weight: 600;
    color: #6b2b38;
}

.actions {
    margin-top: 30px;
    display: flex;
    gap: 15px;
}

.btn {
    padding: 12px 25px;
    border-radius: 25px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
}

.btn-primary { background:#6b2b38; color:white; }
.btn-danger { background:#8b1e2e; color:white; }
</style>

<div class="container">

    <div class="profile-card">

        <div class="profile-header">
            <img src="{{ $store->logo 
                ? asset('storage/'.$store->logo) 
                : 'https://via.placeholder.com/120?text=LOGO' }}">

            <h2>{{ $store->name }}</h2>

            <span class="status {{ $store->status }}">
                {{ ucfirst($store->status) }}
            </span>
        </div>

        {{-- INFORMASI TOKO --}}
        <div class="section">
            <h3>Informasi Toko</h3>
            <div class="info"><span class="label">Deskripsi:</span> {{ $store->about }}</div>
            <div class="info"><span class="label">No. Telepon:</span> {{ $store->phone }}</div>
            <div class="info"><span class="label">Kota:</span> {{ $store->city }}</div>
            <div class="info"><span class="label">Alamat:</span> {{ $store->address }}</div>
            <div class="info"><span class="label">Kode Pos:</span> {{ $store->postal_code }}</div>
        </div>

        {{-- INFORMASI BANK --}}
        <div class="section">
            <h3>Informasi Rekening</h3>
            <div class="info"><span class="label">Bank:</span> {{ $store->bank_name ?? '-' }}</div>
            <div class="info"><span class="label">No Rekening:</span> {{ $store->bank_account_number ?? '-' }}</div>
            <div class="info"><span class="label">Atas Nama:</span> {{ $store->bank_account_name ?? '-' }}</div>
        </div>

        {{-- ACTION --}}
        <div class="actions">
            <a href="{{ route('seller.profile.edit') }}" class="btn btn-primary">
                Edit Profil
            </a>

            <form action="{{ route('seller.profile.delete') }}" method="POST"
                  onsubmit="return confirm('Yakin hapus toko?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Hapus Toko</button>
            </form>
        </div>

    </div>

</div>

@endsection
