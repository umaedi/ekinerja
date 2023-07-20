@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css"  />
<style>
     img {
            display: block;
            max-width: 100%;
        }
        .preview {
            overflow: hidden;
            width: 160px; 
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }
</style>
@endpush
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
                <img alt="image" data-src="{{ auth()->user()->img }}" class="lazyload rounded-circle profile-widget-picture">
              </div>
            </div>
            <div class="card">
                  <div class="card-header">
                    <h4>Data Diri {{ auth()->user()->name }}</h4>
                  </div>
                  <div class="card-body">
                      <form id="update-data">
                        @csrf
                        @method('PUT')
                            <div class="form-group">
                                <label for="nip">Photo</label>
                                <input type="file" class="form-control image" id="photo" accept=".png, .jpg, .jpeg" name="img">
                                <input type="hidden" name="newimage" id="newImage">
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" id="nip" value="{{ auth()->user()->nip }}" name="nip">
                            </div>
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" value="{{ auth()->user()->nama }}" name="nama">
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
                            <button type="submit" class="btn btn-primary x-btn ">SIMPAN PERUBAHAN</button>
                      </form>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">  
                            <!--  default image where we will set the src via jquery-->
                            <img id="image">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.2/lazysizes.min.js" async=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script type="text/javascript">
    $('#update-data').submit(async function update(e) {
        e.preventDefault();

        var form 	= $(this)[0]; 
        var _data 	= new FormData(form);

        var param = {
            method: 'POST',
            url: '/profile/update/{{ auth()->user()->id }}',
            data: _data,
            processData: false,
            contentType: false,
            cache: false,
        }

        loadingsubmit(true);
            await transAjax(param).then((res) => {
                loadingsubmit(false);
                swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
                    window.location.href = '/profile';
                });
            }).catch((err) => {
                loadingsubmit(false);
                swal({text: err.responseJSON.message, icon: 'error', timer: 3000,}).then(() => {
                window.location.href = '/profile';
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

    var bs_modal = $('#modal');
    var image = document.getElementById('image');
    var cropper,reader,file;
   

    $("body").on("change", ".image", function(e) {
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            bs_modal.modal('show');
        };


        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    bs_modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 160,
            height: 160,
        });

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
            var base64data = reader.result;
            bs_modal.modal('hide');
            document.getElementById('newImage').value = base64data;
            };
        });
    });
</script>
@endpush