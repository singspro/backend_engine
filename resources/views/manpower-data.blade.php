@extends('layouts/main')

@section('container')

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Data Manpower</h5>

      <!-- Table with hoverable rows -->
      <div class="d-flex justify-content-end">
      <form action="/mp">
      <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari Manpower" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{Request('search')}}">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
      </div>
    </form>
      </div>
      <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">NRP</th>
            <th scope="col">Nama</th>
            <th scope="col">Perusahaan</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($dataMp as $data)
          <tr>
            <td><a href="/detail{{$data->nrp}}">{{$data->nrp}}</a></td>
            <td>{{$data->nama}}</td>
            <td>{{$data->perusahaan}}</td>
            <td>{{$data->jabatanFn}}</td>
            <td>{{$data->status}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{$dataMp->links()}}
      <!-- End Table with hoverable rows -->
    
    </div>
</div>
@endsection