<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\CrudRepositories;
use App\Http\Controllers\Api as Controller;

class TugasController extends Controller
{
    protected $task;
    public function __construct(Task $task)
    {
        $this->task = new CrudRepositories($task);
    }

    public function index()
    {
        if (\request()->ajax()) {
            $task = $this->task->query();
            $page = request()->get('paginate', 5);

            if (\request('bulan')) {
                $task->whereMonth('tanggal', request('bulan'));
            }

            if (auth()->guard('pegawai')->user()->role == 1) {
                $data['table'] = $task->where('role', 1)->orWhere('role', 2)->orWhere('role', 3)->latest()->paginate($page);
            } elseif (auth()->guard('pegawai')->user()->role == 2) {
                $data['table'] = $task->where('role', 2)->orWhere('role', 3)->latest()->paginate($page);
            } else {
                $data['table'] = $task->where('pegawai_id', auth()->guard('pegawai')->user()->pegawai_id)->latest()->paginate($page);
            }

            return view('pegawai.tugas._data_table', $data);
        }

        $data['title'] = 'Riwayat Tugas';
        return view('pegawai.tugas.index', $data);
    }

    public function store(Request $request)
    {
        if (\request()->ajax()) {
            $request->validate([
                'nama_tugas'    => 'required',
                'lampiran'      => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]);
        }

        $data = $request->except('_token');
        $data['pegawai_id'] = auth()->guard('pegawai')->user()->id;
        $data['bagian_id']  = auth()->guard('pegawai')->user()->bagian_id;
        $data['role']       = auth()->guard('pegawai')->user()->role;
        $data['tanggal']    = now();

        DB::beginTransaction();

        try {
            $this->task->store($data, true, 'public/lampiran');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponseError($th);
        }

        DB::commit();

        return $this->sendResponseCreate($data);
    }

    public function show($id)
    {

        $data['task'] =  $this->task->find($id);
        $data['title'] = 'Detail Tugas';
        return view('pegawai.tugas.show', $data);
    }
}
