<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|confirmed',
            'old_password' => 'required',
        ]);

        if (Hash::check($data['old_password'], auth()->user()->password) && auth()->user()->update([
            'password' => bcrypt($data['password']),
        ])) {
            return redirect()->back()->with('success', 'Password Changed Successfully.');
        }

        return redirect()->back()->with('error', 'Old Password Doesn\'t Matched.');
    }
}
