<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topup;

class TopupController extends Controller
{
    public function index()
    {
        return view('member.topup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        $va = "8989" . rand(10000000, 99999999); // generate VA

        Topup::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'va_number' => $va,
            'status' => 'pending'
        ]);

        return redirect()->route('member.topup')
            ->with('success', "Top-up berhasil! Silakan lanjutkan pembayaran ke VA <b>$va</b>.");
    }
}
