@extends('layouts.app')
@section('content')
<div class="main-content x-lampiran">
    <section class="section">
      <div class="section-header">
        <h5>Dashboard</h5>
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
              @if (auth()->user()->level == 'kadis')
              <em><b>Pemberitahuan!</b>Aplikasi Sekelik ada beberapa update. Untuk data sudah saya backup</em>
              @elseif(auth()->user()->level == 'kabid')
              <em><b>Pemberitahuan!</b>Aplikasi Sekelik ada beberapa update. Untuk data sudah saya backup, jika ada data yang tidak sesuai silakan hubungi saya klik <span><a href="https://api.whatsapp.com/send?phone={{ env('NO_DEV') }}" target="_blank">Umaedi KH</a></span></em>
              @else
              <em><b>Hallo {{ auth()->user()->nama }}</b>, apa kabar Anda hari ini?</em>
              @endif
          </p>
      </div>
  </div>
  @if (auth()->user()->level !== env('ROLE_STAF'))
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
          <a href="/profile" style="text-decoration: none">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary x-avatar">
             <img data-src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->img) }}" class="lazyload" alt="profile" width="100">
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Data Diri</h4>
              </div>
              <div class="card-body">
                @if (strlen(auth()->user()->nama) > 16)
                    {{ Str::of(auth()->user()->nama)->limit(16) }}
                @else
                {{ auth()->user()->nama }}
                @endif
              </div>
            </div>
          </div>
        </a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
          <a href="/tugas" style="text-decoration: none">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-laptop"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Tugas</h4>
              </div>
              <div class="card-body">
               {{ $riwayat_tugas }}
              </div>
            </div>
          </div>
        </a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
            <a href="/pegawai" style="text-decoration: none">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="fas fa-users"></i>
                </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Data Pegawai</h4>
                </div>
                <div class="card-body">
                 {{ $user }}
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
              <h4>{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</h4>
              <div class="notif">
                <a href="/tugas/show_lists" type="button" class="btn btn-primary">
                    LIHAT SEMUA
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
  @else
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <a href="/profile" style="text-decoration: none">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <img data-src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->img) }}" class="lazyload" alt="profile" width="100">
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Data diri</h4>
          </div>
          <div class="card-body">
            @if (strlen(auth()->user()->nama) > 16)
            {{ Str::of(auth()->user()->nama)->limit(16) }}
            @else
            {{ auth()->user()->nama }}
            @endif
          </div>
        </div>
      </div>
    </a>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <a href="/tugas/show_lists" style="text-decoration: none">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-laptop"></i>
          </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Riwayat Tugas</h4>
          </div>
          <div class="card-body">
            {{ $riwayat_tugas }}
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
          <h4>LAPORAN HARIAN</h4>
          <div class="notif">
            <button type="button" class="btn btn-primary">
                Selesai <span class="badge badge-transparent">{{ $riwayat_tugas }}</span>
            </button>
        </div>
        </div>
        <div class="card">
          <div class="card-body">
            <form id="store">
              @csrf
                <div class="form-group">
                  <label for="nama_tugas">Tugas yang dikerjakan</label>
                  <input type="text" class="form-control" id="nama_tugas" name="nama_tugas">
                </div>
                <div class="form-group">
                  <label for="fileuploadInput">Photo/Lampiran</label>
                  <input type="file" class="form-control my-image-field" id="fileuploadInput"  accept=".png, .jpg, .jpeg" name="lampiran">
                </div>
                <div class="form-group">
                  <label for="lampiran">Keterangan</label>
                  <textarea class="form-control" style="height: 20%" name="keterangan" id="lampiran"></textarea>
                </div>
                  @include('layouts._loading_submit')
                  <button id="btn_submit" type="submit" class="btn btn-primary btn-block">BUAT LAPORAN</button>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  </section>
</div>

<!-- Modal -->
@include('modal.index')

@endsection
@push('js')
<script type="text/javascript" src="{{ asset('js/compresImage.js') }}"></script>
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
                    page: page,
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

   //paginate
    function loadPaginate(to) {
        page = to
        loadData()
    }
    //submit
    $('#store').submit(async function store(e) {
          e.preventDefault();

          var form 	= $(this)[0]; 
          var data 	= new FormData(form);

          var param = {
              method: 'POST',
              url: '/tugas/store',
              data: data,
              processData: false,
              contentType: false,
              cache: false,
          }

              loadingsubmit(true);
              await transAjax(param).then((res) => {
                  swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
                      loadingsubmit(false);
                      window.location.href = '/tugas/show_lists';
                  });
              }).catch((err) => {
                  loadingsubmit(false);
                  swal({text: err.responseJSON.message, icon: 'error', timer: 3000,});
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

      async function showTugas(id)
      {
        var param = {
          method: 'GET',
          url: '/tugas/show/'+id,
        }

        await transAjax(param).then((res) => {
          console.log(res);
          $('#x-modal').html(res)
        });
      }
    </script>
@endpush