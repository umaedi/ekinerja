<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\CrudRepositories;
use App\Http\Controllers\Api as Controller;

class ProfileController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = new CrudRepositories($user);
    }

    public function index()
    {

        $data['title'] = 'Profile';
        return view('admin.profile.index', $data);
    }

    public function update(Request $request, $id)
    {
        if ($request->file('img')) {
            $this->user->updateProfile($id, $request->all('_token'), true, 'public/img/pegawai');
        } else {
            $this->user->updateProfile($id, $request->except('_token'));
        }
        return $this->sendResponseUpdate($id);
    }
}
