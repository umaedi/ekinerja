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
            return redirect('/pegawai');
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

            $pegawai = Pegawai::where([
                'email'     => $request->email,
                'password'  => $request->password,
            ])->first();

            if (!$pegawai) {

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

            auth()->guard('pegawai')->login($pegawai);
            return response()->json([
                'success'   => true,
                'message'   => 'Anda berhasil login',
            ], 200);
        }
    }

    public function destroy(Request $request)
    {
        if (auth()->guard('pegawai')->user()) {
            Auth::guard('pegawai')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'success'   => true,
            'message'   => 'Anda berhasil logout'
        ], 200);
    }
}
