@extends('layouts.app')
@section('content')
<div class="main-content x-lampiran">
    <section class="section">
      <div class="section-header">
        <h1>Dashboard</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="alert alert-light alert-dismissible alert-has-icon" id="alert-1" style="background-color: #e3eaef42">
      <div class="alert-icon"><i class="fas fa-bullhorn"></i></div>
      <div class="alert-body mt-1">
          <button class="close" data-dismiss="alert">
              <span>x</span>
          </button>
          <p class="text-justify pr-5">
              {{-- <em><b>Hallo {{ auth()->user()->name }}</b>, apa kabar Anda hari ini?</em> --}}
              <em><b>Perhatian!</b> Izin pak, untuk sementara waktu bapak blm bisa membuat laporan tugas karena sedang saya perbaiki</em>
          </p>
      </div>
  </div>
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
          <a href="{{ route('admin.profile') }}" style="text-decoration: none">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Kapala Dinas</h4>
              </div>
              <div class="card-body">
                {{ auth()->user()->name }}
              </div>
            </div>
          </div>
        </a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
          <a href="{{ route('admin.tugas') }}" style="text-decoration: none">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-laptop"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Riwayat Tugas</h4>
              </div>
              <div class="card-body">
                {{ $tasks_admin }}
              </div>
            </div>
          </div>
        </a>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
          <a href="{{ route('admin.pegawai.index') }}" style="text-decoration: none">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-users"></i>
              </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Data Pegawai</h4>
              </div>
              <div class="card-body">
                {{ $pegawai }}
              </div>
            </div>
          </div>
        </a>
        </div>

      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4>Laporan Tugas </h4>
              <div class="notif">
                <button type="button" class="btn btn-primary">
                    Selesai <span class="badge badge-transparent">{{ $tasks }}</span>
                </button>
                <a href="/admin/pegawai/tugas" type="button" class="btn btn-primary">
                    Lihat
                </a>
            </div>
            </div>
            <div class="card">
              @include('layouts._loading')
                <div class="table-responsive" id="x-data-table">
                
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@push('js')
    <script type="text/javascript">
    var page = 1;
        $(document).ready(function() {
            loadData();
        });

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

        function loadPaginate(to) {
          page = to
          filterTable()
        }
      }
      setInterval(() => {
          loadData();
        }, 5000);

    //paginate
    function loadPaginate(to) {
        page = to
        filterTable()
    }
    //submit

    $('#store').submit(async function store(e) {
                e.preventDefault();

                var form 	= $(this)[0]; 
                var data 	= new FormData(form);

                var param = {
                    method: 'POST',
                    url: '/pegawai/tugas/store',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                }

                    loadingsubmit(true);
                    await transAjax(param).then((res) => {
                        swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
                            loadingsubmit(false);
                            window.location.href = '/pegawai';
                        });
                    }).catch((err) => {
                        loadingsubmit(false);
                        swal({text: err.responseJSON.message, icon: 'error', timer: 3000,}).then(() => {
                        window.location.href = '/pegawai';
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
    </script>
@endpush