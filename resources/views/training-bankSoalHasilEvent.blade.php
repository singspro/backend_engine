@extends('layouts/main')

@section('container')

{{-- @dd($data->first()->id) --}}

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Event Result</h5>
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