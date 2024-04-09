@extends('layouts/main')

@section('container')

{{-- @dd($data->first()->id) --}}

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Event Result</h5>
    <div class="row list-cuk">
      <div class="col-sm-12">
        <hr>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Judul Event</div>
          <div class="col-lg-9 col-md-8">{{$evt->judul}}</div>
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Creator</div>
          <div class="col-lg-9 col-md-8">{{$evt->creator}}</div>
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Create Date</div>
          <div class="col-lg-9 col-md-8">{{$evt->created_at}}</div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Pre/Post</div>
          <div class="col-lg-9 col-md-8">{{$evt->prePost==='postTest'?'Post Test':'Pre Test'}}</div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Buka Soal Untuk Umum</div>
          <div class="col-lg-9 col-md-8">{{$evt->soalUmum===1?'YES':'NO'}}</div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Release Nilai</div>
          <div class="col-lg-9 col-md-8">{{$evt->nilai===1?'YES':'NO'}}</div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Acak Soal Multiple Choice</div>
          @if ($jumlahSoal['mc']===0)
          <div class="col-lg-9 col-md-8">-</div>
          @else
          <div class="col-lg-9 col-md-8">{{$evt->acakMc===1?'YES':'NO'}}</div>
          @endif
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Acak Soal True/False</div>
          @if ($jumlahSoal['tf']===0)
          <div class="col-lg-9 col-md-8">-</div>
          @else
          <div class="col-lg-9 col-md-8">{{$evt->acakTf===1?'YES':'NO'}}</div>
          @endif
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Acak Soal Matching</div>
          @if ($jumlahSoal['match']===0)
          <div class="col-lg-9 col-md-8">-</div>
          @else
          <div class="col-lg-9 col-md-8">{{$evt->acakMatch===1?'YES':'NO'}}</div>
          @endif
        </div>
        <hr>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Bobot</div>
          <div class="col-lg-9 col-md-8">{{$evt->bobotBalanced===1?'Balanced':'Adjusted'}}</div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Bobot Multiple choice</div>
          @if ($jumlahSoal['mc']===0)
          <div class="col-lg-9 col-md-8">-</div>
          @else
          <div class="col-lg-9 col-md-8">{{$evt->bobotBalanced===1?'-':$evt->bobotMc.'%'}}</div>
          @endif
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Bobot True/False</div>
          @if ($jumlahSoal['tf']===0)
          <div class="col-lg-9 col-md-8">-</div>
          @else
          <div class="col-lg-9 col-md-8">{{$evt->bobotBalanced===1?'-':$evt->bobotTf.'%'}}</div>
          @endif
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Bobot Matching</div>
          @if ($jumlahSoal['match']===0)
          <div class="col-lg-9 col-md-8">-</div>
          @else
          <div class="col-lg-9 col-md-8">{{$evt->bobotBalanced===1?'-':$evt->bobotMatch.'%'}}</div>
          @endif
        </div>
        <hr>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Batasi Soal Multiple Choice</div>
          @if ($jumlahSoal['mc']===0)
          <div class="col-lg-9 col-md-8">-</div>
          @else
            @if ($jumlahSoal['mc']===$evt->batasiMc)
            <div class="col-lg-9 col-md-8">Tidak Dibatasi</div>
            @else
            <div class="col-lg-9 col-md-8">{{$evt->batasiMc}} dari {{$jumlahSoal['mc']}}</div>
            @endif
          @endif
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Batasi Soal True/False</div>
          @if ($jumlahSoal['tf']===0)
          <div class="col-lg-9 col-md-8">-</div>
          @else
          @if ($jumlahSoal['tf']===$evt->batasiTf)
          <div class="col-lg-9 col-md-8">Tidak Dibatasi</div>
          @else
          <div class="col-lg-9 col-md-8">{{$evt->batasiTf}} dari {{$jumlahSoal['tf']}}</div>
          @endif
          @endif
        </div>
        <hr>
      </div>
    </div>
  </div>

</div>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Result</h5>
    {{-- <div class="d-flex justify-content-end">
      <form action="/soalSearch">
      <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari soal" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{Request('search')}}">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
      </div>
    </form>
      </div> --}}
    <!-- Table with hoverable rows -->
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">NRP</th>
            <th scope="col">Nama</th>
            <th scope="col">Perusahaan</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Benar</th>
            <th scope="col">Salah</th>
            <th scope="col">Nilai</th>
            <th scope="col">Submited</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          {{-- @dd($data) --}}
          @foreach($data as $d)
          <tr>
            <td>{{$d['nrp']}}</td>
            <td>{{$d['nama']}}</td>
            <td>{{$d['perusahaan']}}</td>
            <td>{{$d['jabatanFn']}}</td>
            <td>{{$d['benar']}}</td>
            <td>{{$d['salah']}}</td>
            <td>{{$d['nilai']}}</td>
            <td>{{$d['submited']}}</td>
            <td>
              <a type="button" href="/showResult?d={{$d['token']}}" class="btn btn-primary"><i class="bi bi-list"></i></a>
            </td>
         
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{-- {{$trainingData->links()}} --}}
    <!-- End Table with hoverable rows -->
  
  </div>
</div>

<div id="modalLink"></div>

@endsection

@push('scripts')
<script src="assets/js/qrcode.min.js"> </script>
<script src="assets/js/trainingBankSoalMain.js"></script>
<script>

  function api1(data){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    return $.ajax({
      type: "get",
      url: "/detailPengerjaan",
      data: {data:data},
      // dataType: "application/json",
    });
  }
</script>
@endpush