<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //export
    public function index()
    {
        return Excel::download(new UserExport, 'user.xlsx');
    }
}
