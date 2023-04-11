@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Tambah Pegawai</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form id="store">
                        @csrf
                        <div class="form-group">
                          <label for="nip">NIP</label>
                          <input type="hidden" name="bagian_id" value="1">
                          <input type="number" class="form-control" id="nip" name="nip" required>
                        </div>
                        <div class="form-group">
                          <label for="name">Nama Lengkap</label>
                          <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                          <label for="golongan">Golongan</label>
                          <input type="text" class="form-control" id="golongan" name="golongan" required>
                        </div>
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                          <label for="no_tlp">No Telp</label>
                          <input type="number" class="form-control" id="no_tlp" name="no_tlp" required>
                        </div>
                        <div class="form-group">
                          <label for="password">Password</label>
                          <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                          <label for="golongan">Bagian</label>
                          <select class="form-control" id="golongan" name="bagian_id">
                            <option value="">--PILIH--</option>
                            @foreach ($bagians as $bagian)
                            <option value="{{ $bagian->id }}">{{ $bagian->nama_bagian }}</option> 
                            @endforeach
                          </select>
                        </div>
                        @include('layouts._loading_submit')
                        <button id="btn_submit" type="submit" class="btn btn-primary">Simpan</button>
                      </form>
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@push('js')
<script src="{{ asset('js') }}/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#store').submit(async function store(e) {
                e.preventDefault();

                var form 	= $(this)[0]; 
                var data 	= new FormData(form);

                var param = {
                    method: 'POST',
                    url: '/admin/pegawai/store',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                }

                    loadingsubmit(true);
                    await transAjax(param).then((res) => {
                        swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
                            loadingsubmit(false);
                            window.location.href = '/admin/pegawai';
                        });
                    }).catch((err) => {
                        loadingsubmit(false);
                        swal({text: err.responseJSON.message, icon: 'error', timer: 3000,}).then(() => {
                        window.location.href = '/admin/pegawai/tambah';
                    });
                });

                function loadingsubmit(state){
                    if(state) {
                        $('#btn_loading').removeClass('d-none');
                        $('#btn_submit').addClass('d-none');
                    }else {
                        $('#btn_loading').addClass('d-none');
                        $('#btn_submit').removeClass('d-none');
                    }
                }  
            });
        });
    </script>
@endpush