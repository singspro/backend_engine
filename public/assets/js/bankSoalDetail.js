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
        judulEvt:'weqe',
        prePost:'post',
        soalUmum:false,
        releaseNilai:false,
        bahas:false,
        acakMc:false,
        acakTf:false,
        acakMatch:false,
        bobot:{
          balanced:true,
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
      console.log(soal);
    })

    $(document).on('submit','#submitEventForm',async function(e){
        e.preventDefault();
        let b=document.getElementById('submitBtn');
        submitSpinnerEvent(b);

        let formData=new FormData(this);
        let d={
          handler:'submitEvent',
          data:{
            a:formData.get('eventName'),
            b:formData.get('prePostCheck'),
            c:formData.get('soalUmumCheck'),
            d:formData.get('releaseNilaiCheck'),
            e:formData.get('bahasCheck'),
            f:formData.get('acakMc'),
            g:formData.get('acakTf'),
            h:formData.get('acakMatch'),
            i:formData.get('balancedCheck'),
            j:formData.get('bobotMc'),
            k:formData.get('bobotTf'),
            l:formData.get('bobotMatch'),
            m:formData.get('batasiMc'),
            n:formData.get('batasiTf'),
            o:document.getElementById('idSoalUtama').value
          }
        }
        try {
          // console.log(JSON.stringify(d));
          let a=await getData(JSON.stringify(d));
          if(a.status==='error'){
            submitSpinnerEventReset(b);
            showAlertEventError(a);
          }else{
            $('#generateModal').modal('hide');
            let modalQr=new ModalEventLink({
              id:'modalEventLink',
              link:a.data.linkSoal,
              kode:'laksdjf',
              expiredIn:a.data.validUntil,
            });

            modalQr.show();
          }       
        } catch (error) {
          console.log(error);
        }
        
    })
  
    });
  
    //  end ready function ---------------------------------------------------------------------------------------------------
  
    const soal={
      isi:[],
      jenis:[],
      qty:[]
    }

    function ModalEventLink(handler={
      id:'',
      link:'',
      kode:'',
      expiredIn:''
    }){
      this.id='qrModal'
      let modalHtml=`<div class="modal fade" id="${this.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"     aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Link Soal</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                          <div class='row'>
                            <div class='col-lg-12'>
                              <div class='col-lg-12 mb-3'>
                                <h5>Silahkan scan qr code di bawah ini untuk mendapatkan link soal. Selamat mengerjakan</h5>
                                <div id=qrCode1>
                                </div>
                              </div>
                              <div class='col-lg-12 mb-3'>
                                <a href=${handler.link} target="_blank">${handler.link}</a>
                              </div>
                              <div class='col-lg-12 mb-3'>
                                <h5>link tersebut akan expired pada : ${handler.expiredIn.date} pukul : ${handler.expiredIn.time} WIB</h5>
                              </div>
                            </div>
                          </div>
                          </div>
                          <div class="modal-footer">
                            <a href='/soalMain'><button type="button" class="btn btn-primary" data-bs-dismiss="modal">Got it</button></a>
                          </div>
                        </div>
                      </div>
                    </div>`;
      this.show=function(){
        let a=document.getElementById(handler.id);
        a.innerHTML=modalHtml;
        let qr=new QRCode(document.getElementById('qrCode1'),handler.link);
        $('#'+this.id).modal('show');
      }
    }
    function submitSpinnerEvent(b){
      let a=`<button class="btn btn-primary" type="button" disabled>
                      <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                      <span role="status">Loading...</span>
                      </button>
                      </div>`;
      b.innerHTML=a;
    }

    function submitSpinnerEventReset(b){
      let a=`<button type="submit" class="btn btn-primary">Create</button>`;

      b.innerHTML=a;
    }

    function showAlertEventError(d){
      let a=document.getElementById('alert1');
      let alertText=`<div class="alert alert-danger" role="alert">
                  ${d.errors}
                </div>`;
      a.innerHTML=alertText;
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
      this.balancedDis=function(){
        let l=0;
        let u=[this.q.qty.qtyMc,this.q.qty.qtyTf,this.q.qty.qtyMatching];
        u.forEach(ke => {
        if(ke>0){
          l++;
        }
      });
      return l;
      }
  
      this.soalMcLimit=function(){
        let a='';
        (this.q.qty.qtyMc !=0)? a='':a='disabled';
        return a;
      }
      this.soalTfLimit=function(){
        let a='';
        (this.q.qty.qtyTf !=0)? a='':a='disabled';
        return a;
      }
  
  
      let modal=`<div class="modal fade" id="generateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" >Create Questions Event</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id='submitEventForm' enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-floating mb-3">
            <input name='eventName' type="text" class="form-control">
            <label >Isikan judul event</label>
          </div>
          <div class="col-sm-6 mb-3">
            ${ this.prePost() }
          </div>
  
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name='soalUmumCheck' role="switch" ${ (this.q.soalUmum)?'checked':'' } >
            <label class="form-check-label" >Buka soal untuk umum</label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name='releaseNilaiCheck' role="switch"  ${ (this.q.releaseNilai)?'checked':'' }>
            <label class="form-check-label" >Langsung release nilai (nilai muncul setelah di submit)</label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name='bahasCheck' role="switch" ${ (this.q.bahas)?'checked':'' }> 
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
                <input class="form-check-input" type="checkbox" name='balancedCheck' onClick="balancedClick(this)" id="balancedCheck" ${ (this.q.bobot.balanced)?'checked':''} ${ (this.balancedDis()===1) ?'disabled' :''}>
                <label class="form-check-label" for="flexCheckChecked">
                  Balanced
                </label>
              </div>
  
              ${ this.bobot() }
              <div id="errorBobot">
              </div>
            </div>
            <div class="col-sm-12">
              <hr/>
            </div>
            <div id="batasiMc" class="col-sm-12 mt-3">
              <label  class="form-label">Batasi Jumlah Soal Multiple Choice : tidak dibatasi</label>
              <input onChange="batasiMcChag(this)" type="range" name='batasiMc' value='${ this.q.qty.qtyMc }' min="0" max="${ this.q.qty.qtyMc }" class="form-range" ${ this.soalMcLimit() }>
            </div>
            <div id="batasiTf" class="col-sm-12 mt-3">
              <label  class="form-label">Batasi Jumlah Soal True/false : tidak dibatasi</label>
              <input onChange="batasiTfChg(this)" type="range" name='batasiTf' value='${ this.q.qty.qtyTf }' min="0" max="${ this.q.qty.qtyTf }" class="form-range" ${ this.soalTfLimit() } >
            </div>
            <div id="alert1" class="col-sm-12 mt-3">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <div id=submitBtn>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </div>
        </form>
      </div>
      </div>
      </div>`;
  
      this.show=()=>{
        document.getElementById(this.anchor).innerHTML=modal;
        $('#generateModal').modal('show');
        let aaa={checked:this.q.bobot.balanced}
        balancedClick(aaa);
      }
    }
  
    function batasiMcChag(th){
      let a=document.querySelector('#batasiMc label');
      if(th.value==th.max){
        a.innerHTML=`Batasi Jumlah Soal Multiple Choice : tidak dibatasi `;
      }else{
        a.innerHTML=`Batasi Jumlah Soal Multiple Choice : ${th.value} dari ${th.max} `;
      }
    }
    function batasiTfChg(th){
      let a=document.querySelector('#batasiTf label');
      if(th.value==th.max){
        a.innerHTML=`Batasi Jumlah Soal True/false : tidak dibatasi `;
      }else{
        a.innerHTML=`Batasi Jumlah Soal True/false : ${th.value} dari ${th.max} `;
      }
    }
  
    function prePost(q){
      return `<div class="form-check">
                <input class="form-check-input" type="radio" name="prePostCheck" value='preTest' ${ (q==='pre')?'checked':''}>
                <label class="form-check-label" >
                  Pre Test
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="prePostCheck" value='postTest' ${ (q==='post')?'checked':''}>
                <label class="form-check-label" >
                  Post Test
                </label>
            </div>`;
    }
  
    function acakSwitch(z,q,w,e){
      let [a,b,c]=[z.qtyMc,z.qtyTf,z.qtyMatching];
      return ` <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name='acakMc' role="switch" ${ (a === 0)? 'disabled':'' } ${ (q)? 'checked':'' } >
                <label class="form-check-label" >Acak Soal Multiple Choice</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name='acakTf' role="switch" ${ (b === 0)? 'disabled':'' } ${ (w)? 'checked':'' }>
                <label class="form-check-label" >Acak Soal True/False</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name='acakMatch' role="switch" ${ (c === 0)? 'disabled':'' } ${ (e)? 'checked':'' }>
                <label class="form-check-label" >Acak Soal Matching</label>
              </div>
            </div>`;
    }
  
    function setViewBobot(q,w){
      let [a,b,c]=[q.qtyMc,q.qtyTf,q.qtyMatching];
      let [d,e,f]=['disabled','disabled','disabled'];
      let j=0;
      let g='';
      let h='';
      let i='';
      const k=[a,b,c];
      let l=0;
      k.forEach(ke => {
        if(ke>0){
          l++;
        }
      });
  
      if(l>1){
          if(a===0){
            d='disabled'
          }else{
            d='';
            j++;
            g=`data-drag='${j}'`;
          }
          if(b===0){
            e='disabled'
          }else{
            e='';
            j++;
            h=`data-drag='${j}'`;
          }
          if(c===0){
            f='disabled'
          }else{
            f='';
            j++;
            i=`data-drag='${j}'`;
          }
        
      }
  
      return {
        d:d,
        e:e,
        f:f,
        g:g,
        h:h,
        i:i
      }
    }
    function bobot(q,w){
      let i=setViewBobot(q,w);  
      return `  <label id="bbprcnt1"  class="form-label">Bobot Soal Multiple Choice :25 %</label>
                <input id="bobotMc" ${ i.g } data-status='${i.d}' onChange="dragMc(this)" onInput="inpCh1(this)" type="range" name='bobotMc'  class="form-range" value="25" ${i.d}>
             
            
                <label id="bbprcnt2"   class="form-label">Bobot Soal True/False :35 %</label>
                <input id="bobotTf" ${ i.h } data-status='${i.e}' onChange="dragTf(this)" onInput="inpCh2(this)"  type="range" name='bobotTf' class="form-range" value="35" ${i.e}>
            
              
                <label id="bbprcnt3"   class="form-label">Bobot Soal Matching :40 %</label>
                <input id="bobotMatch" ${ i.i } data-status='${i.f}' onChange="dragMatch(this)" onInput="inpCh3(this)"  type="range" name='bobotMatch' class="form-range" value="40" ${i.f}>`;
    }
  
    function inpCh1(th){
      document.getElementById('bbprcnt1').innerHTML=`Bobot Soal Multiple Choice :${th.value} %`
    }
    function inpCh2(th){
      document.getElementById('bbprcnt2').innerHTML=`Bobot Soal True/False :${th.value} %`
    }
    function inpCh3(th){
      document.getElementById('bbprcnt3').innerHTML=`Bobot Soal Matching :${th.value} %`
    }
  
    function dragMc(th){
      processBobot(th.id,th.getAttribute('data-drag'),['bobotMc','bobotTf','bobotMatch']);
      updateBobots();
      checkError(['bobotMc','bobotTf','bobotMatch']);
      
    }
    function dragTf(th){
      processBobot(th.id,th.getAttribute('data-drag'),['bobotMc','bobotTf','bobotMatch']);
      updateBobots();
      checkError(['bobotMc','bobotTf','bobotMatch']);
    }
    function dragMatch(th){
      processBobot(th.id,th.getAttribute('data-drag'),['bobotMc','bobotTf','bobotMatch']);
      updateBobots();
      checkError(['bobotMc','bobotTf','bobotMatch']);
    }
  
    function checkError(aa){
      let i = setViewBobot(soal.qty,false);
      let a=document.getElementById(aa[0]).value;
      let b=document.getElementById(aa[1]).value;
      let c=document.getElementById(aa[2]).value;
      let total=0;
      (i.d!=='disabled')? total+=parseInt(a):'';
      (i.e!=='disabled')? total+=parseInt(b):'';
      (i.f!=='disabled')? total+=parseInt(c):'';
  
      if(total>100){
        document.getElementById('errorBobot').innerHTML=`<div class="alert alert-danger" role="alert">bobot soal tidak seimbang total tidak boleh dari 100% </div>`;
      }else{
        document.getElementById('errorBobot').innerHTML='';
      }
  
    }
  
    function processBobot(handler,drag,ids){
      function x(xx){
        const data={
          g:[],
          h:0
        }
        xx.forEach(xxe => {
          if(document.getElementById(xxe).getAttribute('data-status')!='disabled'){
            data.h++;
            data.g.push({
              id:xxe,
              status:document.getElementById(xxe).getAttribute('data-status'),
              num:document.getElementById(xxe).getAttribute('data-drag'),
            });
          }
        });
  
        return data;
      }
  
      let b=x(ids).g;
      let n=x(ids).h;
  
      for (let ii = 1; ii <= n; ii++) {
        if(drag!=1){
          if(ii===1){
            b.forEach(ge => {
              if(ge.id===handler){
                document.getElementById(ge.id).setAttribute('data-drag','1');
              }
            });
          }else{
            b.forEach(ge => {
              if(ge.num==1 && ge.id!=handler){
                document.getElementById(ge.id).setAttribute('data-drag',`2`);
              }else{
                if(ge.num==ii-1 && ge.id!=handler){
                  document.getElementById(ge.id).setAttribute('data-drag',`${ii}`);
                }
              }
            });
          }      
        }
      }
  
      let m=x(ids).g;
      let z=x(ids).h;
      let p=0;
      for (let ii = 1; ii <= z; ii++) {
        if(ii != z){
          m.forEach(me => {
            if(me.num==ii){
              p+=parseInt(document.getElementById(me.id).value);
            }
          });
        }else{
          m.forEach(me => {
              if(me.num==ii){
              document.getElementById(me.id).value=100-p;
            }
          });
        }   
      }
    }
  
    function updateBobots(){
      document.getElementById('bbprcnt1').innerHTML=`Bobot Soal Multiple Choice :${document.getElementById('bobotMc').value} %`
      document.getElementById('bbprcnt2').innerHTML=`Bobot Soal True/False :${document.getElementById('bobotTf').value} %`
      document.getElementById('bbprcnt3').innerHTML=`Bobot Soal Matching :${document.getElementById('bobotMatch').value} %`
    }
  
    function balancedClick(th){
      if (th.checked){
        document.getElementById('bobotMc').disabled=true;
        document.getElementById('bobotTf').disabled=true;
        document.getElementById('bobotMatch').disabled=true;
      }else{
        let i = setViewBobot(soal.qty,false);
        (i.d==='disabled')? document.getElementById('bobotMc').disabled=true:document.getElementById('bobotMc').disabled=false;
        (i.e==='disabled')? document.getElementById('bobotTf').disabled=true:document.getElementById('bobotTf').disabled=false;
        (i.f==='disabled')? document.getElementById('bobotMatch').disabled=true:document.getElementById('bobotMatch').disabled=false;
      }
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
      let c=[];
      let choice=[];
  
      for (let i = 0; i < a; i++) {
        c.push({
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
                          soal:c,
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
      // console.log(x);
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
              isi+=`<li class="list-group-item">${element.soal}${cover} <div class="position-relative mt-5"><div class="position-absolute bottom-0 start-0">
              <p class="px-4 text-bg-info">Success (Post Test) : ${element.prog.posSuc}%  dari ${element.prog.posRes} responden</p>
              </div><div class="position-absolute bottom-0 end-0">
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
              isi+=`<li class="list-group-item">${element.soal}${cover} <div class="position-relative mt-5"><div class="position-absolute bottom-0 start-0">
              <p class="px-4 text-bg-info">Success (Post Test) : ${element.prog.posSuc}%  dari ${element.prog.posRes} responden</p>
              </div><div class="position-absolute bottom-0 end-0">
                <button id ="del" type="button" data-delete="${element.idSoalIsi}" data-isi='${element.soal}' class="btn btn-danger" title="delete"><i class="bi bi-trash"></i></button>
                <button id="editBtn" data-edit="${element.idSoalIsi}" type="button" class="btn btn-success" title="edit"><i class="bi bi-wrench"></i></button></div></div></li>`;
              }
            });
            let rakitan=head+isi+foot;
            document.getElementById('wasem').innerHTML=rakitan;
    }
  
    function showSoalMatching(x){
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
                <p class="px-4 text-bg-info">Success (post test) : ${m.prog.posSuc}% dari ${m.prog.posRes} responden</p>
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
                  <p class="px-4 text-bg-info">Success (post test) : ${m.prog.posSuc}% dari ${m.prog.posRes} responden</p>
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