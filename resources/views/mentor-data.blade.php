@extends('layouts/main')

@section('container')
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Data Mentoring</h5>
      <div class="d-flex justify-content-end">
        <form action="/mentor">
        <div class="input-group mb-3">
          <input type="text" name="search" class="form-control" placeholder="Cari mentor" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{Request('search')}}">
          <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
        </div>
      </form>
        </div>
      <!-- Table with hoverable rows -->
      <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">NRP</th>
            <th scope="col">Nama</th>
            <th scope="col">Sub-Section</th>
            <th scope="col">Kode</th>
            <th scope="col">Judul</th>
            <th scope="col">Date</th>
            <th scope="col">Instructor</th>
            <th scope="col">Jenis</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
@foreach ($dataOji as $item)
    
<tr>
  <td><button class="btn" id="detailOji" data-id="{{$item->idOji}}">{{$item->nrp}}</button></td>
  <td>{{$item->nama}}</td>
  <td>{{$item->subSection}}</td>
  <td>{{$item->kodeKompetensi}}</td>
  <td>{{$item->namaKompetensi}}</td>
  <td>{{$item->startDate}}</td>
  <td>{{$item->namaInstructor}}</td>
  <td>{{$item->jenisOji}}</td>
  <td><button id="detailBtn" data-id="{{$item->idOji}}" class="btn"><i class="bi bi-card-checklist"></i></button></td>
</tr>
@endforeach

       
        </tbody>
      </table>
    </div>
    {{$dataOji->links()}}
      <!-- End Table with hoverable rows -->
    
    </div>
</div>


<div class="modal fade" id="detailOjiModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Mentoring</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">Nama</div>
          <div id="nama" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">NRP</div>
          <div id="nrp" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">Jabatan</div>
          <div id="jabatan" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">Job Area</div>
          <div id="jobArea" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">Kode kompetensi</div>
          <div id="kodeKompetensi" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">Nama Kompetensi</div>
          <div id="namaKompetensi" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">Jenis Mentor</div>
          <div id="jenisKompetensi" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">Start Date</div>
          <div id="startDate" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">End Date</div>
          <div id="endDate" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">Start Time</div>
          <div id="startTime" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">End Time</div>
          <div id="endTime" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">Remark</div>
          <div id="remark" class="col-lg-9 col-sd-8"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-3 col-sd-4 label ">Absensi</div>
          <div class="iconslist">
            <div class="icon">
              <a id="hasFile" href=""><i class="bi bi-file-earmark-pdf"></i></a>
              <i id="noFile" class="bi bi-file-earmark-x" title="No File"></i>
              <div class="label">Absensi</div>
            </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button"  id="deleteBtnOji" class="btn btn-danger" >Delete</button>
        <button type="button"  id="editBtn" class="btn btn-primary">Edit</button>
      </div>
    </div>
  </div>
</div><!-- End Basic Modal-->

<div class="modal fade" id="editOji" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Mentoring</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editMentorForm"  autocomplete="off" enctype="multipart/form-data">
          <div class="mb-3">
          <label for="nama" class="form-label">NRP||Nama||Jabatan||Sub-Section||Perusahaan</label>
          <select name="namaEdit" id="namaEdit" class="form-select">
            <option></option>
          </select>
          </div>

          <div class="mb-3">
            <label for="jenis" class="form-label">Jenis</label>
            <select name="jenisEdit" id="jenisEdit" class="form-select">
                <option></option>
            </select>
          </div>

          <div class="mb-3">
          <label for="materi" class="form-label">Kode||Nama Materi</label>
          <select name="materiEdit" id="materiEdit" class="form-select" >
            <option value></option>
          </select>
          <div class="invalid-feedback">
            Kosong.... isi dong...!
          </div>

          </div>
          <div class="mb-3">
          <label for="instructor" class="form-label">Instructor</label>
          <select name="instructorEdit" id="instructorEdit" class="form-select" >
            <option value></option>
          </select>
          <div class="invalid-feedback">
            Ini self learning ya ?
          </div>
          </div>

          <div class="mb-3">
              <label for="startDate" class="form-label">Start Date</label>
              <input type="date" name="startDateEdit" id="startDateEdit" class="form-control" >
              <div class="invalid-feedback">
                Kapan Mulainya ??
              </div>
          </div>

          <div class="mb-3">
              <label for="endDate" class="form-label">End Date</label>
              <input type="date" name="endDateEdit" id="endDateEdit" class="form-control" >
              <div class="invalid-feedback">
                Terus sampai kapan ??
              </div>
          </div>
          
          <div class="mb-3">
              <label for="startTime" class="form-label">Start Time</label>
              <input type="time" name="startTimeEdit" id="startTimeEdit" class="form-control" >
              <div class="invalid-feedback">
                Mulai Jam berapa ya ??
              </div>
          </div>

          <div class="mb-3">
              <label for="endTime" class="form-label">End Time</label>
              <input type="time" name="endTimeEdit" id="endTimeEdit" class="form-control" >
              <div class="invalid-feedback">
                Ini mentor masih belum selesai ya ?
              </div>
          </div>
          <div class="mb-3">
              <label for="remark" class="form-label">Remark</label>
              <textarea name="remarkEdit" id="remarkEdit" class="form-control" ></textarea>
          </div>

          <div class="mb-3">
            <div class="iconslist">
              <div class="icon">
                <div id="fileAbsensiIcon">
                </div>
                <input type="file" class="form-control" name="fileAbsensi" id="fileAbsensi" hidden>
              </div>
            </div>
          </div>
          <input type="hidden" class="form-control" name="idOjiOld" id="idOjiOld">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
           <button type="submit" class="btn btn-success">Save Edit</button>
      </div>
    </form>
    </div>
  </div>
</div><!-- End Basic Modal-->

<div class="modal fade" id="deleteOjiModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Warning.....</h5>
      </div>
      <div class="modal-body">
        <h4>Yakin akan menghapus data ini ?? ?? </h4>
      </div>
      <div class="modal-footer">
        <button type="button" id="deleteOjiBtnOk" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div><!-- End Basic Modal-->

@endsection

@push('scripts')
<script>
  $(document).ready(function(){
    $(document).on('click','#detailOji',function(){
    });

    $(document).on('click','#detailBtn',async function(){
      try {
        let a=await getData($(this).data('id'));
        showData(a);

        $('#detailOjiModal').modal('show');
      } catch (error) {

      }
      
      
    });
    $(document).on('click','#editBtn',async function(){
      $('#detailOjiModal').modal('hide');
      let idOji=$(this).attr('data-idoji');
      try {
        let data=await getEditOji(idOji);
        manpowerOjiModalEdit('namaEdit',data.manpower,data.dataOjiByID.nrp);
        jenisdOjiModalEdit('jenisEdit',data.jenis,data.dataOjiByID.jenisOji);
        kompetensiOjiModalEdit('materiEdit',data.kodeKompetensi,data.dataOjiByID.kodeKompetensi);
        instructorOjiModalEdit('instructorEdit',data.instructor,data.dataOjiByID.instructor);
        fileOjimodelEdit(data.file);
        document.getElementById('startDateEdit').value=data.dataOjiByID.startDate;
        document.getElementById('endDateEdit').value=data.dataOjiByID.endDate;
        document.getElementById('startTimeEdit').value=data.dataOjiByID.startTime;
        document.getElementById('endTimeEdit').value=data.dataOjiByID.endTime;
        document.getElementById('remarkEdit').value=data.dataOjiByID.remark;
        document.getElementById('idOjiOld').value=idOji;
        $('#editOji').modal('show');
      } catch (error) {
        
      }
    });

    $(document).on('click','#uploadAbsensi',function(){
      $('#fileAbsensi').click();
    });

    $(document).on('click','#deleteFileAbsensi',function(){
      fileStatus.delete=true;
      document.getElementById('fileAbsensi').value='';
      fileImage();
    });

    $(document).on('submit','#editMentorForm',function(e){
      e.preventDefault();
      let formData=new FormData(this);
      formData.append('delete',fileStatus.delete);
      validation.validating(formData,validator);
            if(!validation.status){
                validationList();
            }else{
              saveEditOji(formData);
            }
      
    });

    $(document).on('change','#fileAbsensi',function(){
      fileChange();
    });

    $(document).on('click','#deleteBtnOji',function(){
      $('#detailOjiModal').modal('hide');
      $('#deleteOjiModal').modal('show');
      document.getElementById('deleteOjiBtnOk').setAttribute('data-idoji',$(this).attr('data-idoji'));
      
    });

    $(document).on('click','#deleteOjiBtnOk',function(){
      deleteCommand($(this).attr('data-idoji'));
    });
  }); //end off document ready function

//calback function

function deleteCommand(idOji){
  $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      return $.ajax({
        type: 'POST',
        url:'/kocok',
        data: {idOji:idOji},
        success:function(ss){
          if(ss.success){
            location.replace('/mentor');
          }
        }
      })
}

function validationList(){
            let x=validation.message;
            if(x.hasOwnProperty('namaEdit')){
            let id=document.getElementById('namaEdit');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('materiEdit')){
            let id=document.getElementById('materiEdit');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('startDateEdit')){
              let id=document.getElementById('startDateEdit');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('endDateEdit')){
              let id=document.getElementById('endDateEdit');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('startTimeEdit')){
              let id=document.getElementById('startTimeEdit');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('endTimeEdit')){
              let id=document.getElementById('endTimeEdit');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('instructorEdit')){
              let id=document.getElementById('instructorEdit');
              id.classList.add('is-invalid');
            }
    }

let validator=[
      {id:'namaEdit', valid:'required',message:'Materi belum diisi',param:''},
      {id:'materiEdit', valid:'required',message:'Materi belum diisi',param:''},
      {id:'startDateEdit',valid:'required',message:'Start Date belum diisi',param:''},
      {id:'endDateEdit',valid:'required',message:'End Date belum diisi',param:''},
      {id:'startTimeEdit',valid:'required',message:'Start Time belum diisi',param:''},
      {id:'endTimeEdit',valid:'required',message:'End Date belum diisi',param:''},
      {id:'instructorEdit',valid:'required',message:'End Date belum diisi',param:''}
     ];

let validation={
        status:true,
        message:{},
        validating:function(formData,validator){
                    this.status=true;
                    validator.forEach((element)=> {
                      switch (element.valid) {
                        case 'required':
                          if(formData.get(element.id)===''){
                            this.status=false;
                            this.message[element.id]=element.message;
                          }else{
                            delete this.message[element.id];
                          } 
                          break;
                        case 'notIn':
                        
                          break;

                        case 'in':

                          break;
                        default:
                          this.status=true;
                          this.message={};
                          break;
                      
                      }    
                    });
      }
    }



let fileStatus={
  delete:false
}

function saveEditOji(formData){
  $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      return $.ajax({
        type: 'POST',
        url:'/moncrot',
        contentType:false,
			  cache:false,
			  processData:false,
        data: formData,
        success:function(ss){
          if(ss.success){
            location.replace('/mentor');
          }
        }
      })
}

function getEditOji(idOji){
  $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      return $.ajax({
        type: 'POST',
        url:'/bbwIsHot',
        data: {idOji:idOji}
      })
}

function showData(a){
  let data=a.data;

  document.getElementById('nama').innerHTML=data.nama;
  document.getElementById('nrp').innerHTML=data.nrp;
  document.getElementById('jabatan').innerHTML=data.jabatanFn;
  document.getElementById('jobArea').innerHTML=data.jobArea;
  document.getElementById('kodeKompetensi').innerHTML=data.kodeKompetensi;
  document.getElementById('namaKompetensi').innerHTML=data.namaKompetensi;
  document.getElementById('jenisKompetensi').innerHTML=data.jenisOji;
  document.getElementById('startDate').innerHTML=data.startDate;
  document.getElementById('endDate').innerHTML=data.endDate;
  document.getElementById('startTime').innerHTML=data.startTime;
  document.getElementById('endTime').innerHTML=data.endTime;
  document.getElementById('remark').innerHTML=data.remark;
  document.getElementById('editBtn').setAttribute('data-idoji',data.idOji);
  document.getElementById('deleteBtnOji').setAttribute('data-idoji',data.idOji);

  if(a.file){
    document.getElementById('hasFile').style.display='block';
    document.getElementById('hasFile').href=`/kentut?id=${data.idOji}`;
    document.getElementById('noFile').style.display='none';
  }else{
    document.getElementById('hasFile').style.display='none';
    document.getElementById('noFile').style.display='block';
  }
}

function getData(id){
  $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      return $.ajax({
        type: 'POST',
        url:'/asemKecut',
        data: {id:id}
      })
}

function jenisdOjiModalEdit(idMateri,data,idSelected){
            let y=document.getElementById(idMateri);
            y.innerHTML="";
            let ya=document.createElement('option');
            data.forEach(x => {
              let ya=document.createElement('option');
              if(x===idSelected){
                ya.setAttribute('selected','');
              }
              ya.value=x;
              ya.innerHTML=x;
              y.appendChild(ya); 
                         
            });
            dselect(y,{search: true});
}

function manpowerOjiModalEdit(idMateri,data,idSelected){
            let y=document.getElementById(idMateri);
            y.innerHTML="";
            let ya=document.createElement('option');
            data.forEach(x => {
              let ya=document.createElement('option');
              if(idSelected===x.nrp){
                ya.setAttribute('selected','');
              }
              ya.value=x.nrp;
              ya.innerHTML=`${x.nrp}||${x.nama}||${x.jabatanFn}||${x.perusahaan}`;
              y.appendChild(ya);              
            });
            dselect(y,{search: true});
}
function kompetensiOjiModalEdit(idMateri,data,idSelected){
             let y=document.getElementById(idMateri);
            y.innerHTML="";
            let ya=document.createElement('option');
            data.forEach(x => {
              let ya=document.createElement('option');
              if(idSelected===x.kode){
                ya.setAttribute('selected','');
              }
              ya.value=x.kode;
              ya.innerHTML=`${x.kode}||${x.namaKompetensi}`;
              y.appendChild(ya);              
            });
            dselect(y,{search: true});
}
function instructorOjiModalEdit(idMateri,data,idSelected){
            let y=document.getElementById(idMateri);
            y.innerHTML="";
            let ya=document.createElement('option');
            data.forEach(x => {
              let ya=document.createElement('option');
              if(idSelected===x.id){
                ya.setAttribute('selected','');
              }
              ya.value=x.id;
              ya.innerHTML=x.namaInstructor;
              y.appendChild(ya);              
            });
            dselect(y,{search: true});
}

function fileOjimodelEdit($fileStatus){
  let i=document.getElementById('fileAbsensiIcon');
  i.innerHTML='';
if($fileStatus){
  i.innerHTML="<i class='bi bi-file-earmark-pdf'></i><div class='label'>Absensi</div><button id='deleteFileAbsensi' type='button' class='btn bi bi-trash'></button><button id='uploadAbsensi' type='button' class='btn bi bi-upload' title='Click To Upload'></button>";
}else{
  i.innerHTML="<i class='bi bi-file-earmark-x' title='No File Guys'></i><div class='label'>Absensi</div><button id='uploadAbsensi' type='button' class='btn bi bi-upload' title='Click To Upload'></button>";
}
}

function fileImage(){
  let i=document.getElementById('fileAbsensiIcon');
  i.innerHTML='';
  i.innerHTML="<i class='bi bi-file-earmark-x' title='No File Guys'></i><div class='label'>Absensi</div><button id='uploadAbsensi' type='button' class='btn bi bi-upload' title='Click To Upload'></button>";
}

function fileChange(){
  let i=document.getElementById('fileAbsensiIcon');
  i.innerHTML='';
  i.innerHTML="<i class='bi bi-file-earmark-pdf'></i><div class='label'>Absensi</div><button id='deleteFileAbsensi' type='button' class='btn bi bi-trash'></button><button id='uploadAbsensi' type='button' class='btn bi bi-upload' title='Click To Upload'></button>";
}
</script>
    
@endpush