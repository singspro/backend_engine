@extends('layouts/main')

@section('container')
<section class="section dashboard mb-5">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">DATA {{Request('mode')}}</h5>
          </div>
        </div>
        <div class="row">
            @foreach ($data['JobAreaQty'] as $item)
                
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
  
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>
  
                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>
  
                  <div class="card-body">
                    <h5 class="card-title">{{$item['area']}} <span>| Today</span></h5>
  
                    <div class="d-flex align-items-center">
                      <a href="#">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                      </div>
                      </a>
                      <div class="ps-3">
                        <h6>{{$item['data']}}</h6>
                        {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
  
                      </div>
                    </div>
                  </div>
  
                </div>
              </div>
              @endforeach
    </div>
</div>
    </div>
</section>

@foreach ($data['JobAreaQty'] as $item)     
<section class="section dashboard mb-5">
  <div class="row">
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
        <h5 class="card-title">DATA {{Request('mode')}} {{$item['area']}}</h5>
    </div>
</div>
  <div class="row">
    @foreach ($data['subSectionQty'] as $subSection)  
      @if ($subSection['area']===$item['area'])
          <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">{{$subSection['subSection']}} <span>| Today</span></h5>

                  <div class="d-flex align-items-center">
                    <a href="/kopiHitam?ngok={{$item['area'].'&j='.Request('mode').'&s='.urlencode($subSection['subSection'])}}">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    </a>
                    <div class="ps-3">
                      <h6>{{$subSection['data']}}</h6>
                      {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                    </div>
                  </div>
                </div>

              </div>
            </div>
            @endif
            @endforeach
  </div>
</div>
  </div>
</section>
@endforeach
@endsection
@push('scripts')
<script>

</script>
@endpush