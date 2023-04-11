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

            $data['table'] = $task->where('pegawai_id', auth()->guard('pegawai')->user()->id)->paginate($page);
            return view('pegawai.tugas._data_table', $data);
        }

        return view('pegawai.tugas.index');
    }

    public function store(Request $request)
    {
        if (\request()->ajax()) {
            $request->validate([
                'nama_tugas'    => 'required',
                'lampiran'      => 'file|mimes:jpg,jpeg,png,pdf,docx,xlsx|max:2048',
            ]);
        }

        if ($request->file('lampiran')) {
            $data = $request->except('_token');
            $data['pegawai_id'] = auth()->guard('pegawai')->user()->id;
            $data['bagian_id'] = auth()->guard('pegawai')->user()->bagian_id;
            $data['tanggal'] = date('Y-m-d, H:i:s');
            $this->task->store($data, true, 'public/lampiran');
        } else {
            $data = $request->except('_token');
            $data['pegawai_id'] = auth()->guard('pegawai')->user()->id;
            $data['bagian_id'] = auth()->guard('pegawai')->user()->bagian_id;
            $data['tanggal'] = date('Y-m-d, H:i:s');
            $this->task->store($data);
        }

        return $this->sendResponseCreate('');
    }

    public function show($id)
    {

        $data['task'] =  $this->task->find($id);
        return view('pegawai.tugas.show', $data);
    }
}
