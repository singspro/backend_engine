@extends('layouts/main')

@section('container')

<!-- Training New Form -->
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Input Training</h5>
<form id="newTr" autocomplete="off" enctype="multipart/form-data">
    @csrf
  <div class="row mb-3">
    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Kode||Nama Training</label>
    <div class="col-md-8 col-lg-9">
      <select name="kodeTraining" id="kodeTraining" class="form-select" autofocus>
        <option value>Choose kode dan nama training</option>
        @foreach($kodeTraining as $data)
        <option value="{{ $data->kode }}">{{ $data->kode."||".$data->judul }}</option>
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
        <option value="{{ $data->id }}">{{ $data->uraianMateri }}</option>
        @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label for="noMp" class="col-md-4 col-lg-3 col-form-label">Lokasi</label>
    <div class="col-md-8 col-lg-9">
      <select name="lokasi" id="lokasi" class="form-select">
        <option value>Choose lokasi</option>
        @foreach($lokasiTraining as $data)
        <option value="{{ $data->id }}">{{ $data->lokasiTraining }}</option>
        @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="row mb-3">
    <label for="pers" class="col-md-4 col-lg-3 col-form-label">Lembaga</label>
    <div class="col-md-8 col-lg-9">
      <select name="lembaga" id="lembaga" class="form-select">
        <option value>Choose lembaga</option>
        @foreach($lembagaTraining as $data)
        <option value="{{ $data->id }}">{{ $data->lembaga }}</option>
        @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>

  <div class="row mb-3">
    <label for="sect" class="col-md-4 col-lg-3 col-form-label">Instructor</label>
    <div class="col-md-8 col-lg-9">
      <select name="instructor" id="instructor" class="form-select">
        <option value>Choose instructor</option>
        @foreach($instructor as $data)
        <option value="{{ $data->id }}">{{ $data->namaInstructor }}</option>
        @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>

  <div class="row mb-3">
    <label class="col-md-4 col-lg-3 col-form-label">Start Date</label>
    <div class="col-md-8 col-lg-9">
      <input name="startDate" type="date" class="form-control" id="startDate" value="">
      <div class="invalid-feedback"></div>
    </div>
  </div>

  <div class="row mb-3">
    <label  class="col-md-4 col-lg-3 col-form-label">End Date</label>
    <div class="col-md-8 col-lg-9">
      <input name="endDate" type="date" class="form-control" id="endDate" value="">
      <div class="invalid-feedback"></div>
      {{-- @error('ssect')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror --}}
    </div>
  </div>

  <div class="row mb-3">
    <label for="jbtStr" class="col-md-4 col-lg-3 col-form-label">Category</label>
    <div class="col-md-8 col-lg-9">
      <select name="category" class="form-select" id="category" value="">
        <option>IHT</option>
        <option>PUBLIC</option>
      </select>
    </div>
  </div>

  <div class="row mb-3">
    <label class="col-md-4 col-lg-3 col-form-label">Program Training</label>
    <div class="col-md-8 col-lg-9">
      <select name="programTraining" class="form-select" id="programTraining">
        <option>PPD</option>
        <option>ID</option>
        <option>AMI</option>
        <option>OHS</option>
      </select>
    </div>
  </div>

  <div class="row mb-3">
    <label  class="col-md-4 col-lg-3 col-form-label">Hard/Soft</label>
    <div class="col-md-8 col-lg-9">
      <select name="hardSoft" class="form-select" id="hardSoft" >
        <option>Hard</option>
        <option>Soft</option>
      </select>
    </div>
  </div>


  <div class="row mb-3">
    <label class="col-md-4 col-lg-3 col-form-label">Remark</label>
    <div class="col-md-8 col-lg-9">
      <textarea name="remark" type="text" class="form-control" id="remark"></textarea>
    </div>
  </div>

  <div class="row mb-3">
    <label class="col-md-4 col-lg-3 col-form-label">Upload Absensi <span style="color: red">(format PDF)<span></label>
    <div class="col-md-8 col-lg-9">
      <input type="file" class="form-control" name="fileAbsensi" id="fileAbsensi" accept="application/pdf">
    </div>
  </div>

  <div class="row mb-3">
    <label class="col-md-4 col-lg-3 col-form-label">Dokumen Training <span style="color: red">(format PDF)<span></label>
    <div class="col-md-8 col-lg-9">
      <input type="file" class="form-control" name="fileDokumenTraining" id="fileDokumenTraining" accept="application/pdf">
    </div>
  </div>
</form><!-- End Profile Edit Form -->
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Peserta Training</h5>
<div class="rom mb-3">
  <div class="table-responsive">
    <table id="peserta" class="table table-hover">
        <thead>
            <tr>
                <th>NRP</th>
                <th>Nama</th>
                <th>Pre</th>
                <th>Post</th>
                <th>Prac.</th>
                <th>Result</th>
                <th>Remark</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
    <div id="pesertaDanger" class="text-danger collapse">
      <h4>Helllooww.. peserta masih kosong diisi dong...</h4>
    </div>
    <button id="addParticipant" type="button" class="btn btn-primary">+</button>
</div>
  </div>
</div>
  <div class="text-center">
    <button id="saveBtn" type="button" class="btn btn-primary">Save</button>
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
              <option value="{{ $data->nrp."||".$data->nama."||".$data->perusahaan."||".$data->jabatanFn }}">{{ $data->nrp."||".$data->nama."||".$data->perusahaan."||".$data->jabatanFn }}</option>
              @endforeach
            </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Pre Test</label>
              <input type="number" name="preTest" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Post Test</label>
              <input type="number" name="postTest" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Practice</label>
              <input type="number" name="practice" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Result</label>
              <select name="result" class="form-select">
                <option value="Pass">Pass</option>
                <option value="Fail">Fail</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Remark</label>
              <textarea name="remark" class="form-control"></textarea>
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
dselect(document.querySelector('#instructor'),{search: true});
dselect(document.querySelector('#namaParticipant'),{search: true});


$(document).ready(function(){

  $(document).on('click','#saveBtn',function(){
    $('#newTr').submit();
  })

  $(document).on('submit','#newTr',function(e){
    e.preventDefault();
    let formData = new FormData(this);

    formData.append('peserta',JSON.stringify(pushData.data));
    $('#loadingSubmitModal').modal('show');
    let x = document.getElementById('progressBar');
    sendData(formData,x);
    // window.location.replace('/trainingNewSave');
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
      perusahaan:y[2],
      jabatan:y[3],
      preTest:formData.get('preTest'),
      postTest:formData.get('postTest'),
      practice:formData.get('practice'),
      result:formData.get('result'),
      remark:formData.get('remark')
    }
    pushData.setNew(dataIn);
    viewData(pushData.data,document.querySelector('#peserta tbody'));
  });

  $(document).on('click','#deletePesertaBtn',function(){
    let x = $(this).data('id');
    pushData.setDelete(x);
    viewData(pushData.data,document.querySelector('#peserta tbody'));

  })
 
})

// callback functions group------------------------------------------------------------
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
			url:'/trainingSave',
			data: data,
			contentType:false,
			cache:false,
			processData:false,
      success:function(data){
        setTimeout(() => {
            $('#loadingSubmitModal').modal('hide');
            location.replace(`trainingDetail?imore=${ data.idTr}`);
          }, 2000);
      },
      error:function(err){
        let x = JSON.parse(err.responseText);
        showError.errors=x;
        if(!showError.success()){
          setTimeout(() => {
            $('#loadingSubmitModal').modal('hide');
            if(showError.err().hasOwnProperty('idTr')){
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
          showError.get('instructor');
          showError.get('startDate');
          showError.get('endDate');

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
      perusahaan:y.perusahaan,
      jabatan:y.jabatan,
      preTest:y.preTest,
      postTest:y.postTest,
      practice:y.practice,
      result:y.result,
      remark:y.remark,
      newData:true,
      delete:false
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
      let preTest = y.insertCell(2);
      let postTest = y.insertCell(3);
      let practice = y.insertCell(4);
      let result = y.insertCell(5)
      let remark = y.insertCell(6);
      let action = y.insertCell(7);
      
      nrp.innerHTML =value.nrp;
      nama.innerHTML = value.nama;
      preTest.innerHTML = value.preTest;
      postTest.innerHTML = value.postTest;
      practice.innerHTML = value.practice;
      result.innerHTML = value.result;
      remark.innerHTML = value.remark;
      action.innerHTML = `<button id='deletePesertaBtn' data-id='${value.nrp}' class='btn ri-delete-bin-5-fill'></button>`;
    }
  })

}

function clearSelection(el)
{
  dselectClear(el.nextElementSibling.querySelector('button'), 'dselect-wrapper');
}
</script>
@endpush