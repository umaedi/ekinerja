@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section x-lampiran">
      <div class="section-header">
        <h1>Laporan Tugas</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_pegawai">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_pegawai" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="nama_pegawai">Pangkat/Golongan</label>
                        <input type="text" class="form-control" id="nama_pegawai" value="{{ auth()->user()->bagian }}">
                    </div>
                    <div class="form-group">
                        <label for="nama_tugas">Nama Tugas</label>
                        <input type="text" class="form-control" id="nama_tugas" value="{{ $task->nama_tugas }}">
                    </div>
                    <div class="form-group">
                        <label for="nama_tugas">Tanggal</label>
                        <input type="text" class="form-control" id="nama_tugas" value="{{ $task->tanggal }}">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" style="height: 20%" name="keterangan" id="ketrangan">{{ $task->keterangan }}</textarea>
                    </div>
                    @if (!empty($task->lampiran))
                    <div class="form-group">
                        <label for="lampiran">Lampiran</label>
                        <a class="lightbox btn btn-success btn-block" href="{{ asset('storage/lampiran/' .  $task->lampiran ) }}">Lihat</a>
                    </div>
                    @else
                    <button class="btn btn-success btn-block" disabled>Tanpa Lampiran</button>
                    @endif
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection