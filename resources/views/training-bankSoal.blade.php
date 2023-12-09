@extends('layouts/main')

@section('container')

{{-- @dd($data->first()->id) --}}
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Bank Soal</h5>
      <div class="d-flex justify-content-end">
        <form action="/soalSearch">
        <div class="input-group mb-3">
          <input type="text" name="search" class="form-control" placeholder="Cari soal" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{Request('search')}}">
          <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
        </div>
      </form>
        </div>
      <!-- Table with hoverable rows -->
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Judul</th>
              <th scope="col">Author</th>
              <th scope="col">Revisi</th>
              <th scope="col">Create Date</th> 
            </tr>
          </thead>
          <tbody>
            @foreach($data as $s)
            <tr>
              <td><a href="/soalDetail?bintangKecil={{$s->idSoalUtama}}">{{$s->judul}}</a></td>
              <td>{{$s->author}}</td>
              <td>{{$s->revisi}}</td>
              <td>{{$s->created_at}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{-- {{$trainingData->links()}} --}}
      <!-- End Table with hoverable rows -->
    
    </div>
</div>

@endsection