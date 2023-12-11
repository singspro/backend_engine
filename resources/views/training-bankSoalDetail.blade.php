@extends('layouts/main')

@section('container')
<div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-6">
          <h5 class="card-title">Question Data</h5>
        </div>
        <div class="col-sm-6">
            <div class="position-static">
              <div class="position-absolute top-0 end-0 mt-3 me-3">
                <button id="generateEvtBtn" class="btn btn-primary bi bi-wifi" title="Generate Event" type="button"></button>
              </div>
            </div>
      </div>
      </div>

      <div class="row">
        <div class="col-lg-6">          
          <div class="row mb-3">
            <div class="col-lg-3 label "><strong>Judul</strong></div>
            <div class="col-lg-9">{{$dataUtama->first()->judul}}</div>
          </div>
          <div class="row mb-3">
            <div class="col-lg-3 label "><strong>Author</strong></div>
            <div class="col-lg-9">{{$dataUtama->first()->author}}</div>
          </div>
          <div class="row mb-3">
            <div class="col-lg-3 label "><strong>Revision</strong></div>
            <div class="col-lg-9">{{$dataUtama->first()->revisi}}</div>
          </div>
          <div class="row mb-3">
            <div class="col-lg-3 label "><strong>Multiple Choice</strong></div>
            <div id="mcQty" class="col-lg-2">100</div>
          </div>
          <div class="row mb-3">
            <div class="col-lg-3 label "><strong>True/False</strong></div>
            <div id="tfQty" class="col-lg-2">10</div>
          </div>
          <div class="row mb-3">
            <div class="col-lg-3 label "><strong>Matching</strong></div>
            <div id="matcQty" class="col-lg-2">20</div>
          </div>
        </div>

        <div class="col-lg-6">
        </div>
       
      </div>
      <input id="idSoalUtama" type="hidden" value="{{$dataUtama->first()->idSoalUtama}}">
      <input type="hidden" id="blankImgPath" value="{{$blankImgPath}}">
      <input type="hidden" id="blankImgMatchingPathB" value="{{$blankImgPathMatchingB}}">
    </div>
</div>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Multiple Choice</h5>
    <div class="col-lg-12">
      <div id="wasem"></div>
      <div class="bottom-0 start-3 mt-3">
        <button id="newSoalMc" type="button" class="btn btn-primary" title="Tambah soal pilihan ganda"><i class="bi bi-plus-square-fill"></i></button>
      </div>
    </div>
  </div>
</div> 

<div class="card">
  <div class="card-body">
    <h5 class="card-title">True or False</h5>
    <div class="col-lg-12">
      <div id="enak"></div>
      <div class="bottom-0 start-3 mt-3">
        <button type="button" id="newSoalTfBtn" class="btn btn-primary" title="Tambah soal benar salah"><i class="bi bi-plus-square-fill"></i></button>
      </div>
    </div>
  </div>
</div> 

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Matching</h5>
    <div class="col-lg-12">
      <div id="crotz">
      </div>
      <div class="bottom-0 start-3 mt-3">
        <button type="button" id="newMatchingBtn" class="btn btn-primary" title="Tambah soal Mencocokan"><i class="bi bi-plus-square-fill"></i></button>
      </div>
    </div>
  </div>
</div> 
{{-- end card --}}

<!-- Modal Delete Soal-->
<div class="modal fade" id="deleteSoalModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Warning</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5>Apakah anda yakin ingin menghapus :</h5>
        <p id="isiSoalDelete"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ga Jadi</button>
        <button id="okDel" type="button" data-del='' class="btn btn-danger">Yo..ii guys</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal new Soal Multiple Choice-->
<div id="modalDelete"></div>
<div id="modalMc"></div>
<div id="modalTf"></div>
<div id="modalMatching"></div>
<div id="modalGenerateEvent"></div>
<div id="modalEventLink"></div>
@endsection

@push('scripts')
<script src="assets/js/qrcode.min.js"> </script>
<script src="assets/js/bankSoalDetail.js"> </script>
@endpush

