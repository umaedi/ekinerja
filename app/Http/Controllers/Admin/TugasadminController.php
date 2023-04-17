<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Api as Controller;
use App\Repositories\CrudRepositories;

class TugasadminController extends Controller
{

    protected $task;
    public function __construct(Task $task)
    {
        $this->task = new CrudRepositories($task);
    }
    public function index()
    {
        if (\request()->ajax()) {
            dd('ok');
        }

        $data['tasks'] = $this->task->query()->where('pegawai_id', auth()->user()->user_id)->count();
        $data['title'] = 'Buat Laporan';
        return view('admin.tugasadmin.index', $data);
    }

    public function store(Request $request)
    {
        if (\request()->ajax()) {
            $request->validate([
                'nama_tugas'    => 'required',
                'lampiran'      => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]);
        }

        if ($request->file('lampiran')) {
            $data = $request->except('_token');
            $data['pegawai_id'] = auth()->user()->user_id;
            $data['bagian_id'] = auth()->user()->bagian_id;
            $data['tanggal'] = date('Y-m-d, H:i:s');
            $this->task->store($data, true, 'public/lampiran');
        } else {
            $data = $request->except('_token');
            $data['pegawai_id'] = auth()->user()->user_id;
            $data['bagian_id'] = auth()->user()->bagian_id;
            $data['tanggal'] = date('Y-m-d, H:i:s');
            $this->task->store($data);
        }

        return $this->sendResponseCreate('');
    }

    public function show($id)
    {
        $data['task'] =  $this->task->find($id);
        $data['title'] = 'Detail Tugas';
        return view('admin.tugasadmin.show', $data);
    }
}
