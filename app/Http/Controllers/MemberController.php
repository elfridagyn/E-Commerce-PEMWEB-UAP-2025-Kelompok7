<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return view('member.dashboard');
    }

    public function profile()
    {
        return "Halaman profil member.";
    }

    public function products()
    {
        return "Daftar produk member.";
    }

    public function transactions()
    {
        return "Riwayat transaksi member.";
    }
}
