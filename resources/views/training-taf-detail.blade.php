@extends('layouts/main')

@section('container')
<div class="card">
    <div class="card-body">
      <h5 class="card-title">TAF Detail</h5>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Create Date</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->createDate}}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">To</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->to}}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">From</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->from}}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Subject</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->subject}}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Jenis TAF</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->jenisTaf}}</div>
      </div>


      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">kode || Nama Training</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->kodeTraining."||".$dataTaf->first()->judul}}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Uraian Materi</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->uraianMateri}}</div>
      </div>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Lokasi</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->lokasiTraining}}</div>
      </div>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Start Date</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->startDate}}</div>
      </div>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">End Date</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->endDate}}</div>
      </div>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Penyelenggara</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->namaLembaga}}</div>
      </div>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Biaya</div>
        <div class="col-lg-9 col-md-8">{{($dataTaf->first()->biaya===null)? "-":$dataTaf->first()->biaya}}</div>
      </div>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Diajukan Oleh</div>
        <div class="col-lg-9 col-md-8">{{$dataTaf->first()->pjo}}</div>
      </div>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Disetujui Oleh (Div. Head/Director)</div>
        <div class="col-lg-9 col-md-8">{{($dataTaf->first()->divisi===null)?"-":$dataTaf->first()->divisi}}</div>
      </div>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Diperiksa Oleh (Dept. Head)</div>
        <div class="col-lg-9 col-md-8">{{($dataTaf->first()->dept===null)? "-":$dataTaf->first()->dept}}</div>
      </div>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Div. Head PEDD/Director HR</div>
        <div class="col-lg-9 col-md-8">{{($dataTaf->first()->hr===null)?"-":$dataTaf->first()->hr}}</div>
      </div>
      
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Peserta</h5>
      <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>NRP</th>
                    <th>Nama</th>
                    <th>Departemen</th>
                    <th>Jabatan</th>
                    <th>Joint Date</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($dataPeserta as $item)
              <tr>
                <td>{{$item->nrp}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->section}}</td>
                <td>{{$item->jabatanFn}}</td>
                <td>{{$item->jointDate}}</td>
              </tr>
                  
              @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <button id="angel" class="btn btn-danger mt-3">Delete</button>
      <a href="/sabun?enak={{urlencode(Request('data'))}}" class="btn btn-success mt-3">Edit</a>
      <button id="cetak" data-id="{{Request('data')}}" class="btn btn-success mt-3">Generate PDF</button>
    </div>
  </div>

  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Warning.....</h5>
        </div>
        <div class="modal-body">
          <h4>Yakin akan menghapus data TAF ini ??</h4>
        </div>
        <div class="modal-footer">
          <a href="/ngonok?crut={{urlencode(Request('data'))}}" type="button" class="btn btn-danger">ok</a>
        </div>
      </div>
    </div>
  </div><!-- End Basic Modal--> 
@endsection

@push('scripts')
<script src="assets/js/jscripTfpdf.js"></script>
<script src="assets/js/jspdf.min.js"></script>
<script>
  $(document).ready(function(){
    $(document).on('click','#angel',function(){
      $('#deleteModal').modal('show');
    })

    $(document).on('click','#cetak',async function(){
      try {
        let x=await retrievingData($(this).attr('data-id'));
        rwa(x);
      } catch (error) {}
      
    })
  }) //end ready function


  // function callback-----------------------------------------------------------------
  function retrievingData(idTaf){
    $.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
  return $.ajax({
      type: 'POST',
			url:'/enakenak',
			data: {idTaf:idTaf}
  });
  }
</script>
    
@endpush