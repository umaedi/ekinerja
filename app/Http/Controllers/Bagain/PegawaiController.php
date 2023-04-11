<?php

namespace App\Http\Controllers\Bagain;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use App\Models\Pegawai;
use App\Models\Task;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    protected $golongan;
    protected $pegawai;
    protected $task;
    public function __construct(Golongan $golongan, Pegawai $pegawai, Task $task)
    {
        $this->golongan = new CrudRepositories($golongan);
        $this->pegawai = new CrudRepositories($pegawai);
        $this->task = new CrudRepositories($task);
    }

    public function index()
    {
        if (\request()->ajax()) {
            $user = auth()->guard('pegawai')->user();
            $pegawai = $this->pegawai->query();

            $page = request()->get('paginate', 10);

            if (\request('search')) {
                $pegawai->where('name', 'like', '%' . request('search') . '%');
            }

            if ($user->role === 3) {
                # code...
                $data['table'] = $pegawai->paginate($page);
            } else {
                # code...
                $data['table'] = $pegawai->where('bagian_id', $user->bagian_id)->paginate($page);
            }

            return view('bagian.pegawai._data_table', $data);
        }

        $data['title'] = 'Data Pegawai';
        return view('bagian.pegawai.index', $data);
    }

    public function show($id)
    {
        if (\request()->ajax()) {
            $task = $this->task->query();
            $data['table'] = $task->where('pegawai_id', $id)->limit(5)->get();
            return view('admin.pegawai._data_table_task', $data);
        };

        $data['title'] = 'Detail Data Pegagwai';
        $data['pegawai'] = $this->pegawai->find($id);
        return view('bagian.pegawai.show', $data);
    }
}
