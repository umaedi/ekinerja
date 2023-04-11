<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\PegawaiImport;
use App\Http\Controllers\Api as Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        $data['title'] = 'Import Data Pegawai';
        return view('admin.import.index', $data);
    }

    public function store(Request $request)
    {
        if (\request()->ajax()) {
            $request->validate([
                'file'  => 'required|mimes:csv,xls,xlsx'
            ]);

            Excel::import(new PegawaiImport(), $request->file('file'));
            return $this->sendResponseCreate('query oke');
        }
    }
}
