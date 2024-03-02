@extends('layouts/main')

@section('container')
<div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-6">
        <h5 class="card-title">Hasil Pengerjaan</h5>
        <h5>{{$event->first()->judul}}</h5>
        </div>
      </div>  
      <div class="row list-cuk">
        <div class="col-sm-6">
          <hr>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Nama</div>
            <div class="col-lg-9 col-md-8">{{$profile->first()->nama}}</div>
          </div>

          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Perusahaan</div>
            <div class="col-lg-9 col-md-8">{{$profile->first()->perusahaan}}</div>
          </div>

          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Jabatan</div>
            <div class="col-lg-9 col-md-8">{{$profile->first()->jabatanFn}}</div>
          </div>
          <hr>
        </div>
        
        <div class="col-sm-6 list-cuk">
          <hr>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Jawaban Benar</div>
            <div class="col-lg-9 col-md-8">{{$profile->first()->benar}}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Jawaban Salah</div>
            <div class="col-lg-9 col-md-8">{{$profile->first()->salah}}</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 label ">Nilai</div>
            <div class="col-lg-9 col-md-8">{{$profile->first()->nilai}}</div>
          </div>
          <hr>
        </div>

      </div>
    </div>
</div>

@foreach ($jenis as $vJenis)
    @if ($vJenis===1)
    {{-- @dd($jawaban)  --}}
    <div class="card">
        <div class="card-body">
          <div class="col-lg-12">
            <h5 class="card-title">Multiple Choice</h5>
            <ol class="list-group list-group-numbered mt-3">
              @foreach ($jawaban as $vJawaban)
              @if ($vJawaban['jenis']===1)

              <li class="list-group-item">{{$vJawaban['soal']}}
                <div class="col-sm-10 mt-3">
                  
                  @if ($vJawaban['fileStatus'])
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="ms-3">
                        <img src="{{$vJawaban['filePath']}}" class="img-fluid" alt="...">
                      </div>
                    </div>
                  </div>
                  @endif
                  
                  @foreach ($vJawaban['choice'] as $i)
                  @if ($i===$vJawaban['key'])
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" value="option1" disabled>
                    <label class="form-label right-answer" for="gridRadios1">{{$i}}</label>
                  </div>
                  @else
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" value="option1" disabled>
                    <label class="form-label" for="gridRadios1">{{$i}}</label>
                  </div>
                  @endif
                  @endforeach
                </div> 
                <div class="position-relative mt-5">
                  <div class="position-absolute bottom-0 start-0"><p class="px-4 {{$vJawaban['dijawab']===$vJawaban['key']?'text-bg-info':'text-bg-danger'}}">
                    <strong>Jawaban Anda : {{$vJawaban['dijawab']}}</strong></p>
                  </div>
                </div>
              </li>
              @endif
              @endforeach
            </ol>

          </div>
        </div>
    </div>
    @endif
    
    @if ($vJenis===2)
    <div class="card">
        <div class="card-body">
          <div class="col-lg-12">
            <h5 class="card-title">True False</h5>
            <ol class="list-group list-group-numbered mt-3">
              @foreach ($jawaban as $vJawaban)
              @if ($vJawaban['jenis']===2)
              <li class="list-group-item">{{$vJawaban['soal']}}
                <div class="col-sm-10 mt-3">
                  
                  @if ($vJawaban['fileStatus'])
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="ms-3">
                        <img src="{{$vJawaban['filePath']}}" class="img-fluid" alt="...">
                      </div>
                    </div>
                  </div>
                  @endif
                  
                  @foreach ($vJawaban['choice'] as $i)
                  @if ($i===$vJawaban['key'])
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" value="option1" disabled>
                    <label class="form-label right-answer" for="gridRadios1">{{$i}}</label>
                  </div>
                  @else
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" value="option1" disabled>
                    <label class="form-label" for="gridRadios1">{{$i}}</label>
                  </div>
                  @endif
                  @endforeach
                </div> 
                <div class="position-relative mt-5">
                  <div class="position-absolute bottom-0 start-0"><p class="px-4 {{$vJawaban['dijawab']===$vJawaban['key']?'text-bg-info':'text-bg-danger'}}">
                    <strong>Jawaban Anda : {{$vJawaban['dijawab']}}</strong></p>
                  </div>
                </div>
              </li>
              @endif
              @endforeach
            </ol>

          </div>
        </div>
    </div>
    <div>
    </div>        
    @endif

    @if ($vJenis===3)
    <div class="card">
      <div class="card-body">
        <div class="col-lg-12">
          <h5 class="card-title">Matching</h5>
          <ol class="list-group list-group-numbered">
            @foreach ($jawaban as $vJawaban)
            @if ($vJawaban['jenis']===3)

            @if ($vJawaban['fileStatus'])
             
            <li class="list-group-item">
              <strong>{{$vJawaban['soalMain']}}</strong>
              <div class="row mt-3"><div class="col-lg-6 mb-3">
              <p class="fw-bolder">Pertanyaan :</p>
              <ol class="list-group list-group-numbered">
                @foreach ($vJawaban['soal'] as $i) 
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="text-start">{{$i['soal']}}</div>
                    <h6>Kunci: {{$i['kunci']}}</h6>
                    <p class="{{$i['kunci']===$i['dijawab']?'text-bg-info':'text-bg-danger'}}"><strong>Jawaban Anda : {{$i['dijawab']}}</strong></p>
                  </div>
                </li>
                @endforeach
              </ol>
                </div><div class="col-lg-6">
                  <p class="fw-bolder">Gambar :</p>
                  <img src="{{$vJawaban['filePath']}}" class="img-thumbnail" alt="...">
                </div>
              </div>
             
            </li>

            @else
            <li class="list-group-item">
              <strong>{{$vJawaban['soalMain']}}</strong>
              <div class="row mt-3">
                <div class="col-lg-6 mb-3">
                  <p class="fw-bolder">Pertanyaan :</p>
                  <ol class="list-group list-group-numbered">
                    
                    @foreach ($vJawaban['soal'] as $i) 
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                      <div class="ms-2 me-auto">
                        {{-- @dd($i) --}}
                        <div class="text-start">{{$i['soal']}}</div>
                        <h6>Kunci: {{$i['kunci']}}</h6>
                        <p class="{{$i['kunci']===$i['dijawab']?'text-bg-info':'text-bg-danger'}}"><strong>Jawaban Anda : {{$i['dijawab']}}</strong></p>
                      </div>
                    </li>
                    @endforeach
                    
                  </ol>
                </div>
                <div class="col-lg-6">
                  <p class="fw-bolder">Pilihan Jawaban :</p>
                  <div class="table-responsive">
                    <table class="table table-info">
                      <tbody>
                        
                        @foreach ($vJawaban['choice'] as $i)  
                        <tr>
                          <td>{{$i['index']}}</td>
                          <td>{{$i['c']}}</td>
                        </tr>   
                        @endforeach
                         
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </li>
            @endif


            @endif
            @endforeach
          </ol>
        </div>
      </div>
    </div>
          @endif
          @endforeach
          @endsection