@extends('layouts/main')
@section('container')
{{-- @dd($dataTaf) --}}
<form id="editTr" autocomplete="off" enctype="multipart/form-data">
    @csrf

  <div class="row mb-3">
    <label for="createDate" class="col-md-4 col-lg-3 col-form-label">Create Date</label>
    <div class="col-md-8 col-lg-9">
    <input name="createDate" id="createDate" type="date" class="form-control"  value="{{$dataTaf->first()->createDate}}">
    <div class="invalid-feedback"></div>
  </div>
</div>

  <div class="row mb-3">
    <label for="to" class="col-md-4 col-lg-3 col-form-label">To</label>
    <div class="col-md-8 col-lg-9">
    <input name="to" id="to" type="text" class="form-control"  value="{{$dataTaf->first()->to}}">
    <div class="invalid-feedback"></div>
  </div>
</div>
  <div class="row mb-3">
    <label for="from" class="col-md-4 col-lg-3 col-form-label">From</label>
    <div class="col-md-8 col-lg-9">
    <input name="from" id="from" type="text" class="form-control"  value="{{$dataTaf->first()->from}}">
    <div class="invalid-feedback"></div>
  </div>
</div>

  <div class="row mb-3">
    <label for="subject" class="col-md-4 col-lg-3 col-form-label">Subject</label>
    <div class="col-md-8 col-lg-9">
    <input name="subject" id="subject" type="text" class="form-control"  value="{{$dataTaf->first()->subject}}">
    <div class="invalid-feedback"></div>
  </div>
</div>

  <div class="row mb-3">
    <label for="jenisTaf" class="col-md-4 col-lg-3 col-form-label">Jenis TAF</label>
    <div class="col-md-8 col-lg-9">
      <select name="jenisTaf" id="jenisTaf" class="form-select">
        @foreach($jenisTaf as $data)
        @if ($dataTaf->first()->jenisTaf===$data)
        <option selected>{{ $data }}</option>
        @else        
        <option>{{ $data }}</option>
        @endif
        @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Kode||Nama Training</label>
    <div class="col-md-8 col-lg-9">
      <select name="kodeTraining" id="kodeTraining" class="form-select">
        <option value>Choose kode dan nama training</option>
        @foreach($kodeTraining as $data)
        @if ($dataTaf->first()->kodeTraining===$data->kode)
        <option value="{{ $data->kode }}" selected>{{ $data->kode."||".$data->judul }}</option>
        @else        
        <option value="{{ $data->kode }}">{{ $data->kode."||".$data->judul }}</option>
        @endif
        @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label for="nrp" class="col-md-4 col-lg-3 col-form-label">Uraian Materi</label>
    <div class="col-md-8 col-lg-9">
      <select name="uraianMateri" id="uraianMateri" class="form-select">
        <option value>Choose materi</option>
        @foreach($uraianMateri as $data)
        @if ($dataTaf->first()->kodeUraianMateri===$data->id)
          <option value="{{ $data->id }}" selected>{{ $data->uraianMateri }}</option>
        @else
          <option value="{{ $data->id }}">{{ $data->uraianMateri }}</option>
        @endif
        @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label for="noMp" class="col-md-4 col-lg-3 col-form-label">Lokasi</label>
    <div class="col-md-8 col-lg-9">
      <select name="lokasi" id="lokasi" class="form-select">
        @foreach($lokasiTraining as $data)
        @if ($dataTaf->first()->lokasi===$data->id)
        <option value="{{ $data->id }}" selected>{{ $data->lokasiTraining }}</option>
        @else
        <option value="{{ $data->id }}">{{ $data->lokasiTraining }}</option>
        @endif
        @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label for="lembaga" class="col-md-4 col-lg-3 col-form-label">Penyelenggara</label>
    <div class="col-md-8 col-lg-9">
      <select name="lembaga" id="lembaga" class="form-select">
        @foreach($lembagaTraining as $data)
        @if ($dataTaf->first()->lembaga===$data->id)
        <option value="{{ $data->id }}" selected>{{ $data->lembaga }}</option>
        @else  
        <option value="{{ $data->id }}">{{ $data->lembaga }}</option>
        @endif
        @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>

  <div class="row mb-3">
    <label class="col-md-4 col-lg-3 col-form-label">Start Date</label>
    <div class="col-md-8 col-lg-9">
      <input name="startDate" type="date" class="form-control" id="startDate" value="{{ $dataTaf->first()->startDate }}">
      <div class="invalid-feedback"></div>
    </div>
  </div>

  <div class="row mb-3">
    <label  class="col-md-4 col-lg-3 col-form-label">End Date</label>
    <div class="col-md-8 col-lg-9">
      <input name="endDate" type="date" class="form-control" id="endDate" value="{{ $dataTaf->first()->endDate }}">
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label  class="col-md-4 col-lg-3 col-form-label">Biaya</label>
    <div class="col-md-8 col-lg-9">
      <input name="biaya" type="number" class="form-control" id="biaya" value="{{ $dataTaf->first()->biaya }}">
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label  class="col-md-4 col-lg-3 col-form-label">Diajukan Oleh (PJO)</label>
    <div class="col-md-8 col-lg-9">
      <input name="diajukan" type="text" class="form-control" id="diajukan" value="{{ $dataTaf->first()->pjo }}">
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label  class="col-md-4 col-lg-3 col-form-label">Disetujui Oleh (Div. Head/Director)</label>
    <div class="col-md-8 col-lg-9">
      <input name="disetujui" type="text" class="form-control" id="disetujui" value="{{ $dataTaf->first()->divisi }}">
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label  class="col-md-4 col-lg-3 col-form-label">Diperiksa Oleh (Dept. Head)</label>
    <div class="col-md-8 col-lg-9">
      <input name="diperiksa" type="text" class="form-control" id="diperiksa" value="{{ $dataTaf->first()->dept }}">
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label  class="col-md-4 col-lg-3 col-form-label">Div. Head PEDD/Director HR</label>
    <div class="col-md-8 col-lg-9">
      <input name="divHead" type="text" class="form-control" id="divHead" value="{{ $dataTaf->first()->hr }}">
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <input type="hidden" name="idTaf" value="{{Request('enak')}}">
</form><!-- End Profile Edit Form -->

<div class="rom mb-3">
    <label for="rmk" class="col-md-4 col-lg-3 col-form-label">Peserta</label>
    <div class="table-responsive">
    <table id="peserta" class="table table-hover">
        <thead>
            <tr>
                <th>NRP</th>
                <th>Nama</th>
                <th>Departemen</th>
                <th>Jabatan</th>
                <th>Joint Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
    <div id="spinner" class="d-flex justify-content-center">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div><!-- End Center aligned spinner -->
    <div id="pesertaDanger" class="text-danger collapse">
      <h4>Helllooww.. peserta masih kosong diisi dong...</h4>
    </div>
    <button id="addParticipant" type="button" class="btn btn-primary">+</button>
</div>

  <div class="text-center">
    <button id="saveBtn" type="button" class="btn btn-primary">Save Edit</button>
  </div>

<div class="modal fade" id="inputPeserta" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Participant</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="dataParticipant">
            <div class="mb-3">
            <label class="form-label">Nama</label>
            <select name="namaParticipant" id="namaParticipant" class="form-select">
              <option value>Pilih peserta</option>
              @foreach($dataManpower as $data)
              <option value="{{ $data->nrp."||".$data->nama."||".$data->section."||".$data->jabatanFn."||".$data->jointDate}}">{{ $data->nrp."||".$data->nama."||".$data->perusahaan."||".$data->jabatanFn }}</option>
              @endforeach
            </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="submitParticipant" class="btn btn-primary">Add</button>
        </div>
      </div>
    </div>
</div><!-- End Basic Modal-->


<div class="modal fade" id="loadingSubmitModal"  data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Please Wait.....</h5>
      </div>
      <div class="modal-body">
        <div class="progress" role="progressbar" aria-label="Example with label">
          <div id="progressBar" class="progress-bar" style="width: 0%">0%</div>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div><!-- End Basic Modal-->

<div class="modal fade" id="duplicateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Warning.....</h5>
      </div>
      <div class="modal-body">
        <h4>Event training ini sudah ada di database</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">ok</button>
      </div>
    </div>
  </div>
</div><!-- End Basic Modal-->
@endsection

@push('scripts')
<script>
dselect(document.querySelector('#kodeTraining'),{search: true,clearable:true});
dselect(document.querySelector('#uraianMateri'),{search: true, clearable:true});
dselect(document.querySelector('#lokasi'),{search: true});
dselect(document.querySelector('#lembaga'),{search: true});
dselect(document.querySelector('#namaParticipant'),{search: true});

$(document).ready(function(){
  getParticipant('{{ Request('enak')}}')



  $(document).on('click','#deletePesertaBtn',function(){
    let x = $(this).data('id');
    pushData.setDelete(x);
    viewData(pushData.data,document.querySelector('#peserta tbody'));

  })

  $(document).on('click','#addParticipant',function(){
    $('#inputPeserta').modal('show');
  })

  $(document).on('click',"#submitParticipant",function(){
    let x = document.getElementById('dataParticipant');
    let formData = new FormData(x);
    clearSelection(document.querySelector("#namaParticipant"));
    x.reset();
    $('#inputPeserta').modal('hide');
    let y = formData.get('namaParticipant');
    y=y.split("||");
    let dataIn={
      nrp:y[0],
      nama:y[1],
      section:y[2],
      jabatanFn:y[3],
      jointDate:y[4],
      newData:true,
      delete:false
    }
    pushData.setNew(dataIn);
    viewData(pushData.data,document.querySelector('#peserta tbody'));

  });

  $(document).on('click','#saveBtn',function(){
    $('#editTr').submit();
  })

  $(document).on('submit','#editTr',function(e){
    e.preventDefault();
    let formData = new FormData(this);

    formData.append('peserta',JSON.stringify(pushData.data));
    $('#loadingSubmitModal').modal('show');
    let x = document.getElementById('progressBar');
    sendData(formData,x);
   })

   $(document).on('click','#uploadAbsensi',function(){
    $('#fileAbsensi').click();
   });
   
   $(document).on('click','#UploadDokumen',function(){
    $('#fileDokumenTraining').click();
   });


   $(document).on('click','#deleteFileAbsensi',function(){
    let a=document.getElementById('fileAbsensi');
    a.value=null;
    deleteFileElement('fileAbsensiIcon','Absensi','uploadAbsensi');
    fileData.absensi.delete=true;
   })

   $(document).on('click','#deleteFileDokumen',function(){
    let a=document.getElementById('fileDokumenTraining');
    a.value=null;
    deleteFileElement('fileDocumenIcon','Dokumen','UploadDokumen');
    fileData.dokumen.delete=true;
   })

   $(document).on('change','#fileAbsensi',function(){
    setFileElement('fileAbsensiIcon','Absensi','deleteFileAbsensi','uploadAbsensi');
    fileData.absensi.delete=false;
   });
   $(document).on('change','#fileDokumenTraining',function(){
    setFileElement('fileDocumenIcon','Dokumen','deleteFileDokumen','UploadDokumen');
    fileData.dokumen.delete=false;
   });
}) //end document ready function

//-------------------------------callback function--------------------------------------

let fileData={
  absensi:{
    delete:false
  },
  dokumen:{
    delete:false
  }
}

function deleteFileElement(idContainer,judul,uploadBtnId){
  let a=document.getElementById(idContainer);
    a.innerHTML='';

    let i=document.createElement('i');
    i.classList.add('bi');
    i.classList.add('bi-file-earmark-x');
    i.title='No File Guys';

    let j=document.createElement('div');
    j.classList.add('label');
    j.innerHTML=judul;

    let l=document.createElement('button');
    l.classList.add('btn');
    l.classList.add('bi');
    l.classList.add('bi-upload');
    l.id=uploadBtnId;
    l.type='button';
    l.title='Click To Upload'

    a.appendChild(i);
    a.appendChild(j);
    a.appendChild(l);

}

function setFileElement(idContainer,judul,deleteBtnId,uploadBtnId){
  let a=document.getElementById(idContainer);
    a.innerHTML='';

    let i=document.createElement('i');
    i.classList.add('bi');
    i.classList.add('bi-file-earmark-pdf');

    let j=document.createElement('div');
    j.classList.add('label');
    j.innerHTML=judul;

    let k=document.createElement('button');
    k.classList.add('btn');
    k.classList.add('bi');
    k.classList.add('bi-trash');
    k.id=deleteBtnId;
    k.type='button';

    let l=document.createElement('button');
    l.classList.add('btn');
    l.classList.add('bi');
    l.classList.add('bi-upload');
    l.id=uploadBtnId;
    l.type='button';
    l.title='Click To Upload';

    a.appendChild(i);
    a.appendChild(j);
    a.appendChild(k);
    a.appendChild(l);
}

function sendData(data,modalBar){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
  $.ajax({
			xhr: function(){
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress",function(evt){
					if(evt.lengthComputable){
						var percentcomplete=((evt.loaded / evt.total)*100);
            modalBar.style=`width: ${percentcomplete}%`;
            modalBar.innerHTML=percentcomplete+" %";
						if(percentcomplete>=100){
              setTimeout(() => {
                // window.location.replace('/tr-taf');                
              }, 1000);						
						}
					}
				},false);
				return xhr;
			}, //---------xhr----------//
			type: 'POST',
			url:'/dikenyot',
			data: data,
			contentType:false,
			cache:false,
			processData:false,
      success:function(data){
        setTimeout(() => {
            $('#loadingSubmitModal').modal('hide');
            location.replace(`lampunut?data=${data.data}`);
          }, 2000);
      },
      error:function(err){
        let x = JSON.parse(err.responseText);
        showError.errors=x;
        if(!showError.success()){
          setTimeout(() => {
            $('#loadingSubmitModal').modal('hide');
            if(showError.err().hasOwnProperty('idTaf')){
            $('#duplicateModal').modal('show');
            }
            if(showError.err().hasOwnProperty('peserta')){
              let x=document.getElementById('pesertaDanger');
              x.classList.remove('collapse');
            }else{
              let x=document.getElementById('pesertaDanger');
              x.classList.add('collapse');
            }
          }, 2000);
          showError.get('kodeTraining');
          showError.get('uraianMateri');
          showError.get('lokasi');
          showError.get('lembaga');
          showError.get('createDate');
          showError.get('startDate');
          showError.get('endDate');
          showError.get('to');
          showError.get('from');
          showError.get('subject');

        }
      }
			})
      let showError = {
          errors:[],
          success:function(){
            return this.errors.success;
          },
          err:function(){
            let x=this.errors;
            return x.errors;
          },
          get:function(id){
            this[id]=this.formula(id);
          },
          formula:function(id){
            let y=document.getElementById(id);
            let x=this.err();
            if(x.hasOwnProperty(id)){
              let b=document.getElementById(id);
              let d=b.parentNode.querySelector('.invalid-feedback');
              d.innerHTML=x[id][0];             
              y.classList.add('is-invalid');
            }else{
              y.classList.remove('is-invalid');
            }
          }
          
      }

}



function clearSelection(el)
{
  dselectClear(el.nextElementSibling.querySelector('button'), 'dselect-wrapper');
}
let pushData={
  setNew:function(dataIn){
    this.inputData=dataIn;
    let x = this.cekDuplicate(this.inputData,this.data);
    if(!x){
      this.pushData(this.inputData);
      return true;
    } 
    return false;   
  },
  setDelete:function(id){
    let x = this.data;
    let y;
    x.forEach(function(value,index){
      if(value.nrp==id){
        y = index;
      }
    })
    x[y].delete=true;
  },

  setAdd:[],

  inputData:"",
  data:[],
  splits:function(x){
    let a = x.nama;
    return a.split('||');
  },
  cekDuplicate : function(y,x){
    let a=[];
    let b;
    x.forEach(function(value,index){
      a.push(value.nrp);
      b=index;
    })
    if(a.indexOf(y.nrp)>-1 && x[b].delete!=true){
      return true;
    }
    return false;
  },
  pushData:function(input){
    let y = input;
      this.data.push({
      nrp:y.nrp,
      nama:y.nama,
      section:y.section,
      jabatan:y.jabatanFn,
      jointDate:y.jointDate,
      newData:y.newData,
      delete:y.delete
      
    });
    }
}

function viewData(participant, table)
{

  let x = table;
  while (x.hasChildNodes()) {x.removeChild(x.firstChild);}
  participant.forEach(function(value){
    let y =x.insertRow(0);

    if(!value.delete){
      let nrp =y.insertCell(0);
      let nama = y.insertCell(1);
      let section = y.insertCell(2);
      let jabatan = y.insertCell(3);
      let jointDate = y.insertCell(4);
      let action = y.insertCell(5);
      
      nrp.innerHTML =value.nrp;
      nama.innerHTML = value.nama;
      section.innerHTML = value.section;
      jabatan.innerHTML = value.jabatan;
      jointDate.innerHTML = value.jointDate;   
      action.innerHTML = `<button id='deletePesertaBtn' data-id='${value.nrp}' class='btn ri-delete-bin-5-fill'></button>`;
    }
  })

}

function getParticipant(idTaf){
  $.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
  $.ajax({
      type: 'POST',
			url:'/nurulNurjani',
			data: {idTaf:idTaf},
      success:function(data){
        if(data.success){
          const z=data.data;
          const x=document.getElementById('spinner');
          x.remove();
          z.forEach(y => {
            y['newData']=false;
            y['delete']=false;
            pushData.setNew(y);
          });
          viewData(pushData.data,document.querySelector('#peserta tbody'));
        }
      },
      error:function(err){
      }
  })
}

</script>
@endpush