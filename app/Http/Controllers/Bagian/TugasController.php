<?php

namespace App\Http\Controllers\Bagian;

use App\Models\Task;
use App\Models\Bagian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    public function index($id)
    {
        if (\request()->ajax()) {
            $task = $this->task->query();
            $page = request()->get('paginate', 10);

            if (\request('bulan')) {
                $task->whereMonth('tanggal', request('bulan'));
            }

            $data['table'] = $task->where('pegawai_id', $id)->paginate($page);
            return view('pegawai.tugas._data_table_task', $data);
        }

        $data['title'] = 'Laporan Tugas Pegawai';
        $data['bagians'] = $this->bagian->getAll();
        return view('pegawai.tugas.index', $data);
    }

    public function show($id)
    {
        $data['task'] = $this->task->find($id);
        return view('pegawai.tugas.show', $data);
    }
}
