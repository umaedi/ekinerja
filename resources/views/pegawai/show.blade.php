@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
          <div class="breadcrumb-item">Profile</div>
        </div>
      </div>
      <div class="section-body">
        <div class="row mt-sm-4">
          <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget">
              <div class="profile-widget-header">
                <img alt="image" src="{{ url($pegawai->img) }}" class="rounded-circle profile-widget-picture">
              </div>
            </div>
            <div class="card">
                  <div class="card-header">
                    <h4>Data Diri {{ $pegawai->nama }}</h4>
                  </div>
                  <div class="card-body">
                      <form id="update-data">
                        @csrf
                        @method('PUT')
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" id="nip" value="{{ $pegawai->nip }}" name="nip">
                            </div>
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" value="{{ $pegawai->nama }}" name="nama">
                            </div>
                            @if ($pegawai->level == 'sekdin')
                            <div class="form-group">
                              <label for="jabatan">Jabatan</label>
                              <select class="form-control" id="jabatan" name="level" onchange="showInput(this.value)">
                                <option value="sekdin">Skretaris Dinas</option>
                                <option value="kabid">Kepala Bidang</option>
                                <option value="staf">Staf</option>
                              </select>
                            </div>
                            <div class="x-bidang d-none form-group">
                              <label for="kabid">Bidang</label>
                              <select class=" form-control" id="bidang" name="bidang_id">
                                @foreach ($bidang as $bd)
                                <option value="{{ $bd->id }}">{{ $bd->nama_bidang }}</option>
                                @endforeach
                              </select>
                            </div>
                            @elseif($pegawai->level == 'kabid') 
                            <div class="form-group">
                              <label for="kabid">Jabatan</label>
                              <select class="form-control" id="jabatan" name="level" onchange="showInput(this.value)">
                                <option value="kabid">Kepala Bidang</option>
                                <option value="sekdin">Skretaris Dinas</option>
                                <option value="staf">Staf</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="kabid">Bidang</label>
                              <select class="form-control" id="bidang" name="bidang_id">
                                <option value="{{ $pegawai->bidang_id }}">{{ $pegawai->bidang->nama_bidang }}</option>
                                @foreach ($bidang as $bd)
                                <option value="{{ $bd->id }}">{{ $bd->nama_bidang }}</option>
                                @endforeach
                              </select>
                            </div>
                            @else 
                            <div class="form-group">
                              <label for="kabid">Jabatan</label>
                              <select class="form-control" id="jabatan" name="level" onchange="showInput(this.value)">
                                <option value="staf">Staf</option>
                                <option value="kabid">Kepala Bidang</option>
                                <option value="sekdin">Skretaris Dinas</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="kabid">Bidang</label>
                              <select class="x-bidang form-control" id="bidang" name="bidang_id">
                                <option value="{{ $pegawai->bidang_id }}">{{ $pegawai->bidang->nama_bidang }}</option>
                                @foreach ($bidang as $bd)
                                <option value="{{ $bd->id }}">{{ $bd->nama_bidang }}</option>
                                @endforeach
                              </select>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ $pegawai->email }}" name="email">
                            </div>
                            <div class="form-group">
                                <label for="no_tlp">No Tlp</label>
                                <input type="number" class="form-control" id="no_tlp" value="{{ $pegawai->no_tlp }}" name="no_tlp">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password">
                            </div>
                            @if (auth()->user()->level == 'kadis')
                            @include('layouts._loading_submit')
                            <button type="submit" class="btn btn-primary x-btn ">SIMPAN PERUBAHAN</button>
                            <a href="javascript:void(0)" onclick="hapus({{ $pegawai->id }})" class="btn btn-danger x-btn">HAPUS</a>
                            @endif
                      </form>
                  </div>
              </div>
          </div>
          <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
                <div class="card-header">
                  <h4>Laporan Tugas 1 Minggu Terakhir</h4>
                </div>
                @include('layouts._loading')
                <div class="card-body" id="x-data-table">
                  
                </div>
                <div class="card-footer text-right">
                  <a href="/tugas/show_list/{{ $pegawai->id }}" class="btn btn-primary">LIHAT SEMUA</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- Modal -->
@include('modal.index')
@endsection
@push('js')
<script src="{{ asset('js') }}/sweetalert.min.js"></script>
    <script type="text/javascript">
         $(document).ready(function() {
            loadData();

        });

        function filterTable() {
            loadData();
        }

        async function loadData() {
            var param = {
                method: 'GET',
                url: '{{ url()->current() }}',
                data: {
                    load: 'table',
                }
            }
            loading(true);
            await transAjax(param).then((result) => {
                loading(false);
                $('#x-data-table').html(result)

            }).catch((err) => {
              loading(false);
              console.log('error');
        });

        function loading(state) {
            if(state) {
                $('#loading').removeClass('d-none');
            } else {
                $('#loading').addClass('d-none');
            }
        }
    }

    $('#update-data').submit(async function update(e) {
        e.preventDefault();

        var form 	= $(this)[0]; 
        var data 	= new FormData(form);

        var param = {
            method: 'POST',
            url: '/profile/update/{{ $pegawai->id }}',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
        }

        loadingsubmit(true);
            await transAjax(param).then((res) => {
              loadingsubmit(false);
                swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
                    window.location.href = '/pegawai';
                });
            }).catch((err) => {
                loadingsubmit(false);
                swal({text: err.responseJSON.message, icon: 'error', timer: 3000,});
        });

        function loadingsubmit(state){
            if(state) {
                $('#btn_loading').removeClass('d-none');
                $('.x-btn').addClass('d-none');
            }else {
                $('#btn_loading').addClass('d-none');
                $('.x-btn').removeClass('d-none');
            }
        }  
    });

    function hapus(id) {
      swal({
        title: "",
        text: "Hapus data pegawai?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
          return new Promise(async function(resolve) {
            var param = {
                    method: 'POST',
                    url: '/admin/pegawai/destory/'+id,
                    data: {
                        '_method': 'DELETE'
                    }
                }

          await transAjax(param).then((res) => {
                  swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
                      // loadingsubmit(false);
                      window.location.href = '/admin/pegawai';
                  });
              }).catch((err) => {
                  loadingsubmit(false);
                  swal({text: err.responseJSON.message, icon: 'error', timer: 3000,}).then(() => {
                  window.location.href = '/pegawai/tambah';
              });
            });
          });
        }
    });
  }

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
          $('.x-bidang').addClass('d-none');
      break;
      }
      
  }

  async function showTugas(id)
  {
    var param = {
      method: 'GET',
      url: '/tugas/show/'+id,
    }

    await transAjax(param).then((res) => {
      $('#x-modal').html(res)
    });
  }
</script>
@endpush