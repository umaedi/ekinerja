@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section x-lampiran">
      <div class="section-header">
        <h1>Tugas</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card mb-3">
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
                            <input type="file" class="form-control my-image-field" id="lampiran" name="lampiran">
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
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" id="bulan" name="bulan">
                                <option value="">--PERBULAN--</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="12">November</option>
                                <option value="12">Desember</option>
                              </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" id="perPage" name="paginate">
                                <option value="10">--PERHALAMAN--</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                              </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                @include('layouts._loading')
                <div class="table-responsive" id="x-data-table">
                
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
<script type="text/javascript" src="{{ asset('js/compresImage.js') }}"></script>
    <script type="text/javascript">
    var page = 1;
    var paginate = 10;
    var bulan = '';
    var bagian_id = '';
    var golongan = ''
        $(document).ready(function() {
            loadData();

            $('#perPage').change(() => {
                filterTable();
            });

            $('#bulan').change(function() {
                filterTable();
            });
        });

        function filterTable() {
            paginate = $('#perPage').val(); 
            bulan = $('#bulan').val();
            search = $('input[name=search]').val();
            bagian_id = $('select[name=bagian_id]').val();
            loadData();
        }

        async function loadData() {
            var param = {
                method: 'GET',
                url: '{{ url()->current() }}',
                data: {
                    load: 'table',
                    page: page,
                    paginate: paginate,
                    bulan: bulan,
                    bagian_id: bagian_id,
                    id: "{{ request('id') }}"
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
    }

    function loadPaginate(to) {
        page = to
        filterTable()
    }

    

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
                    window.location.href = '/tugas';
                });
            }).catch((err) => {
                loadingsubmit(false);
                swal({text: err.responseJSON.message, icon: 'error', timer: 3000,}).then(() => {
                window.location.href = '/tugas';
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

    function loading(state) {
        if(state) {
            $('#loading').removeClass('d-none');
        } else {
            $('#loading').addClass('d-none');
        }
    }

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