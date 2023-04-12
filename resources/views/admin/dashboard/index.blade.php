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
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
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

        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
          <a href="{{ route('admin.pegawai.index') }}" style="text-decoration: none">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="far fa-user"></i>
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
                    Selesai <span class="badge badge-transparent">{{ $task }}</span>
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
    </script>
@endpush