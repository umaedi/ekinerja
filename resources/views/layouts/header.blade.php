<div class="section-header">
    <h1>{{ $title ?? 'Dashboard' }}</h1>
    <div class="section-header-breadcrumb">
      @isset($breadcrumb)
          @foreach ($breadcrumb as $bd)
          <div class="breadcrumb-item @isset($bd['active']) active @endisset">@if(isset($bd['active'])) {{ $bd['name'] }} @else <a href="{{ $bd['url'] }}">{{ $bd['name'] }}</a> @endif</div>
          @endforeach
      @endisset
    </div>
  </div>