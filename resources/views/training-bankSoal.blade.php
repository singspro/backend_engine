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
              <th scope="col"></th> 
            </tr>
          </thead>
          <tbody>
            @foreach($data as $s)
            <tr>
              <td><a href="/soalDetail?bintangKecil={{$s->idSoalUtama}}">{{$s->judul}}</a></td>
              <td>{{$s->author}}</td>
              <td>{{$s->revisi}}</td>
              <td>{{$s->created_at}}</td>
              <td>
                <button type="button" data-id='{{$s->idSoalUtama}}' data-judul="{{$s->judul}}" onclick="buttonClick(this)" class="btn btn-danger"><i class="bi bi-trash"></i></button>
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

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Warning.....</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah anda yakin akan menghapus soal ini?
        <div id="judulSoal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
        <button type="button" id="btnYes" data-id='sdfs' onclick="confirmDel(this)" class="btn btn-primary">Yes</button>
      </div>
    </div>
  </div>
</div>

<div id="modalLink"></div>

@endsection

@push('scripts')
<script src="assets/js/qrcode.min.js"> </script>
<script src="assets/js/trainingBankSoalMain.js"></script>
<script>
  $(document).ready(function(){

  })
  function buttonClick(e){
    let btnYes=document.getElementById('btnYes');
    let judul=document.getElementById('judulSoal');
    judul.innerHTML=$(e).data('judul');
    btnYes.setAttribute('data-id',$(e).data('id'));
    $('#deleteModal').modal('show');
  }

  async function confirmDel(e){
   try {
     let h=await api1($(e).data('id'));
     if(h.status==='ok'){
      window.location.replace('/soalMain');
     }
   } catch (err) {
    console.log(err);
   }
  }

  function api1(data){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    return $.ajax({
      type: "POST",
      url: "/deleteSoal",
      data: {data:data},
      // dataType: "application/json",
    });
  }
</script>
@endpush