<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class MemberProfileController extends Controller
{
    public function edit()
    {
        return view('member.profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
{
    $user = auth()->user();

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('storage/profile'), $filename);

        $user->profile_picture = $filename;
    }

    $user->name  = $request->name;
    $user->email = $request->email;

    $user->save();

    return back()->with('success', 'Profil berhasil diperbarui!');
}

}