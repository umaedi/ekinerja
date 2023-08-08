@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section x-lampiran">
      <div class="section-header">
        <h1>Data Pegawai</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <input type="text" id="search" class="form-control" placeholder="Cari Pegawai..." name="q">
                        </div>
                        <div class="col-lg-2 mb-3">
                            <select class="form-control" id="perPage">
                                <option value="10">--PERHALAMAN--</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                              </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary btn-block">TAMBAH PEGAWAI</a>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('admin.import') }}" class="btn btn-primary btn-block">IMPORT</a>
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
@endsection
@push('js')
    <script type="text/javascript">
    var page = 1;
    var paginate = 10;
    var search = '';
    var golongan = ''
        $(document).ready(function() {
            loadData();

            $('#search').on('keypress', function (e) {
                if (e.which == 13) {
                    filterTable()
                    return false;
                }
            });

            $('#perPage').change(() => {
                filterTable();
            });

            $('#golongan').change(() => {
                filterTable();
            });

        });

        function filterTable() {
            paginate = $('#perPage').val(); 
            search = $('input[name=q]').val();
            golongan = $('select[name=golongan_id]').val();
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
                    golongan_id: golongan,
                    search: search,
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

    function loading(state) {
        if(state) {
            $('#loading').removeClass('d-none');
        } else {
            $('#loading').addClass('d-none');
        }
    }

    </script>
@endpush