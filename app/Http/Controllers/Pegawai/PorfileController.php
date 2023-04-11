<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Api as Controller;
use App\Models\Pegawai;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class PorfileController extends Controller
{
    protected $pegawai;
    public function __construct(Pegawai $pegawai)
    {
        $this->pegawai = new CrudRepositories($pegawai);
    }

    public function index()
    {
        $data['title'] = 'Profile Pegawai';
        return view('pegawai.profile.index', $data);
    }

    public function update(Request $request, $id)
    {
        if ($request->file('img')) {
            $this->pegawai->updateProfile($id, $request->all('_token'), true, 'public/img/pegawai');
        } else {
            $this->pegawai->updateProfile($id, $request->except('_token'));
        }
        return $this->sendResponseUpdate($id);
    }
}
