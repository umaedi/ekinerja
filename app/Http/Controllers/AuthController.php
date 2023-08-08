<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (auth()->guard('pegawai')->check()) {
            return redirect('/dashboard');
        } else {
            return view('auth.index');
        }
    }

    public function login(Request $request)
    {

        if (\request()->ajax()) {

            $credentials = $request->validate([
                'email' => 'required',
                'password'  => 'required'
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return response()->json([
                    'success'   => true,
                    'message'   => 'Anda berhasil login',
                ], 200);
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Email Atau Password Salah!',
            ], 302);
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'success'   => true,
            'message'   => 'Anda berhasil logout'
        ], 200);
    }
}
