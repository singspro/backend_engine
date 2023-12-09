@extends('layouts/main')

@section('container')

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Data Training</h5>
      <div class="d-flex justify-content-end">
        <form action="/tr">
        <div class="input-group mb-3">
          <input type="text" name="search" class="form-control" placeholder="Cari training" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{Request('search')}}">
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
              <th scope="col">Lokasi</th>
              <th scope="col">Lembaga</th>
              <th scope="col">Instruktur</th> 
              <th scope="col">Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($trainingData as $data)
            <tr>
              <td><a href="trainingDetail?imore={{ $data->idTr }}">{{ ($data->kodeTr!="-")? $data->judul : $data->uraianMateri }}</a></td>
              <td>{{ $data->lokasiTraining }}</td>
              <td>{{ $data->lembaga }}</td>
              <td>{{ $data->namaInstructor }}</td>
              <td>{{ $data->start }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{$trainingData->links()}}
      <!-- End Table with hoverable rows -->
    
    </div>
</div>

@endsection