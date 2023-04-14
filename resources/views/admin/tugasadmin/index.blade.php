@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section x-lampiran">
      <div class="section-header">
        <h1>Buat Laporan</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>LAPORAN TUGAS</h4>
                <div class="notif">
                  <button type="button" class="btn btn-primary">
                      Selesai <span class="badge badge-transparent">3</span>
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
                        <label for="lampiran">Photo/Lampiran</label>
                        <input type="file" class="form-control" id="lampiran" name="lampiran">
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
    </section>
  </div>
@endsection
@push('js')
<script type="text/javascript">
    var page = 1;
    var paginate = 5;
    var bulan = '';
    $(document).ready(function() {
        loadData();

        $('#bulan').change(function() {
            filterTable();
        });

        $('#perPage').change(function() {
            filterTable();
        });
    });

    function filterTable()
    {
        bulan = $('#bulan').val();
        paginate = $('#perPage').val();
        loadData();
    }

    async function loadData() {
        var param = {
            method: 'GET',
            url: '{{ url()->current() }}',
            data: {
                load: 'table',
                bulan: bulan,
                paginate: paginate,
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


    //store tugas
    $('#store').submit(async function store(e) {
        e.preventDefault();

        var form 	= $(this)[0]; 
        var data 	= new FormData(form);

        var param = {
            method: 'POST',
            url: '/admin/tugas/store',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
        }

            loadingsubmit(true);
            await transAjax(param).then((res) => {
                swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
                    loadingsubmit(false);
                    window.location.href = '/admin/tugas';
                });
            }).catch((err) => {
                loadingsubmit(false);
                swal({text: err.responseJSON.message, icon: 'error', timer: 3000,}).then(() => {
                window.location.href = '/admin/tugas';
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
  }
  
</script>
@endpush