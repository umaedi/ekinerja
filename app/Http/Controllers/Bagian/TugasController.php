<?php

namespace App\Http\Controllers\Bagian;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    protected $task;
    public function __construct(Task $task)
    {
        $this->task = new CrudRepositories($task);
    }

    public function show($id)
    {
        $data['title'] = 'Tugas Pegawai';
        $data['task'] = $this->task->find($id);
        return view('bagian.tugas.show', $data);
    }
}
