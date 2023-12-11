@extends('layouts/main')

@section('container')

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Training Detail</h5>
      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Judul</div>
        <div class="col-lg-9 col-md-8">{{ ($data->first()->kodeTr==='-')?$data->first()->uraianMateri:$data->first()->judul }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Kode Training</div>
        <div class="col-lg-9 col-md-8">{{ $data->first()->kodeTr }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Location</div>
        <div class="col-lg-9 col-md-8">{{ $data->first()->lokasiTraining }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Lembaga</div>
        <div class="col-lg-9 col-md-8">{{ $data->first()->lembaga }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Instructor</div>
        <div class="col-lg-9 col-md-8">{{ $data->first()->namaInstructor }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Start Date</div>
        <div class="col-lg-9 col-md-8">{{ $data->first()->start }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">End Date</div>
        <div class="col-lg-9 col-md-8">{{ $data->first()->end }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3 col-md-4 label">Program Training</div>
        <div class="col-lg-9 col-md-8">{{ $data->first()->programTraining }}</div>
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
                    <th>Perusahaan</th>
                    <th>Jabatan</th>
                    <th>Pre</th>
                    <th>Post</th>
                    <th>Prac</th>
                    <th>Result</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($data) --}}
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->nrp }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->perusahaan }}</td>
                    <td>{{ $item->jabatanFn }}</td>
                    <td>{{ $item->pre }}</td>
                    <td>{{ $item->post }}</td>
                    <td>{{ $item->practice }}</td>
                    <td>{{ $item->result }}</td>
                    <td>{{ $item->remark }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Document Training</h5>
      <div class="iconslist">
      <div class="icon">
        @if ($absensiCek)
        <a href="{{ route('jokoPrasetyo',['idTr'=>$idTr]) }}"><i class="bi bi-file-earmark-pdf"></i></a>
        @else
        <i class="bi bi-file-earmark-x" title="No File"></i>
        @endif
        <div class="label">Absensi</div>
      </div>
      <div class="icon">
        @if ($dokumenCek)
        <a href="{{ route('ecmv',['idTr'=>$idTr]) }}"><i class="bi bi-file-earmark-pdf"></i></a>
        @else
        <i class="bi bi-file-earmark-x" title="No File"></i>
        @endif
        <div class="label">Document</div>
      </div>
      </div>
    </div>

  </div>
  <div class="card">
    <div class="card-body">
      <a href="/trainingEdit?imore={{ $idTr }}" class="btn btn-success mt-3">Edit</a>
      <button id="angel" class="btn btn-danger mt-3">Delete</button>
      <div class="btn-group mt-3" role="group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Generate</button>
        <ul class="dropdown-menu">
          <li><button id="lotoReportBtn" class="dropdown-item" >AMI report training format</button></li>
          {{-- <li><button id="wahReportBtn" class="dropdown-item" ></button></li> --}}
        </ul>
      </div>
    </div>


  
  </div>

  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Warning.....</h5>
        </div>
        <div class="modal-body">
          <h4>Yakin akan menghapus Training dengan Judul {{ $data->first()->judul}} ?? </h4>
        </div>
        <div class="modal-footer">
          <a href="{{ route('multiflo',['idTr'=>$idTr]) }}" type="button" class="btn btn-danger">ok</a>
        </div>
      </div>
    </div>
  </div><!-- End Basic Modal-->

  <div class="modal fade" id="reportGenerate">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ada yang perlu dirubah..??</h5>
        </div>
        <div class="modal-body">
          <form id='capecik'>
            <div class="row mb-3">
              <label  class="col-sm-2 col-form-label">Kode</label>
              <div class="col-sm-10">
                <input id="kode" type="text" class="form-control" name="kode">
              </div>
            </div>
            <div class="row mb-3">
              <label  class="col-sm-2 col-form-label">Judul</label>
              <div class="col-sm-10">
                <input id="judul" type="text" class="form-control" name="judul">
              </div>
            </div>
            <div class="row mb-3">
              <label  class="col-sm-2 col-form-label">Durasi</label>
              <div class="col-sm-10">
                <input id="durasi" type="text" class="form-control" name="durasi">
              </div>
            </div>
            <div class="row mb-3">
              <label  class="col-sm-2 col-form-label">Tanggal</label>
              <div class="col-sm-10">
                <input id="tanggal" type="date" class="form-control" name="tanggal">
              </div>
            </div>
            <div class="row mb-3">
              <label  class="col-sm-2 col-form-label">Tanggal Ass.</label>
              <div class="col-sm-10">
                <input id="tanggalAssessment" type="date" class="form-control" name="tanggalAssessment">
              </div>
            </div>
            <div class="row mb-3">
              <label  class="col-sm-2 col-form-label">Lokasi</label>
              <div class="col-sm-10">
                <input id="lokasi" type="text" class="form-control" name="lokasi">
              </div>
            </div>
            <div class="row mb-3">
              <label  class="col-sm-2 col-form-label">Instructor</label>
              <div class="col-sm-10">
                <input id="instructor" type="text" class="form-control" name="instructor">
              </div>
            </div>
         
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Generate</button>
        </div>
      </form>
      </div>
    </div>
  </div><!-- End Basic Modal-->
@endsection

@push('scripts')
<script src="assets/js/jspdf.min.js"></script>
<script src="assets/js/generatePdf.js"></script>

<script>
  $(document).ready(function(){
    $(document).on('click','#angel',function(){
      $('#deleteModal').modal('show');
    })
    $(document).on('click','#lotoReportBtn',async function(){
      try {
        let data=await getData('{{$idTr}}');
        dataTraining.header.judul=data.data[0].uraianMateri;
        dataTraining.header.tanggal=value=data.data[0].start
        dataTraining.header.tanggalAssessment=value=data.data[0].start
        dataTraining.header.lokasi=data.data[0].lokasiTraining;
        dataTraining.header.instructor=data.data[0].namaInstructor;
        
        data.peserta.forEach(element => {
          let i={
            minePermit:element.noMinePermit,
            nama:element.nama,
            perusahaan:element.perusahaanAbr,
            posisi:element.jabatanFn,
            preTest:element.pre,
            postTest:element.post,
            practice:element.practice,
            hasil:(element.post<75)?'NYC':'CO',
            keterangan:element.remark
          }
          dataTraining.peserta.push(i);
        });

        document.getElementById('kode').value=dataTraining.header.kode;
        document.getElementById('judul').value=dataTraining.header.judul;
        document.getElementById('durasi').value=dataTraining.header.durasi;
        document.getElementById('tanggal').value=dataTraining.header.tanggal;
        document.getElementById('tanggalAssessment').value=dataTraining.header.tanggalAssessment;
        document.getElementById('lokasi').value=dataTraining.header.lokasi;
        document.getElementById('instructor').value=dataTraining.header.instructor;
        $('#reportGenerate').modal('show');
      } catch (error) {
        
      }

    })

    $(document).on('submit','#capecik', async function(e){
      e.preventDefault();
      let x=new FormData(this);
        dataTraining.header.judul=x.get('judul');
        dataTraining.header.kode=x.get('kode');
        dataTraining.header.durasi=x.get('durasi');
        dataTraining.header.tanggal=x.get('tanggal');
        dataTraining.header.tanggalAssessment=x.get('tanggalAssessment');
        dataTraining.header.lokasi=x.get('lokasi');
        dataTraining.header.instructor=x.get('instructor');
        generatePdf.data(dataTraining);
        $('#reportGenerate').modal('hide');
       
    });
  }) //end ready function

  function getData(idTr){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

     return $.ajax({
        type: 'POST',
        url:'/hotSekali',
        data:{idTr:idTr},
      });
  }

  let dataTraining={
    header:{
        kode:'-',
        judul:'-',
        durasi:'3 Jam',
        tanggal:'-',
        tanggalAssessment:'-',
        lokasi:'-',
        instructor:'-',
    },
    peserta:[]
  }
</script>
    
@endpush