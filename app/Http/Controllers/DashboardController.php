<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $level = Auth::user()->level;
        if (\request()->ajax()) {
            $task = Task::query();
            $page = request()->get('paginate', 10);

            if ($level == 'kadis') {
                $data['table'] = $task->whereDate('created_at', date('Y-m-d'))->paginate($page);
            } elseif ($level == 'sekdin') {
                $data['table'] = $task->whereDate('created_at', date('Y-m-d'))->where('level', '!=', 'kadis')->paginate($page);
            } elseif ($level == 'kabid') {
                $data['table'] = $task->whereDate('created_at', date('Y-m-d'))->where('bidang_id', auth()->user()->bidang_id)->paginate($page);
            } else {
                $data['table'] = $task->where('user_id', auth()->user()->id)->latest()->paginate($page);
            }

            return view('dashboard._data_table', $data);
        }

        $user = User::query();
        if ($level == 'kadis') {
            $data['user'] = $user->where('level', '!=', 'kadis')->count();
        } elseif ($level == 'sekdin') {
            $data['user'] = $user->where('level', '!=', 'sekdin')->count();
        } else {
            $data['user'] = $user->where('bidang_id', auth()->user()->bidang_id)->count();
        }
        $data['title'] = 'Dashboard';
        $data['riwayat_tugas'] = Task::where('user_id', auth()->user()->id)->count();
        return view('dashboard.index', $data);
    }
}
