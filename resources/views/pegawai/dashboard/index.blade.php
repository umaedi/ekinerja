@extends('layouts.app')
@section('content')
<div class="main-content">
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
                <em>
                    <b>Hallo {{ auth()->guard('pegawai')->user()->name }}</b>, Saat ini aplikasi masih sedang dalam perbaikan</em>
            </p>
        </div>
        </div>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
          <a href="{{ route('pegawai.profile') }}" style="text-decoration: none">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Data diri</h4>
              </div>
              <div class="card-body">
                {{ auth()->guard('pegawai')->user()->name }}
              </div>
            </div>
          </div>
        </a>
        </div>
        @if (auth()->guard('pegawai')->user()->role === 3 || auth()->guard('pegawai')->user()->role === 2)
        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
          <a href="{{ route('bagian.pegawai') }}" style="text-decoration: none">
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
        @endif
        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
          <a href="{{ route('pegawai.tugas') }}" style="text-decoration: none">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-laptop"></i>
              </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Riwayat Tugas</h4>
              </div>
              <div class="card-body">
                {{ $riwayat_task }}
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
                    Selesai <span class="badge badge-transparent">{{ $task }}</span>
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
    </section>
  </div>
@endsection
@push('js')
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAD8y5ZQcuol7vxOkXii_wsHqYhCNL0uEM&libraries=geometry&callback"></script>
    <script type="text/javascript">

    // $('#lampiran').click(function(e) {
    //   var test = 1;
    //   if (e.isTrusted) {
    //     e.preventDefault();
    //   } else if(test > 2) {
    //     console.log('ok');
    //   }else {
    //     e.target.click();
    //   }
    // });

    // fungsi untuk mengompres gambar
    const compressImage = async (file, { quality = 1, type = file.type }) => {
        // Get as image data
        const imageBitmap = await createImageBitmap(file);

        // Draw to canvas
        const canvas = document.createElement('canvas');
        canvas.width = imageBitmap.width;
        canvas.height = imageBitmap.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(imageBitmap, 0, 0);

        // Turn into Blob
        const blob = await new Promise((resolve) =>
            canvas.toBlob(resolve, type, quality)
        );

        // Turn Blob into File
        return new File([blob], file.name, {
            type: blob.type,
        });
    };

    // Get the selected file from the file input
    const input = document.querySelector('.my-image-field');
    input.addEventListener('change', async (e) => {
        // Get the files
        const { files } = e.target;

        // No files selected
        if (!files.length) return;

        // We'll store the files in this data transfer object
        const dataTransfer = new DataTransfer();

        // For every file in the files list
        for (const file of files) {
            // We don't have to compress files that aren't images
            if (!file.type.startsWith('image')) {
                // Ignore this file, but do add it to our result
                dataTransfer.items.add(file);
                continue;
            }

            // We compress the file by 50%
            const compressedFile = await compressImage(file, {
                quality: 0.3,
                type: 'image/jpeg',
            });

            // Save back the compressed file instead of the original file
            dataTransfer.items.add(compressedFile);
        }

        // Set value of the file input to our new files list
        e.target.files = dataTransfer.files;
        });


        //store task
        $(document).ready(function() {
          $('#store').submit(async function store(e) {
                e.preventDefault();

              if(navigator.geolocation) {
                  navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
              }else {
                  swal({title: 'Oops!', text:'Maaf, browser Anda tidak mendukung geolokasi HTML5.', icon: 'error', timer: 3000,});
              }

              function successCallback(position) {
                  getCurrentPosition(position);
              }

              function errorCallback(error) {
                  if(error.code == 1) {
                      swal({title: 'Oops!', text:'Mohon untuk mengaktifkan lokasi Anda', icon: 'error', timer: 3000,});
                  } else if(error.code == 2) {
                      swal({title: 'Oops!', text:'Jaringan tidak aktif atau layanan penentuan posisi tidak dapat dijangkau.', icon: 'error', timer: 3000,});
                  } else if(error.code == 3) {
                      swal({title: 'Oops!', text:'Waktu percobaan habis sebelum bisa mendapatkan data lokasi.', icon: 'error', timer: 3000,});
                  } else {
                      swal({title: 'Oops!', text:'Waktu percobaan habis sebelum bisa mendapatkan data lokasi.', icon: 'error', timer: 3000,});
                  }
              }

              // //radius
              var currentLocation = { lat: -5.3774079, lng: 105.2496447 };
              var radius = 1000;

              function getCurrentPosition(position)
              {
                  var userLocation = {
                      lat: position.coords.latitude,
                      lng: position.coords.longitude
                  };

                  var distance = google.maps.geometry.spherical.computeDistanceBetween(
                      new google.maps.LatLng(currentLocation),
                      new google.maps.LatLng(userLocation)
                  );

                  // Jika jarak kurang dari radius
                  if (distance < radius) {
                      taskStore();
                  } else {
                      swal({title: 'Oops!', text:'Mohon Maaf Sepertinya Anda Diluar Radius!', icon: 'error', timer: 3000,}).then(() => {
                          window.location.href = '/pegawai';
                      });
                  }
              }

              function taskStore()
              {
                  var form 	= $(this)[0]; 
                  var data 	= new FormData(form);
              }

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
        });
    </script>
@endpush