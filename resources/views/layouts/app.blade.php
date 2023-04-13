<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="theme-color" content="#6777ef"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? "Dashboard" }}</title>
  <link rel="stylesheet" href="{{ asset('css') }}/bootstrap.4.3.1.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('css') }}/style.css">
  <link rel="stylesheet" href="{{ asset('css') }}/components.css">
  <link rel="stylesheet" href="{{ asset('css') }}/fakeLoader.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css" />

  <!-- PWA  -->
  <link rel="apple-touch-icon" href="{{ asset('assets/img/icon/xxlc_icon_ekinerja.png') }}">
  <link rel="manifest" href="{{ asset('/manifest.json') }}">
  @stack('css')
</head>
<body>
  <div class="fakeloader"></div>
  <div id="app">
    <div class="main-wrapper container">
      @include('layouts.navbar')
      @yield('content')
      @include('layouts.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="{{ asset('js') }}/stisla.js"></script>
  <script src="{{ asset('js') }}/sweetalert.min.js"></script>

  <script src="{{ asset('js') }}/scripts.js"></script>
  <script src="{{ asset('js') }}/custom.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
  <script>baguetteBox.run('.x-lampiran',{animation:'slideIn'});</script>
  <script src="{{ asset('js') }}/fakeLoader.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function loading() {
    $.fakeLoader({
        timeToHide:500,
        spinner:"spinner7"
    });
    sw();

    jQuery(function($) {
            setInterval(function() {
                var date = new Date(),
                    time = date.toLocaleTimeString();
                $("#clock").html(time);
            }, 1000);
        });
});

function sw() {
    if (!navigator.serviceWorker.controller) {
    navigator.serviceWorker.register("/sw.js").then(function (reg) {
        console.log("Service worker has been registered for scope: " + reg.scope);
    });
    }
}

async function transAjax(data) {
    html = null;
    data.headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    await $.ajax(data).done(function(res) {
        html = res;
    })
        .fail(function() {
            return false;
        })
    return html
}

async function logOut(url) {
    var param = {
        method: 'POST',
        url: url,
    }

    await transAjax(param).then((res) => {
        swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
            window.location.href = '/';
        });
    }).catch((err) => {
        swal({text: err.responseJSON.message, icon: 'error', timer: 3000,});
    });
}

</script>
@stack('js')
</body>
</html>
