@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Profile</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="section-body">
        <div class="row mt-sm-4">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card profile-widget">
              <div class="profile-widget-header">
                <img alt="image" src="{{ asset('storage/img/pegawai/'. auth()->user()->img) }}" class="rounded-circle profile-widget-picture">
              </div>
            </div>
            <div class="card">
                  <div class="card-header">
                    <h4>Data Diri sfdfd</h4>
                  </div>
                  <div class="card-body">
                      <form id="update-data">
                        @csrf
                            <div class="form-group">
                                <label for="nip">Photo</label>
                                <input type="file" class="form-control" id="photo" name="img">
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="number" class="form-control" id="nip" value="{{ auth()->user()->nip }}" name="nip">
                            </div>
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" value="{{ auth()->user()->name }}" name="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ auth()->user()->email }}" name="email">
                            </div>
                            <div class="form-group">
                                <label for="no_tlp">No Tlp</label>
                                <input type="number" class="form-control" id="no_tlp" value="{{ auth()->user()->no_tlp }}" name="no_tlp">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password" value="">
                            </div>
                            @include('layouts._loading_submit')
                            <button type="submit" class="btn btn-primary x-btn ">Simpan Perubahan</button>
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
            url: '/admin/profile/update/{{ auth()->user()->id }}',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
        }

        loadingsubmit(true);
            await transAjax(param).then((res) => {
                swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
                    loadingsubmit(false);
                    window.location.href = '/admin/profile';
                });
            }).catch((err) => {
                loadingsubmit(false);
                swal({text: err.responseJSON.message, icon: 'error', timer: 3000,}).then(() => {
                window.location.href = '/admin/profile';
            });
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
                      window.location.href = '/admin/pegawai';
                  });
              }).catch((err) => {
                  loadingsubmit(false);
                  swal({text: 'Server Internal Error!', icon: 'error', timer: 3000,}).then(() => {
                  window.location.href = '/pegawai/tambah';
              });
            });
          });
        }
    });
  }
</script>
@endpush