<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\Golongan;
use App\Http\Controllers\Controller;
use App\Models\Bagian;
use App\Repositories\CrudRepositories;

class TugasController extends Controller
{
    protected $task;
    protected $bagian;
    public function __construct(Task $task, Bagian $bagian)
    {
        $this->task = new CrudRepositories($task);
        $this->bagian = new CrudRepositories($bagian);
    }

    public function index()
    {
        if (\request()->ajax()) {
            $task = $this->task->query();
            $page = request()->get('paginate', 10);

            if (request('bagian_id')) {
                $task->where('bagian_id', request('bagian_id'));
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

        $data['title'] = 'Laporan Tugas Pegawai';
        $data['bagians'] = $this->bagian->getAll();
        return view('admin.tugas.index', $data);
    }

    public function show($id)
    {
        $data['task'] = $this->task->find($id);
        $data['title'] = 'Data Laporan Tugas Pegawai';
        return view('admin.tugas.show', $data);
    }
}
