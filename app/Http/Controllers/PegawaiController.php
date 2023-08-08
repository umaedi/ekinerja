<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api as Controller;
use App\Models\Task;
use App\Services\PegawaiService;
use App\Services\TaskService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    protected $user;
    protected $task;
    public function __construct(User $user, Task $task)
    {
        $this->middleware('check.role');
        $this->user = new PegawaiService($user);
        $this->task = new TaskService($task);
    }
    public function index()
    {
        if (\request()->ajax()) {
            $level = auth()->user()->level;
            $user = $this->user->Query();

            $page = request()->get('paginate', 15);

            if (\request('search')) {
                $user->where('nama', 'like', '%' . request('search') . '%');
            }

            if ($level == 'kadis') {
                $data['table'] = $user->where('level', '!=', 'kadis')->paginate($page);
            } elseif ($level == 'sekdin') {
                $data['table'] = $user->where('level', '!=', 'kadis')->paginate($page);
            } else {
                $data['table'] = $user->where('bidang_id', auth()->user()->bidang_id)->paginate();
            }

            return view('pegawai._data_table', $data);
        }

        $data['title'] = 'Data Pegawai';
        return view('pegawai.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah data pegawai';
        $data['jabatan'] = \App\Models\Jabatan::all();
        $data['bidang'] = \App\Models\Bidang::all();
        return view('pegawai.create', $data);
    }

    public function store(Request $request)
    {
        if (\request()->ajax()) {
            $data = $request->except('_token');
            $data['password'] = Hash::make($data['password']);

            DB::beginTransaction();

            try {
                $this->user->store($data);
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->sendResponseError($th);
            }

            DB::commit();
            return $this->sendResponseCreate($data);
        }
    }

    public function show($id)
    {
        if (\request()->ajax()) {
            $task = $this->task->query();
            $data['table'] = $task->where('user_id', $id)->take(5)->get();
            return view('pegawai._data_table_task', $data);
        };

        $data['pegawai'] = $this->user->find($id);
        $data['title']  = 'Edit Pegawai';
        $data['bidang'] = \App\Models\Bidang::get();
        return view('pegawai.show', $data);
    }
}
