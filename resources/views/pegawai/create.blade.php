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
                            <label for="jabatan">Jabatan</label>
                            <select class="form-control" id="jabatan" name="level" onchange="showInput(this.value)">
                              <option value="">--PILIH--</option>
                              <option value="sekdin">Skretaris Dinas</option>
                              <option value="kabid">Kepala Bidang</option>
                              <option value="staf">Staf</option>
                            </select>
                        </div>
                        <div class="form-group x-bidang d-none">
                            <label for="bidang">Bidang</label>
                            <select class="form-control" id="bidang" name="bidang_id">
                              <option value="">--PILIH--</option>
                              @foreach ($bidang as $bd)
                              <option value="{{ $bd->id }}">{{ $bd->nama_bidang }}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                          <label for="nip">NIP</label>
                          <input type="number" class="form-control" id="nip" name="nip" required>
                        </div>
                        <div class="form-group">
                          <label for="name">Nama Lengkap</label>
                          <input type="text" class="form-control" id="name" name="nama" required>
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
                        @include('layouts._loading_submit')
                        <button id="btn_submit" type="submit" class="btn btn-primary">SIMPAN</button>
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
                    url: '/pegawai/store',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                }

                    loadingsubmit(true);
                    await transAjax(param).then((res) => {
                      loadingsubmit(false);
                        // swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
                        //     window.location.href = '/pegawai';
                        // });
                    }).catch((err) => {
                        loadingsubmit(false);
                        // swal({text: err.responseJSON.message, icon: 'error', timer: 3000,}).then(() => {
                        // window.location.href = '/pegawai/create';
                    // });
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

        function showInput(value)
        {
            switch(value) {
            case 'kabid':
                $('.x-bidang').removeClass('d-none');
            break;
                case 'staf':
                $('.x-bidang').removeClass('d-none');
            break;
                default:
                console.log("ok");
            break;
            }
            
        }
    </script>
@endpush