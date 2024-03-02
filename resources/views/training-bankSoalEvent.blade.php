@extends('layouts/main')

@section('container')

{{-- @dd($data->first()->id) --}}

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Event list</h5>
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
            <th scope="col">Creator</th>
            <th scope="col">Pre/Post</th>
            <th scope="col">Expired</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($eventList as $s)
          <tr>
            <td>{{$s->judul}}</td>
            <td>{{$s->creator}}</td>
            <td>{{$s->prePost}}</td>
            <td>{{$s->validUntil}}</td>
            <td>
              <button onclick="showLinkBtn(this)" type="button" data-link='{{$baseLink.$s->kodeEvent}}' data-expired='{{$s->validUntil}}' class="btn btn-primary"><i class="bi bi-link"></i></button>
              <a href="/eventDetail?d={{$s->kodeEvent}}"  type="button" class="btn btn-primary"><i class="bi bi-list"></i></a>
              <button onclick="deleteConfirm(this)" type="button" data-event='{{$s->kodeEvent}}' class="btn btn-danger"><i class="bi bi-trash"></i></button>
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


<!-- Modal -->
<div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Warning....</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Dengan menghapus event ini berarti anda menyetujui bahwa semua isi dari event seperti hasil pengerjaan soal dan lain-lain akan dihapus...!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
        <button id="btnEventDeleteConfirm" type="button" data-event='' onclick="deleteEventConfirm(this)" class="btn btn-primary">Ya Lanjut</button>
      </div>
    </div>
  </div>
</div>


@endsection

@push('scripts')
<script src="assets/js/qrcode.min.js"> </script>
<script src="assets/js/trainingBankSoalMain.js"></script>
<script>
  function deleteConfirm(e){
    let a=document.getElementById('btnEventDeleteConfirm');
    a.setAttribute('data-event',$(e).data('event'));
    $('#deleteEventModal').modal('show');
  }

  async function deleteEventConfirm(e){
    try {
      let res=await api1(e.getAttribute('data-event'));
      if(res.status==='ok'){
        window.location.replace('/soalEvent');
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
      type: "DELETE",
      url: "/deleteEvent",
      data: {data:data},
      // dataType: "application/json",
    });
  }
</script>
@endpush