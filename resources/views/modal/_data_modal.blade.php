<div class="form-group">
    <label>Lampiran</label>
    <img data-src="{{ \Illuminate\Support\Facades\Storage::url($model->lampiran) }}" class="lazyload img-thumbnail">
</div>
<div class="form-group">
    <label>Nama Pegawai</label>
    <input type="text" class="form-control" value="{{ $model->user->nama }}">
</div>
<div class="form-group">
    <label>Nama Tugas</label>
    <input type="text" class="form-control" value="{{ $model->nama_tugas }}">
</div>
<div class="form-group">
    <label>Tanggal</label>
    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($model->created_at)->isoFormat('D MMMM YYYY') }}">
</div>
<div class="form-group">
    <label>Keterangan</label>
    <textarea class="form-control">{{ $model->keterangan }}</textarea>
</div>