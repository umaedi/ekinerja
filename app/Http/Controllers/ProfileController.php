<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\PegawaiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api as Controller;

class ProfileController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = new PegawaiService($user);
    }
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');

        DB::beginTransaction();

        try {
            $this->user->update($id, $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponseError($th);
        }

        DB::commit();
        return $this->sendResponseUpdate($data);
    }
}
