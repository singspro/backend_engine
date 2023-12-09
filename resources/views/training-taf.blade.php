@extends('layouts/main')

@section('container')

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Data TAF (Training Application Form)</h5>
      {{-- <div class="d-flex justify-content-end">
        <form action="/tr">
        <div class="input-group mb-3">
          <input type="text" name="search" class="form-control" placeholder="Cari training" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{Request('search')}}">
          <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
        </div>
      </form>
        </div> --}}
      <!-- Table with hoverable rows -->
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">NO. TAF</th>
              <th scope="col">Nama Training</th>
              <th scope="col">Penyelenggara</th>
              <th scope="col">Lokasi</th>
              <th scope="col">Start Date</th> 
              <th scope="col">End Date</th>
              <th scope="col">Create Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $item)
            <tr>
              <td><a href="/lampunut?data={{urlencode($item->idTaf)}}">{{ $item->idTaf}}</a></td>
              <td>{{($item->kodeTraining==="-")? $item->uraianMateri:$item->judul}}</td>
              <td>{{ $item->namaLembaga }}</td>
              <td>{{ $item->lokasiTraining }}</td>
              <td>{{ $item->startDate }}</td>
              <td>{{ $item->endDate }}</td>
              <td>{{ $item->createDate }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{-- {{$trainingData->links()}} --}}
      <!-- End Table with hoverable rows -->
    
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="mt-3">
        <a href="/ixx" class="btn btn-success">New</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

</script>
@endpush