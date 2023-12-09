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
@endsection

@push('scripts')
<script>
  $(document).ready(async function(){
  let data={
    handler:'isiSoal',
    id:document.getElementById('idSoalUtama').value,
  }
  data=JSON.stringify(data);
  try {
    let x= await getData(data);
    soal.isi=x.soal;
    soal.jenis=x.jenis;
    soal.qty=x.qty;
    showSoal(soal);
  } catch (error) {
    console.log(error);
  }

  $(document).on('click','#del',function(){
    document.getElementById('isiSoalDelete').innerHTML=$(this).data('isi');
    $('#okDel').data('del',$(this).data('delete'));
    $('#deleteSoalModal').modal('show');
  })

  $(document).on('click','#okDel', async function(){
    data={
      handler:'deleteItem',
      delId:$(this).data('del'),
      id:document.getElementById('idSoalUtama').value
    }
    data=JSON.stringify(data);
    try {
      let x=await getData(data);
      soal.isi=x.soal;
      soal.jenis=x.jenis;
      soal.qty=x.qty;
      showSoal(soal);
      $('#deleteSoalModal').modal('hide');
    } catch (error) {
      console.log(error);
    }
  })



  $(document).on('click','#newSoalMc',async function(){
    try {
      let x= await getData(JSON.stringify({
        handler:'imgBlankPathSoal'
      }));
      modalSoalMc.imgPath=x.path;
      modalSoalMc.blankModal();
      $('#'+modalSoalMc.idModal).modal('show');
    } catch (error) {
      
    }
    
  });

  $(document).on('click','#tambahJawabanMc',function(){
    modalSoalMc.addChoice();
  })

  $(document).on('submit',`#${modalSoalMc.idForm}`, async function(e){
    e.preventDefault();
    submitSpinner();
    let formData=new FormData(this);
    data={
      handler:'submitSoalMc',
      data:modalSoalMc.getDataForm(formData),
      id:document.getElementById('idSoalUtama').value,
    }
    data=JSON.stringify(data);
    try {
      let x=await getData(data);
      if(x.status==='error'){
        submitSpinnerReset();
        modalSoalMc.errorModal(x.errors);
      }
      else{
        formData.append('idSoalIsi',x.idSoalIsi);
        let i=await sendImage(formData); //-----------------kirim soal dan dapatkan data terbaru
        soal.isi=i.soal;
        soal.jenis=i.jenis;
        soal.qty=i.qty;
        showSoal(soal);
        $('#'+modalSoalMc.idModal).modal('hide');
      }
    } catch (error) {
      console.log(error);
      
    }
  })

  $(document).on('click','#uploadBtn',function(){
    $('#file').click();
  })
  
  $(document).on('change','#file',function(){
    let fileData=document.getElementById('file');
    let [i]=fileData.files;
    modalSoalMc.changeImg((URL.createObjectURL(i)));
  })

  $(document).on('click','#deleteBtn',function(){
    document.getElementById(modalSoalMc.idImgRemove).value=1;
    let fileData=document.getElementById('file');
    fileData.value=null;
    modalSoalMc.changeImg(modalSoalMc.imgPath);
  })


  $(document).on('click','#editBtn', async function(){
    let x=$(this).data('edit');
    let a={
      handler:'getSoalSatuan',
      idSoalISi:x,
      idSoalUtama:document.getElementById('idSoalUtama').value
    }
    try {
      let data=await getData(JSON.stringify(a));
      modalSoalMc.setModeEdit(data.data);
      $('#'+modalSoalMc.idModal).modal('show');
    } catch (error) {
      console.log(error);
    }
  })



  $(document).on('click','#newSoalTfBtn',function(){
    let a=new ModalTf('modalTf');
    a.show();
  })

  $(document).on('click','#editTfBtn',async function(){
    let x=$(this).data('edit');
    let a={
      handler:'getSoalSatuan',
      idSoalISi:x,
      idSoalUtama:document.getElementById('idSoalUtama').value
    }
    try {
      let data=await getData(JSON.stringify(a));
      let handler={
        judulModal:'Edit True or False Question',
        soal:data.data.soal,
        choice:data.data.choice,
        jawaban:data.data.key,
        imgPath:(data.data.fileStatus)?data.data.filePath:undefined,
        newOrEdit:'edit',
        idSoalIsi:data.data.idSoalIsi,
        idSoalUtama:data.data.idSoalUtama
      }
      let b=new ModalTf('modalTf',handler);
      b.show();
    } catch (error) {
      console.log(error);
    }
  })

  $(document).on('click','#newMatchingBtn', function(){
    const a=new ModalMatchingUtama('modalMatching',{
      modalId:'laksdflaksd',
      event:'lasjkdvhlkasjvnliasu'
    });
    a.show();
  })

  $(document).on('submit','#soalMatchingFormA',function(e){
    e.preventDefault();
    soalMatchingSubmitA(this);
  })

  $(document).on('click','#editMatchingBtnA',function(){
    let i=$(this).data('edit');
    soalMatchingEditA(i,document.getElementById('idSoalUtama').value);
  })
  
  $(document).on('click','#delMatchingA',function(){
    modalMachingDelete($(this).data('delete'));
    
  })

  $(document).on('click','#okDelMatching', function(){
    deleteSoalMatching($(this).data('delete'));
  })

  $(document).on('submit','#soalMatchingFormB',function(e){
    e.preventDefault();
    soalMatchingSubmitB(this);
  })

  $(document).on('click','#editBtnMatchingB',function(){
    let i=$(this).data('edit');
    soalMatchingEditB(i,document.getElementById('idSoalUtama').value);
  })

  $(document).on('click','#delMatchingB',function(){
    modalMachingDelete($(this).data('delete'));
  })

  $(document).on('click','#generateEvtBtn',function(){
    let a=new ModalGenerate('modalGenerateEvent',{
      judulEvt:'',
      prePost:'post',
      soalUmum:false,
      releaseNilai:false,
      bahas:false,
      acakMc:false,
      acakTf:false,
      acakMatch:false,
      bobot:{
        balanced:false,
        Mc:25,
        Tf:35,
        Match:40,
      },
      batasiMc:100,
      batasiTf:100,
      batasiMatch:{
        enable:true,
        status:true,
      },
      qty:soal.qty,
    })
    a.show();
  })

  });

  //  end ready function ---------------------------------------------------------------------------------------------------

  const soal={
    isi:[],
    jenis:[],
    qty:[]
  }

  function ModalGenerate(anchor='body',handler={}){ 
    this.q=handler;
    // const handler={
    //   judulEvt:'',
    //   prePost:'post',
    //   soalUmum:false,
    //   releaseNilai:false,
    //   bahas:false,
    //   acakMc:false,
    //   acakTf:false,
    //   acakMatch:false,
    //   bobot:{
    //     balanced:true,
    //     Mc:25,
    //     Tf:35,
    //     Match:40,
    //   },
    //   batasiMc:100,
    //   batasiTf:100,
    //   batasiMatch:{
    //     enable:true,
    //     status:true,
    //   },
    //   qty:[2,2,2],
    // }

    this.anchor=anchor;
    this.prePost=function(){
      return prePost(this.q.prePost);
    }
    this.acak=function(){
      return acakSwitch(this.q.qty,this.q.acakMc,this.q.acakTf,this.q.acakMatch);
    }
    this.bobot=function(){
      return bobot(this.q.qty,this.q.bobot.balanced);
    }
    let modal=`<div class="modal fade" id="generateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" >Create Questions Event</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-floating mb-3">
          <input type="text" class="form-control">
          <label >${ this.q.judulevt }</label>
        </div>
        <div class="col-sm-6 mb-3">
          ${ this.prePost() }
        </div>

        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" ${ (this.q.soalUmum)?'checked':'' } >
          <label class="form-check-label" >Buka soal untuk umum (semua orang bisa mengerjakan)</label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch"  ${ (this.q.releaseNilai)?'checked':'' }>
          <label class="form-check-label" >Langsung release nilai (nilai muncul setelah di submit)</label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" ${ (this.q.bahas)?'checked':'' }> 
          <label class="form-check-label" >Bahas soal setelah submit (tunjukkan jawaban benar)</label>
        </div>

        <div class="row mt-3">
          <div class="col-sm-6">
           ${ this.acak() }
          <div class="col-sm-6">
            
          </div>

          <div class="mt-3">
            <hr/>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="" ${ (this.q.bobot.balanced)?'checked':''}>
              <label class="form-check-label" for="flexCheckChecked">
                Balanced
              </label>
            </div>

            ${ this.bobot() }
         
          </div>
          <div class="col-sm-12">
            <hr/>
          </div>
          <div class="col-sm-12 mt-3">
            <label  class="form-label">Batasi Jumlah Soal Multiple Choice : 2 dari 10</label>
            <input type="range" value='100' class="form-range" >
          </div>
          <div class="col-sm-12 mt-3">
            <label  class="form-label">Batasi Jumlah Soal True/false : 5 dari 10</label>
            <input type="range" value='100' class="form-range" >
          </div>
          <div class="col-sm-12 mt-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                  Matikan Soal Matching
                </label>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Create</button>
      </div>
    </div>
    </div>
    </div>`;

    this.show=()=>{
      document.getElementById(this.anchor).innerHTML=modal;
      $('#generateModal').modal('show');
    }
  }

  function prePost(q){
    return `<div class="form-check">
              <input class="form-check-input" type="radio" name="flexRadioDefault" ${ (q==='pre')?'checked':''}>
              <label class="form-check-label" >
                Pre Test
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="flexRadioDefault"  ${ (q==='post')?'checked':''}>
              <label class="form-check-label" >
                Post Test
              </label>
          </div>`;
  }

  function acakSwitch(z,q,w,e){
    let [a,b,c]=[z.qtyMc,z.qtyTf,z.qtyMatching];
    return ` <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" ${ (a === 0)? 'disabled':'' } ${ (q)? 'checked':'' } >
              <label class="form-check-label" >Acak Soal Multiple Choice</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" ${ (b === 0)? 'disabled':'' } ${ (w)? 'checked':'' }>
              <label class="form-check-label" >Acak Soal True/False</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" ${ (c === 0)? 'disabled':'' } ${ (e)? 'checked':'' }>
              <label class="form-check-label" >Acak Soal Matching</label>
            </div>
          </div>`;
  }

  function bobot(q,w){
    let [a,b,c]=[q.qtyMc,q.qtyTf,q.qtyMatching];
    let [d,e,f]=['disabled','disabled','disabled'];
    if(w){
      [d,e,f]=['disabled','disabled','disabled'];
    }else{
      [d,e,f]=[
        (a===0)?'disabled':'',
        (b===0)?'disabled':'',
        (c===0)?'disabled':'',
      ]
    }
    return `  <label  class="form-label">Bobot Soal Multiple Choice :25 %</label>
              <input id="bobotMc" data-drag='1' data-id='1' onInput="dragMc(this)" type="range" onInput="console.log(this.value)" class="form-range" value="25" ${d}>
           
          
              <label  class="form-label">Bobot Soal True/False :35 %</label>
              <input id="bobotTf" data-drag='2' data-id='2' onInput="dragTf(this)" type="range" class="form-range" value="35" ${e}>
          
            
              <label  class="form-label">Bobot Soal Matching :40 %</label>
              <input id="bobotMatch" data-drag='3' data-id=3 onInput="dragMatch(this)" type="range" class="form-range" value="40" ${f}>`;
  }

  function dragMc(q){
    let z=[q.qtyMc,q.qtyTf,q.qtyMatching];
    let w=[
      {
        id:'bobotMc',
        status:(z[0]===0)?false:true,
        num:1
      },
      {
        id:'bobotTf'
        status:(z[1]===0)?false:true,
        num:1
      },
      {
        id:'bobotMatch'
        status:(z[2]===0)?false:true,
        num:1
      }
    ];

      w[0].

    // $(q).attr('data-drag','1');
  }

  const modalSoalMc={
          judul:'',
          soal:'',
          imgPath:'',
          choice:[],
          trueAnswer:'',
          trueChoice:'',
          editOrNew:'new',
          anchor:'modalMc',
          idModal:'newModalMc',
          idForm:'newMc',
          idImgRemove:'imgRemove',
          idSoalUtama:document.getElementById('idSoalUtama').value,
          soalIsiId:'',
          qtyChoice:0,
          choiceRender:function(index,value,checked,idJawaban){
            let i='';
            if(checked){
              i='checked';
            }
            let x=`<div class="mb-3">
                      <label for="pilJaw${index}" class="form-label">Pilihan jawaban ${index+1}</label>
                      <textarea class="form-control" name="pilJaw${index}" rows="1">${value}</textarea>
                      <input type="hidden" name="idJawaban${index}" value="${idJawaban}">
                      <input class="form-check-input" type="radio" name="kunci" value="pilJaw${index}" ${i}>
                      <label class="form-check-label">Pilih Sebagai Jawaban Benar</label>
                      </div>`;
            return x;
          },
          setImg: function(path){
            imgShow=`<img src="${path}" class="rounded img-fluid" alt="...">`
            return imgShow;
          },
          setChoice:function(){
            let x='';
            let i=0;
            let checked=false;
            this.choice.forEach((element,index) => {
              if(this.trueAnswer!=''&& this.trueAnswer===element.value){
                checked=true;
              }
              x +=this.choiceRender(index,element.value,checked,element.id);
                i=index;
                checked=false;
            })
            this.qtyChoice=i;
            return x;
          },
          setModal:function(){
            let modal=`<div class="modal fade" id="${this.idModal}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5">${this.judul}</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="${this.idForm}" enctype="multipart/form-data">
                              <div class="modal-body">
                                <div id="errorMsg"></div>
                                <div class="mb-3">
                                  <label for="soal" class="form-label">Tulis Soal</label>
                                  <textarea class="form-control"name="soal" rows="3">${this.soal}</textarea>
                                </div>
                                <div class="mb-1">
                                  <label class="form-label">Gambar</label>
                                </div>
                                <div id="imgMc">${this.setImg(this.imgPath)}</div>
                                <div class="pt-2 mb-3">
                                  <button type="button" id="uploadBtn" class="btn btn-primary btn-sm" title="Upload Image"><i class="bi bi-upload"></i></button>
                                  <button type="button" id="deleteBtn" class="btn btn-danger btn-sm" title="Remove Image"><i class="bi bi-trash"></i></button>
                                  <input accept="image/jpg"  name="file" id="file" type="file" hidden>
                                </div>
                                <div id="choice">${this.setChoice()}</div>
                                <button type="button" id="tambahJawabanMc" class="btn btn-primary btn-sm">Tambah Pilihan</button>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ga Jadi</button>
                                <div id="submitSpinner">
                                  <button  type="submit" data-del='' class="btn btn-danger">Simpan</button>
                                </div>
                              </div>
                              <input type="hidden" name="idSoalIsi" value="${this.soalIsiId}">
                              <input type="hidden" name="idSoalUtama" value="${this.idSoalUtama}">
                              <input type="hidden" name="newOrEdit" value="${this.editOrNew}">
                              <input id="${this.idImgRemove}" type="hidden" name="imgRemove" value=0>
                            </form>
                          </div>
                        </div>
                      </div>`;

                return modal;
          },
          blankModal:function(){
            this.choice=[
              {
                id:'new',value:''
              },
              {
                id:'new',value:'',
              }
            ];
            this.qtyChoice=0;
            this.editOrNew='new',
            this.soal='',
            this.soalIsiId='',
            this.judul='New Multiple Choice Question';
            document.getElementById(this.anchor).innerHTML=this.setModal();
            document.getElementById('errorMsg').innerHTML='';
          },
          addChoice:function(){
            this.qtyChoice+=1;
            let x=this.choiceRender(this.qtyChoice,'',false,'new');
            document.getElementById('choice').insertAdjacentHTML('beforeend',x);
          },
          getDataForm:function(formData){
            let i=[];
            for (let index = 0; index <= this.qtyChoice; index++) {
              i.push({
                id:formData.get(`idJawaban${index}`),
                value:formData.get(`pilJaw${index}`)
              });
            }
            const x={
              isi:formData.get('soal'),
              pilihanJawaban:i,
              jawabanBenar:formData.get(formData.get('kunci')),
              idSoalUtama:formData.get('idSoalUtama'),
              idSoalIsi:formData.get('idSoalIsi'),
              editOrNew:formData.get('newOrEdit'),
              jenis:1
            }
            return x;
          },
          errorModal:function(error){
            message='';
            error.forEach(element => {
              message+=`<div class="alert alert-danger" role="alert">${element.message}</div>`
            });
            document.getElementById('errorMsg').innerHTML=message;
          },
          changeImg:function(x){
            document.getElementById('imgMc').innerHTML=this.setImg(x);
          },
          setModeEdit:function(data){
            this.qtyChoice=0;
            this.soal=data.soal;
            this.choice=data.choice;
            this.judul='Edit Multiple Choice Question';
            this.editOrNew='edit';
            this.trueAnswer=data.key;
            this.idSoalUtama=data.idSoalUtama;
            this.soalIsiId=data.idSoalIsi;
            document.getElementById(this.anchor).innerHTML=this.setModal();
            if(data.fileStatus){
              modalSoalMc.changeImg(data.filePath);
            }
          }
  }
  function ModalTf(anchor='body',handler={}){
    this.id={
    modalId:'xzcvzxcvn',
    formId:'qwerqertwe',
    fileId:'lafskbpodrnvsd',
    imgId:'obninobd',
    deleteImgId:'mkomok',
    errorMsgId:'ldfkjhsdoprjnglsdkf'
    }
    this.judulModal=(typeof handler.judulModal!='undefined')? handler.judulModal :'New True or False Question';
    this.soal=(typeof handler.soal!='undefined')? handler.soal:'';
    this.choice=(typeof handler.choice!='undefined')?handler.choice:[{id:'new',value:'TRUE'},{id:'new',value:'FALSE'}];
    this.jawaban=(typeof handler.jawaban!='undefined')? handler.jawaban:'';
    this.imgPath=(typeof handler.imgPath!='undefined')? handler.imgPath:document.getElementById('blankImgPath').value;
    this.imgStatus=(typeof handler.imgStatus!='undefined')? handler.imgStatus:0;
    this.newOrEdit=(typeof handler.newOrEdit!='undefined')? handler.newOrEdit:'new';
    this.idSoalIsi=(typeof handler.idSoalIsi!='undefined')? handler.idSoalIsi:'';
    this.idSoalUtama=(typeof handler.idSoalUtama!='undefined')? handler.idSoalUtama:document.getElementById('idSoalUtama').value;
    this.a=function(){
      let t='';
      let f='';
      let tId='';
      let fId='';

      if(this.jawaban !=''){
        (this.jawaban==='TRUE')?t='checked':f='checked';
      }
      this.choice.forEach(element => {
        (element.value==='TRUE')?tId=element.id:'';
        (element.value==='FALSE')?fId=element.id:'';
      });
      let aa=`<div class="modal fade" id="${this.id.modalId}"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                          <div id="" class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5">${this.judulModal}</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="${this.id.formId}" onSubmit="let a=new ModalTf(); a.submit(this); return false;" enctype="multipart/form-data">
                              <div class="modal-body">
                                <div id="${ this.id.errorMsgId }"></div>
                                <div class="mb-3">
                                  <label for="soal" class="form-label">Tulis Soal</label>
                                  <textarea class="form-control" name="soal" rows="3">${this.soal}</textarea>
                                </div>
                                <div class="mb-1">
                                  <label class="form-label">Gambar</label>
                                </div>
                                <img id="${this.id.imgId}" src="${this.imgPath}" class="rounded img-fluid" alt="...">
                                <div class="pt-2 mb-3">
                                  <button type="button" onClick="$('#${this.id.fileId}').click()" class="btn btn-primary btn-sm" title="Upload Image"><i class="bi bi-upload"></i></button>
                                  <button type="button" onClick="const a=new ModalTf; a.deleteImg()" class="btn btn-danger btn-sm" title="Remove Image"><i class="bi bi-trash"></i></button>
                                  <input accept="image/jpg" onChange="const a=new ModalTf; a.imageChange();"  name="file" id="${this.id.fileId}" type="file" hidden>
                                </div>
                                <div class="mb-3">
                                  <div class="form-check">
                                    <input class="form-check-input" id="trueId" type="radio" name="trueAnswer" value='TRUE' ${t}>
                                    <label class="form-check-label" for="flexRadioDefault1">TRUE</label>
                                    <input type="hidden" name='trueId' value="${ tId }">
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" id="falseId" type="radio" name="trueAnswer" value='FALSE' ${f}>
                                      <label class="form-check-label" for="flexRadioDefault2">FALSE</label>
                                      <input type="hidden" name="falseId" value="${ fId }">
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ga Jadi</button>
                                <div id="submitSpinner">
                                  <button  type="submit" class="btn btn-danger">Simpan</button>
                                </div>
                              </div>
                              <input type="hidden" name="idSoalUtama" value="${ this.idSoalUtama }">
                              <input type="hidden" name="idSoalIsi" value="${ this.idSoalIsi }">
                              <input type="hidden" name="newOrEdit" value="${ this.newOrEdit }">
                              <input id="${this.id.deleteImgId}" type="hidden" name="imgRemove" value="${ this.imgStatus }">
                            </form>
                          </div>
                        </div>
                        </div>`;
                        return aa;
                      }
    
    this.render=function(){
      document.getElementById(anchor).innerHTML=this.a();
    }
    this.show=function(){
      this.render();
      $(`#${this.id.modalId}`).modal('show');
    }
    this.imageChange=function(){
    let fileData=document.getElementById(this.id.fileId);
    let [i]=fileData.files;
    document.getElementById(this.id.imgId).src=(URL.createObjectURL(i));
    }
    this.deleteImg=function(){
    document.getElementById(this.id.imgId).src=this.imgPath;
    document.getElementById(this.id.fileId).value=null;
    document.getElementById(this.id.deleteImgId).value='1';
    }
    this.errorMsg=function(error){
      let message='';
      error.forEach(element => {
        message+=`<div class="alert alert-danger" role="alert">${element.message}</div>`
      });
      document.getElementById(this.id.errorMsgId).innerHTML=message;
    }
    this.submit= async function(data){
      submitSpinner();
      let formData =new FormData(data);
      let d={
        handler:'submitSoalTf',
        data:{
          isi:formData.get('soal'),
          pilihanJawaban:[
            {
              id:formData.get('trueId'),
              value:'TRUE'
            },
            {
              id:formData.get('falseId'),
              value:'FALSE'
            }
          ],
          jawabanBenar:formData.get('trueAnswer'),
          idSoalUtama:formData.get('idSoalUtama'),
          idSoalIsi:formData.get('idSoalIsi'),
          editOrNew:formData.get('newOrEdit'),
          jenis:2
        },
        id:formData.get('idSoalUtama'),
      }
      d=JSON.stringify(d);
      try {
        let x =await getData(d);
        if(x.status!='success'){
          submitSpinnerReset();
          this.errorMsg(x.errors);
        }
        else{
          formData.append('idSoalIsi',x.idSoalIsi);
          let c=await sendImage(formData);
          soal.isi=c.soal;
          soal.jenis=c.jenis;
          soal.qty=c.qty;
          showSoal(soal);
          $(`#${this.id.modalId}`).modal('hide');
        }
      } catch (error) {
        
      }
      
    }
  }

  function ModalMatchingUtama(anchor='',handler={}){
    this.id={
      modal:handler.modalId,
      event:handler.event
    }
    let a=`<div class="modal fade" id="${this.id.modal}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Info</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <h5>Pilih tipe Soal:</h5>
              <div class="row">
                <div class="col-lg-6">
                  <button type="button" onClick="${this.id.event}(1)" class="btn btn-info">Tipe 1</button>
                  </div>
                  <div class="col-lg-6">
                    <button type="button" onClick="${this.id.event}(2)" class="btn btn-info">Tipe 2</button>
                    </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-danger" data-bs-dismiss="modal">Lupakan</button>
                      </div>
                      </div>
                      </div>
                      </div>`;
      document.getElementById(anchor).innerHTML=a;
      this.show=function(){
        $(`#${this.id.modal}`).modal('show');
      }
  }

  function ModalMatchingA(anchor='',handler={soal:{}}){
    this.soalMain=(typeof handler.soal.soalMain!='undefined')? handler.soal.soalMain:'';
    this.soal=(typeof handler.soal.soal!='undefined')? handler.soal.soal:[{id:'new', soal:'',kunci:''}];
    this.choice=(typeof handler.soal.choice!='undefined')? handler.soal.choice:[{id:'new', choice:''}];
    this.fileStatus=(typeof handler.soal.fileStatus!='undefined')? handler.soal.fileStatus:false;
    this.filePath=(typeof handler.soal.filePath!='undefined')? handler.soal.filePath:'';
    this.jenis=(typeof handler.soal.jenis!='undefined')? handler.soal.jenis:3;
    this.idSoalIsi=(typeof handler.soal.idSoalIsi!='undefined')? handler.soal.idSoalIsi:'new';
    this.idSoalUtama=(typeof handler.soal.idSoalUtama!='undefined')? handler.soal.idSoalIsi:document.getElementById('idSoalUtama').value;
    this.modalStatus=(typeof handler.modalStatus !='undefined')? handler.modalStatus :'new';
    this.soalCounter=0;
    this.choiceCounter=0;


    this.rakitChoice=function(data){
      let a='';
      data.forEach((s,i)=>{
        let j=String.fromCharCode(i+1+64)
        a+=choiceModalMatchingA(s.id,i,j,s.choice);
        this.choiceCounter++;
      });
      return a;
    }

    this.rakitSoal=function(data){
      let cc=[];
      this.choice.forEach((s,i)=>{
        let j=String.fromCharCode(i+1+64)
        cc.push({
            abj:j,
            choice:s.choice
          });
      });
      let a='';
      data.forEach((s,i) => {
        let xx='';
        cc.forEach((x)=>{
          if(x.choice===s.kunci && s.id !='new'){
            xx=soalModalMatchingA(s.id,i+1,s.soal,x.abj);
          }
        })
        if(xx !=''){
          a+=xx;
        }else{
          a+=soalModalMatchingA(s.id,i+1,s.soal,'');
        }
        this.soalCounter++;
      });
      return a;
    }

    
    this.a=`<div class="modal fade" id="soalMatchingModalA" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Soal Matching Tipe 1</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="soalMatchingFormA" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="col-sm-12 mb-3">
              <textarea name="soalMainMatchingA" class="form-control" placeholder="Isi perintah dari soal contoh: Isilah jawaban sesuai dari huruf pilihan soal" >${ this.soalMain }</textarea>
              </div>
              <div class="row">
                <div class="col-sm-6 mb-5">
                  <div id="soalMatchingA" class='row'>
                    ${ this.rakitSoal(this.soal) }
                  </div>
                  <div class="mt-3">
                  <button type="button" onClick="addSoalCompnentMatchingA()" class="btn btn-primary btn-sm">Tambah Soal</button>
                  </div>
                </div>
                <div class="col-sm-6 mb-3">
                  <div id="choiceMatchingA">
                    ${ this.rakitChoice(this.choice) }
                  </div>
                  <div class="mt-3">
                  <button type="button" onClick="addChoiceCompnentMatchingA()" class="btn btn-primary btn-sm">Tambah Jawaban</button>
                  </div>
                </div>
              </div>
              <div id="alertMatchingA">
              </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="soalCounter" id="soalCounter" value="${this.soalCounter}">
                <input type="hidden" name="choiceCounter" id="choiceCounter" value="${this.choiceCounter}">
                <input type="hidden" name="newOrEdit" value="${this.modalStatus}">
                <input type="hidden" name="idSoalIsi" value="${ this.idSoalIsi }">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <div id="submitSpinner">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </div>
              </form>
                </div>
                </div>
                </div>`;
    this.show=function(){
      document.getElementById(anchor).innerHTML=this.a;
      $('#soalMatchingModalA').modal('show');
    }

  }

  function soalModalMatchingA(id,num,soal,kunci){
    return`<div class='col-sm-8'>
                      <div class="input-group">
                        <span class="input-group-text" >${num}</span>
                        <textarea class="form-control" placeholder="soal" name="soalA${num-1}" aria-label="Username" aria-describedby="basic-addon1">${soal}</textarea>
                      </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                      <input type="text" class="form-control" name="kunciA${num-1}" placeholder="kunci" value="${kunci}">
                      <input type="hidden" class="form-control" name="soalIdA${num-1}" placeholder="kunci" value="${id}">
                    </div>`;    
  }

  function choiceModalMatchingA(id,num,abj,choice){
    return `<div class="input-group mb-3">
                      <span class="input-group-text" >${abj}</span>
                      <input type="text" class="form-control" name="choiceA${num}" placeholder="Pilihan Jawaban" value='${choice}' aria-label="Username" aria-describedby="basic-addon1">
                      <input type="hidden" name="choiceAbjA${num}" value="${abj}">
                      <input type="hidden" name="choiceIdA${num}" value="${id}">
                      </div>`;
  }

  function addSoalCompnentMatchingA(){
    let cntr=document.getElementById('soalCounter')
    let c=document.getElementById('soalMatchingA')
    let b=parseInt(cntr.value)+1
    cntr.value=b
    let a=soalModalMatchingA('new',b,'','');
    c.insertAdjacentHTML('beforeend',a)
  }

  function addChoiceCompnentMatchingA(){
    let cntr=document.getElementById('choiceCounter')
    let c=document.getElementById('choiceMatchingA')
    let b=parseInt(cntr.value)+1
    let j=String.fromCharCode(b+64)
    cntr.value=b
    let a=choiceModalMatchingA('new',b-1,j,'');
    c.insertAdjacentHTML('beforeend',a)
  }

  function soalMatchingSubmitA(evt){
    submitSpinner();
    let formData=new FormData(evt);
    let a=parseInt(formData.get('soalCounter'));
    let b=parseInt(formData.get('choiceCounter'));
    let soal=[];
    let choice=[];

    for (let i = 0; i < a; i++) {
      soal.push({
        id:formData.get('soalIdA'+i),
        soal:formData.get('soalA'+i),
        kunci:formData.get('kunciA'+i)
      });
    }

    for (let i = 0; i < b; i++) {
      choice.push({
        id:formData.get('choiceIdA'+i),
        choice:formData.get('choiceA'+i),
        choiceAbj:formData.get('choiceAbjA'+i)
      });
      
    }

    let data={
                handler:'submitSoalMatchingA',
                modalStatus:formData.get('newOrEdit'),
                data:{
                        soalMain:formData.get('soalMainMatchingA'),
                        fileStatus:false,
                        filePath:'',
                        jenis:3,
                        idSoalIsi:formData.get('idSoalIsi'),
                        idSoalUtama:document.getElementById('idSoalUtama').value,
                        soal:soal,
                        choice:choice,
                }
              }
    

    data=JSON.stringify(data);
    
    async function send(x){
      try {
        let o=await getData(x);
        if(o.status==='error'){
          submitSpinnerReset();
          errorSubmit(o.errors);
        }else{
          soal.isi=o.soal;
          soal.jenis=o.jenis;
          soal.qty=o.qty;
          showSoal(soal);
          $('#soalMatchingModalA').modal('hide');
        }
      } catch (error) {
        console.log(error);
      }
    }

    function errorSubmit(x){
      let i='';
      x.forEach(xe => {
        i+=`<div class="alert alert-danger" role="alert">
                 ${xe}
            </div>`
      });

      document.getElementById('alertMatchingA').innerHTML=i;
    }

    send(data);

  }

  function soalMatchingEditA(x,y){
    async function getSoal(idSoalIsi, idSoalUtama){
      let data={
        handler:'getSoalMatchingSatuanA',
        idSoalIsi:idSoalIsi,
        idSoalUtama:idSoalUtama
      }
      data=JSON.stringify(data);
      let a=await getData(data);
      let x={
        soal:a.data,
        modalStatus:'edit'
      }
      let i=new ModalMatchingA('modalMatching',x);
      i.show();
    }

    getSoal(x,y);
  }

  function deleteSoalMatching(id){
    let data={
      handler:'deleteSoalMatching',
      idSoalIsi: id,
      idSoalUtama:document.getElementById('idSoalUtama').value,
    }
    data=JSON.stringify(data);

    async function oo(a){
      try {
        let i=await getData(a)
        console.log(i);
        soal.isi=i.soal;
        soal.jenis=i.jenis;
        soal.qty=i.qty;
        showSoal(soal);
        $('#deleteModalMatching').modal('hide');
      } catch (error) {
       console.log(error); 
      }
    }
    oo(data);
  }

  function modalMachingDelete(idSoalIsi){
    let a=`<div class="modal fade" id="deleteModalMatching" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Warning</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
        <h5>Apakah anda yakin ingin menghapus soal ini ?</h5>
        <p id="isiSoalDelete"></p>
        </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ga Jadi</button>
        <button id="okDelMatching" type="button" data-delete='${idSoalIsi}' class="btn btn-danger">Yo..ii guys</button>
          </div>
        </div>
        </div>
      </div>`;
      document.getElementById('modalDelete').innerHTML=a;

      $('#deleteModalMatching').modal('show');
  }


  function ModalMatchingB(anchor='',handler={}){
    this.soalMain=(typeof handler.soal.soalMain!='undefined')? handler.soal.soalMain:'';
    this.soal=(typeof handler.soal.soal!='undefined')? handler.soal.soal:[{id:'new', soal:'',kunci:''}];
    this.fileStatus=(typeof handler.soal.fileStatus!='undefined')? handler.soal.fileStatus:false;
    this.filePath=(typeof handler.soal.filePath!='undefined')? handler.soal.filePath:document.getElementById('blankImgMatchingPathB').value;
    this.jenis=(typeof handler.soal.jenis!='undefined')? handler.soal.jenis:3;
    this.idSoalIsi=(typeof handler.soal.idSoalIsi!='undefined')? handler.soal.idSoalIsi:'new';
    this.idSoalUtama=(typeof handler.soal.idSoalUtama!='undefined')? handler.soal.idSoalIsi:document.getElementById('idSoalUtama').value;
    this.modalStatus=(typeof handler.modalStatus !='undefined')? handler.modalStatus :'new';
    this.soalCounter=0;

    this.rakitSoalB=function(){
      let a='';
      this.soal.forEach((se,si) => {
        this.soalCounter++;
        a+=soalModalMatchingB(se.id,si+1,se.soal,se.kunci);
      });

      return a;
    }

    this.a=`<div class="modal fade" id="soalMatchingModalB" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Soal Matching Tipe 2</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="soalMatchingFormB" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="col-sm-12 mb-3">
              <textarea name="soalMainMatchingA" class="form-control" placeholder="Isi perintah dari soal contoh: Isilah jawaban sesuai dari huruf pilihan soal" >${ this.soalMain }</textarea>
              </div>
              <div class="row">
                <div class="col-sm-6 mb-5">
                  <div id="soalMatchingB" class='row'>
                    ${ this.rakitSoalB() }
                  </div>
                  <div class="mt-3">
                  <button type="button" onClick="addSoalCompnentMatchingB()" class="btn btn-primary btn-sm">Tambah Soal</button>
                  </div>
                </div>
                <div class="col-sm-6 mb-3">
                  <div id="choiceMatchingA">
                    <img id="imgMatchingTumbnailB" src="${ this.filePath }" class="rounded img-fluid" alt="...">
                    <div class="pt-2 mb-3">
                      <button type="button" onClick="uploadImgMatchingB()" class="btn btn-primary btn-sm" title="Upload Image"><i class="bi bi-upload"></i></button>
                      <button type="button" onClick="imageMatchingDeleteB()"  class="btn btn-danger btn-sm" title="Remove Image"><i class="bi bi-trash"></i></button>
                      <input accept="image/jpg" id="imageMatchingB" onChange="imageMatchingChangeB()"  name="file"  type="file" hidden>
                    </div>
                  </div>
                </div>
              </div>
              <div id="alertMatchingB">
              </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="soalCounterB" id="soalCounterB" value="${ this.soalCounter }">
                <input type="hidden" name="newOrEditB" value="${ this.modalStatus }">
                <input type="hidden" name="idSoalIsiB" value="${ this.idSoalIsi }">
                <input type="hidden" id="imageDeleteMatchingStatusB" name="imgDelStatus" value="0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <div id="submitSpinner">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
                </div>
                </div>
                </div>`;
      this.show=function(){
        document.getElementById(anchor).innerHTML=this.a;
        $('#soalMatchingModalB').modal('show');
      }
  }

  function soalModalMatchingB(id,num,soal,kunci){
    return`<div class='col-sm-8'>
                      <div class="input-group">
                        <span class="input-group-text" >${num}</span>
                        <textarea class="form-control" placeholder="soal" name="soalB${num-1}" aria-label="Username" aria-describedby="basic-addon1">${soal}</textarea>
                      </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                      <input type="text" class="form-control" name="kunciB${num-1}" placeholder="kunci" value="${kunci}">
                      <input type="hidden" class="form-control" name="soalIdB${num-1}" placeholder="kunci" value="${id}">
                    </div>`;    
  }

  function addSoalCompnentMatchingB(){
    let cntr=document.getElementById('soalCounterB')
    let c=document.getElementById('soalMatchingB')
    let b=parseInt(cntr.value)+1
    cntr.value=b
    let a=soalModalMatchingB('new',b,'','');
    c.insertAdjacentHTML('beforeend',a)
  }
  function uploadImgMatchingB(){
    $('#imageMatchingB').click();
  }

  function imageMatchingChangeB(){
    let fileData=document.getElementById('imageMatchingB');
    let [i]=fileData.files;
    document.getElementById('imgMatchingTumbnailB').src=URL.createObjectURL(i);
  }

  function imageMatchingDeleteB(){
    let fileData=document.getElementById('imageMatchingB');
    let d=document.getElementById('blankImgMatchingPathB');
    let i=document.getElementById('imageDeleteMatchingStatusB');
    fileData.value=null;
    document.getElementById('imgMatchingTumbnailB').src=d.value;
    i.value='1';
  }

  function soalMatchingSubmitB(evt){
    submitSpinner();
    let formData=new FormData(evt);
    let a=parseInt(formData.get('soalCounterB'));
    let i=[];

    for (let x = 0; x < a; x++) {
      i.push({
        id:formData.get('soalIdB'+x),
        soal:formData.get('soalB'+x),
        kunci:formData.get('kunciB'+x)
      });
    }

    let data={
        handler:'submitSoalMatchingB',
        soal:{
          soal:i,
          soalMain:formData.get('soalMainMatchingA'),
          fileStatus:(document.getElementById('imageMatchingB').value===null || document.getElementById('imageMatchingB').value==='')? false : true,
          filePath:'',
          jenis:3,
          imgDelStatus:parseInt(formData.get('imgDelStatus')),
          idSoalIsi:formData.get('idSoalIsiB'),
          idSoalUtama:document.getElementById('idSoalUtama').value,
        },
        modalStatus:formData.get('newOrEditB'),
      }
      data=JSON.stringify(data);
      
      async function send(y){
        try {
          let h=await getData(y)
          if(h.status==='error'){
            submitSpinnerReset();
            errorSubmit(h.errors);
          }else{
            formData.append('idSoalIsi',h.idSoalIsi);
            formData.append('idSoalUtama',document.getElementById('idSoalUtama').value);
            let c=await sendImage(formData);
            soal.isi=c.soal;
            soal.jenis=c.jenis;
            soal.qty=c.qty;
            showSoal(soal);
            $('#soalMatchingModalB').modal('hide');
          }
        } catch (error) {
          console.log(error);
        }
      }

      function errorSubmit(x){
        let i='';
        x.forEach(xe => {
          i+=`<div class="alert alert-danger" role="alert">
            ${xe}
            </div>`
          });
          
          document.getElementById('alertMatchingB').innerHTML=i;
        }

      send(data);
  };

  function soalMatchingEditB(x,y){
    async function getSoal(idSoalIsi, idSoalUtama){
      let data={
        handler:'getSoalMatchingSatuanB',
        idSoalIsi:idSoalIsi,
        idSoalUtama:idSoalUtama
      }
      data=JSON.stringify(data);
      let a=await getData(data);
      console.log(a.data);
      let i=new ModalMatchingB('modalMatching',a.data);
      i.show();
    }

    getSoal(x,y);
  }

  function lasjkdvhlkasjvnliasu(i,j){
    $('#laksdflaksd').modal('hide');
    if(i===1){
      let a=new ModalMatchingA('modalMatching',{
        soal:{
          choice:[
            {id:'new', choice:''},
            {id:'new', choice:''}
          ],
          soal:[
            {id:'new', soal:'',kunci:''},
            {id:'new', soal:'',kunci:''}
          ],
          soalMain:'',
          fileStatus:false,
          filePath:'',
          jenis:3,
          idSoalIsi:'',
          idSoalUtama:document.getElementById('idSoalUtama').value,
        },
        modalStatus:'new'
      });
      a.show();
    }else{
      let a=new ModalMatchingB('modalMatching',{
        soal:{
          soal:[
            {id:'new', soal:'',kunci:''},
            {id:'new', soal:'',kunci:''}
          ],
          soalMain:'',
          fileStatus:false,
          filePath:document.getElementById('blankImgMatchingPathB').value,
          jenis:3,
          idSoalIsi:'',
          idSoalUtama:document.getElementById('idSoalUtama').value,
        },
        modalStatus:'new'
      });
      a.show();
    }
  }
 
  function submitSpinner(){
    let y=`<button class="btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Loading...</span>
                    </button>
                    </div>`;

    document.getElementById('submitSpinner').innerHTML=y;
  }
  function submitSpinnerReset(){
    let y=`<button type="submit" class="btn btn-primary">Simpan</button>`;
    document.getElementById('submitSpinner').innerHTML=y;
  }

  function showSoal(x){
    document.getElementById('mcQty').innerHTML=x.qty.qtyMc;
    document.getElementById('tfQty').innerHTML=x.qty.qtyTf;
    if(x.qty.qtyMatching !=0){
      let f=0;
      x.qty.qtySubMatching.forEach(ee => {
        f+=ee;
      });
      document.getElementById('matcQty').innerHTML=`${x.qty.qtyMatching} (${f})`;
    }else{
      document.getElementById('matcQty').innerHTML=x.qty.qtyMatching;
    }
    if(x.jenis.indexOf(1)>-1){
      showSoalMc(x);
    }else{
      document.getElementById('wasem').innerHTML='';
    }
    if(x.jenis.indexOf(2)>-1){
      showSoalTf(x);
    }else{
      document.getElementById('enak').innerHTML='';
    }
    if(x.jenis.indexOf(3)>-1){
      showSoalMatching(x);
    }else{
      document.getElementById('crotz').innerHTML='';
    }
  }


  function showSoalTf(x){
    let isi='';
      let soal='';
      let choice='';
      let head="<ol class='list-group list-group-numbered mt-3'>";
      let foot="</ol>";

      x.isi.forEach(element => {
        if(element.jenis===2){
          choice='';
          let img='';
          element.choice.forEach(cc => {
            let x='';
            if(cc.value===element.key){
              x='right-answer';
            }
            choice+=`<div class="form-check"><input class="form-check-input" type="radio" name="gridRadios" value="option1" disabled>
              <label class="form-label ${x}" for="gridRadios1">${cc.value}</label></div>`
            });
            if(element.fileStatus){
              img=`<div class="row"><div class="col-lg-12"><div class="ms-3"><img src="${element.filePath}"class="img-fluid" alt="..."></div></div>
              </div>`;
            }
            else{
              img='';
            }
            let cover=`<div class="col-sm-10 mt-3">${img}${choice}</div>`
            isi+=`<li class="list-group-item">${element.soal}${cover} <div class="position-relative mt-5"><div class="position-absolute bottom-0 start-0"><p class="px-4"><strong>Success : 80%</strong></p></div><div class="position-absolute bottom-0 end-0">
              <button id ="del" type="button" data-delete="${element.idSoalIsi}" data-isi='${element.soal}' class="btn btn-danger" title="delete"><i class="bi bi-trash"></i></button>
              <button id="editTfBtn" data-edit="${element.idSoalIsi}" type="button" class="btn btn-success" title="edit"><i class="bi bi-wrench"></i></button></div></div></li>`;
            }
      });
      
      let rakitan=head+isi+foot;
      document.getElementById('enak').innerHTML=rakitan;
  }

  function showSoalMc(x){
    let isi='';
    let soal='';
    let choice='';
    let head="<ol class='list-group list-group-numbered mt-3'>";
      let foot="</ol>";
      
      x.isi.forEach(element => {
          if(element.jenis===1){
            choice='';
            let img='';
            element.choice.forEach(cc => {
              let x='';
              if(cc.value===element.key){
                x='right-answer';
              }
              choice+=`<div class="form-check"><input class="form-check-input" type="radio" name="gridRadios" value="option1" disabled><label class="form-label ${x}" for="gridRadios1">${cc.value}</label></div>`
            });
            if(element.fileStatus){
              img=`<div class="row"><div class="col-lg-12"><div class="ms-3"><img src="${element.filePath}"class="img-fluid" alt="..."></div></div>
              </div>`;
            }
            else{
              img='';
            }
            let cover=`<div class="col-sm-10 mt-3">${img}${choice}</div>`
            isi+=`<li class="list-group-item">${element.soal}${cover} <div class="position-relative mt-5"><div class="position-absolute bottom-0 start-0"><p class="px-4"><strong>Success : 80%</strong></p></div><div class="position-absolute bottom-0 end-0">
              <button id ="del" type="button" data-delete="${element.idSoalIsi}" data-isi='${element.soal}' class="btn btn-danger" title="delete"><i class="bi bi-trash"></i></button>
              <button id="editBtn" data-edit="${element.idSoalIsi}" type="button" class="btn btn-success" title="edit"><i class="bi bi-wrench"></i></button></div></div></li>`;
            }
          });
          let rakitan=head+isi+foot;
          document.getElementById('wasem').innerHTML=rakitan;
  }

  function showSoalMatching(x){
    console.log(x);
    let [head,foot,matchingA,matchingB]=[
      `<ol class="list-group list-group-numbered">`,
      `</ol>`,'',''
    ];
    x.isi.forEach(element => {
      if(element.jenis===3){
        if(element.fileStatus){
          matchingB+=asyMatchingB(element);
        }else{
          matchingA+=asyMatchingA(element);
        }
      }
    });

    document.getElementById('crotz').innerHTML=head+matchingA+matchingB+foot;

    function asyMatchingA(m){
      let [a,b]=[
        `<li class="list-group-item">
            <strong>${m.soalMain}</strong>
            <div class="row mt-3">`,

        `</div>
            <div class="position-relative mt-5">
              <div class="position-absolute bottom-0 start-0">
                <p class="px-4"><strong>Success : 80%</strong></p>
              </div>
              <div class="position-absolute bottom-0 end-0">
                <button id ="delMatchingA" type="button" data-delete="${m.idSoalIsi}" data-isi='Soal Matching' class="btn btn-danger" title="delete"><i class="bi bi-trash"></i></button>
                <button id="editMatchingBtnA" data-edit="${ m.idSoalIsi }" type="button" class="btn btn-success" title="edit"><i class="bi bi-wrench"></i>
                </button>
              </div>
            </div>
          </li>`
        ];

        return a+writeSoalA(m)+writeJawabanA(m)+b;

      function writeSoalA(sa){
        let [p,q,r]=[
          `<div class="col-lg-6 mb-3">
            <p class="fw-bolder">Pertanyaan :</p>
            <ol class="list-group list-group-numbered">`,
              `</ol>
              </div>`,
              ''
        ];
        
        sa.soal.forEach(el => {
           r+=`<li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                      <div class="text-start">${el.soal}</div>
                      Jawaban : ${el.kunci}
                    </div>
                  </li>`;         
        });
        
        return p+r+q;
      }

      function writeJawabanA(ja){
        let[p,q,r]=[
        `<div class="col-lg-6">
        <p class="fw-bolder">Pilihan Jawaban :</p>
                <div class="table-responsive">
                  <table class="table table-info">`,
                    `</table>
                </div>
              </div>`,
              ''
        ];
        
        ja.choice.forEach((el,i) => {
          r+=`<tr>
                  <td>${String.fromCharCode(i + 1+ 64)}</td>
                  <td>${el.choice}</td>
              </tr>   `                      
        });
        
        return p+r+q;
      }
    }
    function asyMatchingB(m){
      let [a,b]=[
        `<li class="list-group-item">
            <strong>${m.soalMain}</strong>
            <div class="row mt-3">`,

        `</div>
            <div class="position-relative mt-5">
              <div class="position-absolute bottom-0 start-0">
                <p class="px-4"><strong>Success : 80%</strong></p>
              </div>
              <div class="position-absolute bottom-0 end-0">
                <button id ="delMatchingB" type="button" data-delete="${m.idSoalIsi}" data-isi='Soal Matching' class="btn btn-danger" title="delete"><i class="bi bi-trash"></i></button>
                <button id="editBtnMatchingB" data-edit="${ m.idSoalIsi }" type="button" class="btn btn-success" title="edit"><i class="bi bi-wrench"></i>
                </button>
              </div>
            </div>
          </li>`
        ];
      return a+writeSoalB(m)+imageMatchingB(m)+b;

      function imageMatchingB(ib){
        return `<div class="col-lg-6">
                <p class="fw-bolder">Gambar :</p>
                <img src="${ib.filePath}" class="img-thumbnail" alt="...">
              </div>`;
      }

      function writeSoalB(sb){
        let [p,q,r]=[
          `<div class="col-lg-6 mb-3">
            <p class="fw-bolder">Pertanyaan :</p>
            <ol class="list-group list-group-numbered">`,
              `</ol>
              </div>`,
              ''
        ];
        
        sb.soal.forEach(el => {
           r+=`<li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                      <div class="text-start">${el.soal}</div>
                      Jawaban : ${el.kunci}
                    </div>
                  </li>`;         
        });
        
        return p+r+q;
      }
    }
  }
  
            

  function getData(data){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      return $.ajax({
        type: 'POST',
        url:'/soalData',
        data: {d:data}
      })
    }
  function sendImage(data){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      return $.ajax({
        type: 'POST',
        url:'/imgSend',
        contentType:false,
        cache:false,
        processData:false,
        data: data
      })
    }
</script>
    
@endpush

