<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Api as Controller;
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

    public function index()
    {
        if (\request()->ajax()) {
            $task = $this->task->query();
            $page = request()->get('paginate', 5);

            if (\request('bulan')) {
                $task->whereMonth('tanggal', request('bulan'));
            }

            $data['table'] = $task->where('pegawai_id', auth()->guard('pegawai')->user()->id)->latest()->paginate($page);
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
        $data['bagian_id'] = auth()->guard('pegawai')->user()->bagian_id;
        $data['tanggal'] = date('Y-m-d, H:i:s');
        $this->task->store($data, true, 'public/lampiran');

        return $this->sendResponseCreate('');
    }

    public function show($id)
    {

        $data['task'] =  $this->task->find($id);
        $data['title'] = 'Detail Tugas';
        return view('pegawai.tugas.show', $data);
    }
}
