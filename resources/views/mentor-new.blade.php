@extends('layouts/main')

@section('container')
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Input Mentoring</h5>

      <!-- Table with hoverable rows -->
      <div class="table-responsive">
      <table id="ojiTbl" class="table table-hover">
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
      
        </tbody>
      </table>
    </div>
    <button type="button" id="addBtn" class="btn btn-success">add</button>
      <!-- End Table with hoverable rows -->
    
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="mt-3">
        <button type="button" id="saveAllMentorCoy" class="btn btn-success">Save</button>
        </div>
    </div>
</div>

<div class="modal fade" id="insertMentor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New Mentor</h5>
        </div>
        <div class="modal-body">
          <form id="addMentor"  autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
            <label for="nama" class="form-label">NRP||Nama||Jabatan||Sub-Section||Perusahaan</label>
            <input type="text" class="form-control" id="namaSelected" name="namaSelected" disabled>
            <input type="text"  id="nameSelected" name="nameSelected" hidden>
            </div>

            <div class="mb-3">
              <label for="jenis" class="form-label">Jenis</label>
              <select name="jenis" id="jenis" class="form-select">
                  @foreach ($jenis as $item)
                  <option>{{$item}}</option>
                  @endforeach
              </select>
            </div>

            <div id="spinnerMateriToggle" class="mb-3">
              <label class="form-label">Kode||Nama Materi</label>
              <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div><!-- End Center aligned spinner -->
            </div>

            <div id="materiToggle" class="mb-3">
            <label for="materi" class="form-label">Kode||Nama Materi</label>
            <select name="materi" id="materi" class="form-select" >
              <option value></option>
            </select>
            <div class="invalid-feedback">
              Kosong.... isi dong...!
            </div>
            </div>

            <div class="mb-3">
            <label for="instructor" class="form-label">Instructor</label>
            <select name="instructor" id="instructor" class="form-select" >
              <option value></option>
            </select>
            <div class="invalid-feedback">
              Ini self learning ya ?
            </div>
            </div>

            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" name="startDate" id="startDate" class="form-control" >
                <div class="invalid-feedback">
                  Kapan Mulainya ??
                </div>
            </div>

            <div class="mb-3">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" name="endDate" id="endDate" class="form-control" >
                <div class="invalid-feedback">
                  Terus sampai kapan ??
                </div>
            </div>
            
            <div class="mb-3">
                <label for="startTime" class="form-label">Start Time</label>
                <input type="time" name="startTime" id="startTime" class="form-control" >
                <div class="invalid-feedback">
                  Mulai Jam berapa ya ??
                </div>
            </div>

            <div class="mb-3">
                <label for="endTime" class="form-label">End Time</label>
                <input type="time" name="endTime" id="endTime" class="form-control" >
                <div class="invalid-feedback">
                  Ini mentor masih belum selesai ya ?
                </div>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Document</label>
                <input type="file" name="file" id="file" class="form-control" >
            </div>
            
            <div class="mb-3">
                <label for="remark" class="form-label">Remark</label>
                <textarea name="remark" id="remark" class="form-control" ></textarea>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" id="roery" class="btn btn-success">add More</button>
            <button type="submit" class="btn btn-success">add Once</button>
        </form>
        </div>
      </div>
    </div>
  </div><!-- End Basic Modal-->

  <div class="modal fade" id="insertName">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Masukkan Nama </h5>
        </div>
        <div class="modal-body">
          <form id="addName"  autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
            <label for="nama" class="form-label">NRP||Nama||Jabatan||Sub-Section||Perusahaan</label>
            <select name="nama" id="nama" class="form-select" >
                <option value>Choose manpower</option>
                @foreach($manpowerData as $key)
                <option value="{{$key->nrp."||".$key->nama."||".$key->subSection}}">{{$key->nrp."||".$key->nama."||".$key->jabatanFn."||".$key->subSection."||".$key->perusahaanText}}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
              Nama masih kosong
            </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-success">Next</button>
          </form>
          </div>
        </div>
      </div>
  </div>

<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Please wait.....</h5>
        </div>
        <div class="modal-body">
          <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div><!-- End Center aligned spinner -->
          <div class="d-flex justify-content-center">
            Loading....
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
</div><!-- End Vertically centered Modal-->
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        dselect(document.querySelector('#nama'),{search: true,clearable:true});
        $(document).on('click','#saveAllMentorCoy',function(){
          if(mentor.selectedForm.length>0){
          $('#loadingModal').modal('show');
          mentor.selectedForm.forEach(async (data) => {
            try {
            let x=await saveAllMentor(data);
            if(x.success){
              location.replace('/mentor');
            }
              } catch (error) {
          }
          });
          }
 
         });
        $(document).on('click','#addBtn',function(){
            $('#insertName').modal('show');
        });

        $(document).on('submit','#addMentor',function(e){
            e.preventDefault();
            let formData=new FormData(this);
            validation.validating(formData,validator);
            if(!validation.status){
                validationList();
            }
            else{
              trueValidList();
              mentor.selectedForm.push(formData);
              showData(mentor.selectedForm, document.querySelector('#ojiTbl tbody'));
            $('#insertMentor').modal('hide');
              
            }
            
        })

        $(document).on('click','#roery',function(){
          let form=document.getElementById('addMentor');
          let formData=new FormData(form);
          validation.validating(formData,validator);
          if(!validation.status){
            validationList();
          }
          else{
              trueValidList();
              mentor.selectedForm.push(formData);
              showData(mentor.selectedForm, document.querySelector('#ojiTbl tbody'));
              clearForm();
              
          }
          
        })

        $(document).on('click','#deleteBtn',function(){
            let x=$(this).data('id');
            mentor.selectedForm.splice(x,1);
            showData(mentor.selectedForm, document.querySelector('#ojiTbl tbody'));
        })

        $(document).on('submit','#addName',async function(e){
          e.preventDefault();
          let formData=new FormData(this);
          let nama=formData.get('nama');
          let nrp=nama.split("||");
          validation.validating(formData,nameValidator);
          if(!validation.status){
            let x=validation.message;
            if(x.hasOwnProperty('nama')){
            let id=document.getElementById('nama');
              id.classList.add('is-invalid');
            }
          }
          else{
              hideSelect('materiToggle');
              showSelect('spinnerMateriToggle');
              document.getElementById('nama').classList.remove('is-invalid'); 
              try{
                updateListInstructorModal('instructor',mentor.allInstructor);
                let data= await mentor.byName(nrp[0],document.getElementById('jenis'));
                $('#insertName').modal('hide');
                document.getElementById('namaSelected').value=nama;
                document.getElementById('nameSelected').value=nama;
                hideSelect('spinnerMateriToggle');
                showSelect('materiToggle');
                updateListMentorModal('materi',data);
                $('#insertMentor').modal('show');
              }catch(err){}
              
          }
        
        
        })

        $(document).on('change','#jenis',async function(){
          hideSelect('materiToggle');
          showSelect('spinnerMateriToggle');
          try {
            let nama=document.getElementById('namaSelected').value;
            let nrp=nama.split("||");
            let data= await mentor.byName(nrp[0],document.getElementById('jenis'));
            hideSelect('spinnerMateriToggle');
            showSelect('materiToggle');
            updateListMentorModal('materi',data);
            
          } catch (error) {
            
          }
          
        })


     }) //end document ready function

    // Callback function---------------------------------------------------------------------------------------

    function saveAllMentor(dataForm){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

     return $.ajax({
        type: 'POST',
        url:'/iHateu',
        processData: false,
        contentType: false,
        data:dataForm,
      });
    }
    function clearForm(){
      document.getElementById('startDate').value="";    
      document.getElementById('endDate').value="";        
      document.getElementById('startTime').value="";   
      document.getElementById('endTime').value="";
      mentor.setTarget();
      updateListMentorModal('materi',mentor.dataTarget);
      updateListInstructorModal('instructor',mentor.allInstructor);
    }

    function validationList(){
            let x=validation.message;
            if(x.hasOwnProperty('materi')){
            let id=document.getElementById('materi');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('instructor')){
              let id=document.getElementById('instructor');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('startDate')){
              let id=document.getElementById('startDate');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('endDate')){
              let id=document.getElementById('endDate');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('startTime')){
              let id=document.getElementById('startTime');
              id.classList.add('is-invalid');
            }
            if(x.hasOwnProperty('endTime')){
              let id=document.getElementById('endTime');
              id.classList.add('is-invalid');
            }
    }

    function trueValidList(){
              document.getElementById('materi').classList.remove('is-invalid');          
              document.getElementById('instructor').classList.remove('is-invalid');        
              document.getElementById('startDate').classList.remove('is-invalid');    
              document.getElementById('endDate').classList.remove('is-invalid');        
              document.getElementById('startTime').classList.remove('is-invalid');    
              document.getElementById('endTime').classList.remove('is-invalid');
    }


    let validator=[
      {id:'materi', valid:'required',message:'Materi belum diisi',param:''},
      {id:'startDate',valid:'required',message:'Start Date belum diisi',param:''},
      {id:'endDate',valid:'required',message:'End Date belum diisi',param:''},
      {id:'startTime',valid:'required',message:'Start Time belum diisi',param:''},
      {id:'endTime',valid:'required',message:'End Date belum diisi',param:''},
      {id:'instructor',valid:'required',message:'End Date belum diisi',param:''}
     ];

     let nameValidator=[
      {id:'nama', valid:'required',message:'nama belum diisi',param:''}
     ]
    
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
    function hideSelect(id){
      let y=document.getElementById(id);
           y.style.display='none';
    }
    function showSelect(id){
      let y=document.getElementById(id);
            y.style.display='block';
    }

    function updateListMentorModal(idMateri,data){
            let y=document.getElementById(idMateri);
            y.innerHTML="";
            let ya=document.createElement('option');
            ya.value='';
            ya.innerHTML="Choose kompetensi";
            y.appendChild(ya);
            data.forEach(x => {
              let ya=document.createElement('option');
              ya.value=x.kode+"||"+x.judul;
              ya.innerHTML=x.kode+"||"+x.judul;
              y.appendChild(ya);              
            });
            dselect(y,{search: true,clearable:true});
    }

    function updateListInstructorModal(idMateri,data){
            let y=document.getElementById(idMateri);
            y.innerHTML="";
            let ya=document.createElement('option');
            ya.value='';
            ya.innerHTML="Choose instructor";
            y.appendChild(ya);
            data.forEach(x => {
              let ya=document.createElement('option');
              ya.value=x.id+"||"+x.namaInstructor;
              ya.innerHTML=x.namaInstructor;
              y.appendChild(ya);              
            });
            dselect(y,{search: true,clearable:true});
    }

    let mentor={
                byName:async function(nrp,selector){
                        this.allTarget=[];
                        this.focus={
                          nrp:nrp,
                          jenis:selector
                        }
                        try {
                          let data=await getData(nrp); //ubah data dengan format object data{kode : , judul:}
                          let x=data.data;
                          x.forEach(y => {
                            let z={
                              kode:y.kodeKompetensi,
                              judul:y.namaKompetensi,
                              jenis:y.jenisOji
                            }
                            this.allTarget.push(z);
                          });
                          this.setTarget();
                          return this.dataTarget;
                        } catch (error) {
                        }
                        },
                setTarget:function(){
                          this.dataTarget=[];
                         if (this.focus.jenis.value!='NON MANDATORY'){
                          this.allTarget.forEach(x => {

                            if(this.focus.jenis.value===x.jenis){
                              let index=0;

                              if(this.selectedForm.length>0){
                                this.selectedForm.forEach(y => {
                                  let n=y.get('nameSelected');
                                  n=n.split('||');

                                  let k=y.get('materi');
                                  k=k.split('||');
                                  if(n[0]===this.focus.nrp && k[0]===x.kode){
                                    index++;
                                  }
                                });
                              }
                              if(index===0){
                                this.dataTarget.push(x);
                              }
                            }
                          });
                          }
                          else{
                            let allCode=this.allCode;
                            allCode.forEach(x => {
                              let y={
                                kode:x.kode,
                                judul:x.namaKompetensi
                              }
                              this.dataTarget.push(y);                              
                            });
                          }
                        },
                selectedForm:[],
                dataTarget:[],
                allTarget:[],
                allCode:[],
                jenis:[],
                allInstructor:[],
                focus:{
                  nrp:"",
                  jenis:"",
                }
    }

    function getData(nrp){
      let targetOji;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      return $.ajax({
        type: 'POST',
        url:'/getMentorData',
        data: {nrp:nrp}
      })

    }

    function getKunam(){
      let targetOji;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: 'POST',
        url:'/iloveu',
        success:function(data){
          mentor.allCode=data.code;
          mentor.allInstructor=data.instructor;
          
        }
      })

    }

    function showData(data, handler){
        let x = handler;
        while (x.hasChildNodes()) {x.removeChild(x.firstChild);}
        data.forEach((a,index) => {
            let mp=a.get('nameSelected');
            mp=mp.split('||');

            let ins=a.get('instructor');
            ins=ins.split("||");

            let materi=a.get('materi');
            materi=materi.split("||");

            let b=x.insertRow(0);
           

            let nrp=b.insertCell(0);
            let nama=b.insertCell(1);
            let subSection=b.insertCell(2);
            let kode=b.insertCell(3);
            let judul=b.insertCell(4);
            let date=b.insertCell(5);
            let instructor=b.insertCell(6);
            let jenis=b.insertCell(7);
            let action=b.insertCell(8);

            nrp.innerHTML=mp[0];
            nama.innerHTML=mp[1];
            subSection.innerHTML=mp[2];
            kode.innerHTML=materi[0];
            judul.innerHTML=materi[1];
            date.innerHTML=a.get('startDate');
            instructor.innerHTML=ins[1];
            jenis.innerHTML=a.get('jenis');
            action.innerHTML=`<button id='deleteBtn' data-id='${index}' class='btn ri-delete-bin-5-fill'></button>`;
           
        });
    }
    getKunam();
    
</script>
    
@endpush