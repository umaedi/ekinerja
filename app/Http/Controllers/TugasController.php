<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Api as Controller;
use App\Services\TaskService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    protected $task;
    public function __construct(Task $task)
    {
        $this->middleware('auth');
        $this->task = new TaskService($task);
    }

    public function index()
    {
        if (\request()->ajax()) {
            $task = $this->task->Query();
            $page = request()->get('paginate', 10);
            if (\request('bulan')) {
                $task->whereMonth('tanggal', request('bulan'));
            }
            $data['table'] = $task->where('user_id', auth()->user()->id)->latest()->paginate($page);
            return view('tugas._data_table', $data);
        }
        $data['title'] = 'Tugas';
        return view('tugas.index', $data);
    }

    public function store(Request $request)
    {
        if (\request()->ajax()) {
            $data = $request->except('_token');
            $data['user_id'] = auth()->user()->id;
            $data['bidang_id'] = auth()->user()->bidang_id;
            $data['level'] = auth()->user()->level;
        }

        DB::beginTransaction();
        try {
            $this->task->store($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponseError($th);
        }
        DB::commit();
        return $this->sendResponseCreate($data);
    }

    public function show($id)
    {
        if (\request()->ajax()) {
            $data['model'] = $this->task->find($id);
            return view('modal._data_modal', $data);
        }
    }

    public function show_lists()
    {

        $user = Auth::user();
        if (\request()->ajax()) {
            $task = $this->task->query();
            $page = request()->get('paginate', 10);

            if (\request('bulan')) {
                $task->whereMonth('created_at', request('bulan'));
            }

            if ($user->level == 'sekdin') {
                $task = $task->where('level', '!=', 'kadis');
            } elseif ($user->level == 'kabid') {
                $task = $task->where('bidang_id', $user->bidang_id);
            } elseif ($user->level == 'staf') {
                $task = $task->where('user_id', $user->id);
            }

            $data['table'] = $task->latest()->paginate($page);
            return view('tugas._data_table', $data);
        }
        return view('tugas.histories');
    }

    public function show_list($id)
    {
        if (\request()->ajax()) {
            $task = $this->task->query();
            $page = request()->get('paginate', 10);

            if (\request('bulan')) {
                $task->whereMonth('created_at', request('bulan'));
            }

            $data['table'] = $task->where('user_id', $id)->paginate($page);
            return view('tugas._data_table', $data);
        }
        return view('tugas.histories');
    }
}
