<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\Golongan;
use App\Http\Controllers\Controller;
use App\Repositories\CrudRepositories;

class TugasController extends Controller
{
    protected $task;
    protected $golongan;
    public function __construct(Task $task, Golongan $golongan)
    {
        $this->task = new CrudRepositories($task);
        $this->golongan = new CrudRepositories($golongan);
    }

    public function index()
    {
        if (\request()->ajax()) {
            $task = $this->task->query();
            $page = request()->get('paginate', 10);

            if (request('golongan_id')) {
                $task->where('golongan_id', request('golongan_id'));
            }

            if (request('id')) {
                $task->where('pegawai_id', request('id'));
            }

            if (\request('bulan')) {
                $task->whereMonth('tanggal', request('bulan'));
            }

            $data['table'] = $task->paginate($page);
            return view('admin.dashboard._data_table_task', $data);
        }

        $data['golongans'] = $this->golongan->get();
        $data['title'] = 'Laporan Tugas Pegawai';
        return view('admin.tugas.index', $data);
    }

    public function show($id)
    {
        $data['task'] = $this->task->find($id);
        $data['title'] = 'Data Laporan Tugas Pegawai';
        return view('admin.tugas.show', $data);
    }
}
