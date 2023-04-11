<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Task;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class DahsboardController extends Controller
{
    protected $task;
    protected $pegagwai;
    public function __construct(Task $task, Pegawai $pegawai)
    {
        $this->task = new CrudRepositories($task);
        $this->pegagwai = new CrudRepositories($pegawai);
    }
    public function index()
    {
        $task = $this->task->query();
        $pegawai = auth()->guard('pegawai')->user();
        if (\request()->ajax()) {
            dd('ok');
        };

        $data['title'] = 'Pegawai';
        $data['task'] = $task->where('pegawai_id', $pegawai->id)->whereDate('created_at', '=', date('Y-m-d'))->count();
        $data['riwayat_task'] = Task::where('pegawai_id', $pegawai->id)->count();

        if ($pegawai->role === 3) {
            # code...
            $data['pegawai'] = $this->pegagwai->query()->where('role', 1)->orWhere('role', 2)->count();
        } else {
            # code...
            $data['pegawai'] = $this->pegagwai->query()->where('bagian_id', $pegawai->bagian_id)->where('role', 1)->count();
        }

        return view('pegawai.dashboard.index', $data);
    }
}
