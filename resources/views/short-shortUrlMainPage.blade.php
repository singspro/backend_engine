@extends('layouts/main')

@section('container')
<div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-6">
          <h5 class="card-title">URL's</h5>
        </div>
      </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Shorten</th>
              <th scope="col">Target</th>
              <th scope="col">Creator</th>
              <th scope="col">Remark</th> 
              <th scope="col">Created At</th> 
              <th scope="col"></th> 
            </tr>
          </thead>
          <tbody>
            @foreach($table as $t)
            <tr>
              <td>{{$t->urlShroten}}</td>
              <td>{{$t->urlTarget}}</td>
              <td>{{$t->creator}}</td>
              <td>{{$t->remark}}</td>
              <td>{{$t->created_at}}</td>
              <td>
                <button data-id="{{$t->urlShroten}}" onclick="getBarcode(this)" type="button" class="btn btn-primary"><i class="bi bi-link"></i></button>
                <button data-id="{{$t->id}}"  onclick="delUrl(this)" type="button" class="btn btn-danger"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
</div>

<div class="modal fade" id="showQrCode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Link Shorten URL</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="qrCode" class="img-fluid">

        </div>
        <p id="linkDesc" class="mt-3"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Got it</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="delCon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Warning</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin akan menghapus link ini ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancle</button>
        <button data-id="" onclick="confirmDel(this)" id="yesDel" type="button" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>

@endsection
@push('scripts')
<script src="assets/js/qrcode.min.js"> </script>
<script>
  $(document).ready(function(){
    $("#showQrCode").on('hide.bs.modal', function(){
      document.getElementById('qrCode').innerHTML='';
      document.getElementById('linkDesc').innerHTML='';
  });
  })
  function getBarcode(e){
    let q=new QRCode(document.getElementById('qrCode'),$(e).data('id'));
    document.getElementById('linkDesc').innerHTML=$(e).data('id');
    $('#showQrCode').modal('show');
  }
  function delUrl(e){
    let d=document.getElementById('yesDel');
    d.setAttribute('data-id',$(e).data('id'));
    $('#delCon').modal('show');
  }

  async function confirmDel(e){
    try {
      let res=await api1($(e).data('id'));
      if(res.status==='ok'){
        window.location.replace('/shrotUrl')
      }
      
    } catch (error) {
      
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
      url: "/deleteUrl",
      data: {data:data},
      // dataType: "application/json",
    });
  }
</script>

@endpush