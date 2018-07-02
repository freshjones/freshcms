@if($data['billboards'])
<div class="billboards">
  <div class="carousel slide" id="carouselControls-{{ $id }}" data-ride="carousel">
    <div class="carousel-inner">
      @foreach( $data['billboards'] as $billboard)
      <div class="carousel-item @if($loop->first) active @endif">
        <div class="billboard-content">
          <div>
            <div class="container">
              <div class="display-4 m-0 p-0">{{ $billboard['heading'] }}</div>
              <div class="lead mt-0 mb-2">{{ $billboard['subheading'] }}</div>
              <a class="btn btn-success" href="{{ $billboard['link'] }}">Learn more</a>
            </div>
          </div>
        </div>
        <div class="billboard-background" style="background-image:url('{{ asset('storage/images/' . $billboard['background']) }}');"></div>
        <div class="billboard-overlay"></div>
      </div>
      @endforeach
    </div>
    @if(count($data['billboards']) > 1)
    <a class="carousel-control-prev" href="#carouselControls-{{ $id }}" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselControls-{{ $id }}" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    @endif
  </div>
</div>
@endif
