<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Task;
use App\Repositories\CrudRepositories;

class DashboardController extends Controller
{
    protected $task;
    public function __construct(Task $task)
    {
        $this->task = new CrudRepositories($task);
    }

    public function index()
    {
        $task = $this->task->query();
        if (\request()->ajax()) {

            $data['table'] = $task->whereDate('tanggal', '=', date('Y-m-d'))->paginate(10);
            return view('admin.dashboard._data_table_task', $data);
        };

        $data['pegawai'] = Pegawai::count();
        $data['tasks'] = $task->whereDate('tanggal', '=', date('Y-m-d'))->count();
        $data['tasks_admin'] = $task->where('pegawai_id', auth()->user()->user_id)->count();
        return view('admin.dashboard.index', $data);
    }
}
