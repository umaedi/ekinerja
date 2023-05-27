<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api as Controller;
use App\Models\Bagian;
use App\Models\Golongan;
use App\Models\Pegawai;
use App\Models\Task;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    protected $pegawai;
    protected $task;
    protected $golongan;
    protected $bagian;
    public function __construct(Pegawai $pegawai, Golongan $golongan, Task $task, Bagian $bagian)
    {
        $this->pegawai = new CrudRepositories($pegawai);
        $this->task = new CrudRepositories($task);
        $this->bagian = new CrudRepositories($bagian);
        $this->golongan = new CrudRepositories($golongan);
    }

    public function index()
    {
        if (\request()->ajax()) {

            $pegawai = Pegawai::query();

            $page = request()->get('paginate', 10);

            if (\request('search')) {
                $pegawai->where('name', 'like', '%' . request('search') . '%');
            }

            if (\request('golongan_id')) {
                $pegawai->where('golongan_id', request('golongan_id'));
            }


            $data['table'] = $pegawai->paginate($page);
            return view('admin.pegawai._data_table', $data);
        }

        $data['title'] = 'Data Pegawai';
        return view('admin.pegawai.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Data Pegawai';
        $data['bagians'] = $this->bagian->getAll();
        return view('admin.pegawai.create', $data);
    }

    public function store(Request $request)
    {
        if (\request()->ajax()) {

            $request->validate([
                'nip'   => 'required|unique:pegawais',
                'email' => 'required|unique:pegawais',
            ]);

            $data = $request->except('_token');
            $this->pegawai->store($data);
            return $this->sendResponseCreate($data);
        }
    }

    public function show($id)
    {
        if (\request()->ajax()) {
            $task = $this->task->query();
            $data['table'] = $task->where('pegawai_id', $id)->limit(5)->get();
            return view('admin.pegawai._data_table_task', $data);
        };

        $data['pegawai'] = $this->pegawai->find($id);
        $data['bagians'] = $this->bagian->getAll();
        $data['title']  = 'Edit Pegawai';
        return view('admin.pegawai.show', $data);
    }

    public function update(Request $request, $id)
    {
        if (\request()->ajax()) {
            $data =  $this->pegawai->update($id, $request->all());
            return $this->sendResponseUpdate($data);
        }
    }

    public function destory($id)
    {
        if (\request()->ajax()) {
            $pegawai = $this->pegawai->find($id);
            $pegawai->destroy($id);
            return $this->sendResponseDelete($pegawai);
        }
    }
}
