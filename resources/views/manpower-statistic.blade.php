@extends('layouts/main')

@section('container')
<div class="card">
    <div class="card-body">
      <h5 class="card-title">DATA {{Request('j')}} {{Request('s')}}</h5>

      <!-- Table with hoverable rows -->
      <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">NRP</th>
            <th scope="col">Nama</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Grade</th>
            <th scope="col">Spcl</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr>
            <td><a href="/detail{{$item->nrp}}">{{$item->nrp}}</a></td>
            <td>{{$item->nama}}</td>
            <td>{{$item->jabatanFn}}</td>
            <td>{{$item->grade}}</td>
            <td>{{$item->spesialis}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{$data->links()}}
      <!-- End Table with hoverable rows -->
    
    </div>
</div>
@endsection

@push('scripts')
<script>

</script>
@endpush