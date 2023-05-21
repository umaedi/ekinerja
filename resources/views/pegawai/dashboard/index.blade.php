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
    <script type="text/javascript">

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
        });
    </script>
@endpush