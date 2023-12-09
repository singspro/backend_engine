<?php

namespace App\Http\Controllers;

use App\Models\bankSoalIsi;
use App\Models\bankSoalJawaban;
use App\Models\bankSoalMatchingChoice;
use App\Models\bankSoalMatchingSoal;
use App\Models\bankSoalUtama;
use App\Models\tafData;
use App\Models\tafPeserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;
use App\Models\training;
use App\Models\kodeTraining;
use App\Models\uraianMateri;
use App\Models\lokasiTraining;
use App\Models\lembagaTraining;
use App\Models\instructor;
use App\Models\manpower;
use App\Models\trainingPeserta;

class trainingController extends Controller
{
    public function trainingData() 
    {   
        if(Request('search')){
            $data=$this->dataTraining(Request('search'));
        }else{
            $data=training::dataTrainingAll()->orderBy('start','DESC')->paginate(10);
        }
        return view('training-data',[
            'title'=>'training',
            'subTitle'=>'data',
            'trainingData'=>$data,
            'user'=>Auth::user()
        ]);
    }
    public function trainingNew() 
    {   
        return view('training-new',[
            'title'=>'training',
            'subTitle'=>'new',
            'kodeTraining'=>kodeTraining::all(),
            'uraianMateri'=>uraianMateri::all(),
            'lokasiTraining'=>lokasiTraining::all(),
            'lembagaTraining'=>lembagaTraining::all(),
            'instructor'=>instructor::all(),
            'dataManpower'=>$this->getManpowerAll()->where('status','=','AKTIF')->get(),
            'user'=>Auth::user()
        ]);
    }
    public function trainingTaf()
    {
        return view('training-taf',[
            'title'=>'training',
            'subTitle'=>'taf',
            'user'=>Auth::user(),
            'data'=>tafData::dataTaf()->orderBy('createDate','DESC')->get()
        ]);
    }

    public function trainingNewSave(Request $request)
    {   
        $getIdTr=$this->generateCodeTraining($request);
        $request['idTr']=$getIdTr; //tambah prperty idTr dari data

        $validator=Validator::make($request->all(),$this->validatorList($request),$this->validatorMessage());
        if($validator->fails()){
            return response()->json(array(
                'success'=>false,
                'errors'=>$validator->getMessageBag()->toArray()
            ),400);
        }

      training::create($this->dataTrainingInput($request));
      $this->saveFile($request,$getIdTr); 
      $this->trainingPesertaInput($request); 
      return response()->json(array(
        'success'=>true,
        'errors'=>false,
        'idTr'=>$getIdTr
        ),200);
    }

    public function trainingDetail(Request $request){
        return view('training-detail',[
            'title'=>'training',
            'subTitle'=>'data',
            'data'=>$this->getDataManpowerTraining($request->imore),
            'idTr'=>$request->imore,
            'absensiCek'=>Storage::exists($this->fileDirectory('absensi').$request->imore.'.pdf'),
            'dokumenCek'=>Storage::exists($this->fileDirectory('dokumen').$request->imore.'.pdf'),
            'user'=>Auth::user()
        ]);
    }

    public function trainingEdit(Request $request){
        return view('training-edit',[
            'title'=>'training',
            'subTitle'=>'data',
            'kodeTraining'=>kodeTraining::all(),
            'uraianMateri'=>uraianMateri::all(),
            'lokasiTraining'=>lokasiTraining::all(),
            'lembagaTraining'=>lembagaTraining::all(),
            'instructor'=>instructor::all(),
            'dataManpower'=>manpower::manpowerAll()->get(),
            'dataTraining'=>$this->getDataManpowerTraining($request->imore),
            'category'=>$this->categoryLIst(),
            'programTraining'=>$this->programTrainingList(),
            'hardSoft'=>$this->hardSoftLIst(),
            'idTr'=>$request,
            'absensiCek'=>Storage::exists($this->fileDirectory('absensi').$request->imore.'.pdf'),
            'dokumenCek'=>Storage::exists($this->fileDirectory('dokumen').$request->imore.'.pdf'),
            'user'=>Auth::user()
        ]);
    }

    public function getPesertaTraining(Request $request){
        $data=$this->getDataManpowerTraining($request->idTr);
       return response()->json(array(
        'success'=>true,
        'data'=>$data
        ),200);
    }

    public function trainingEditSave(Request $request){
        // dd($request);
        // urutan langkah saving:
        // 1. Ambil data dan validasi data
        // 2. Update data pada training table
        // 3. Cocokan data apakah ada perubahan pada id training
        // 4. jika ada maka update idTr pada peserta training, jika tidak ada maka langsung ke langkah no. 6
        // 5. Update file name pada file absensi dan dokumen training
        // 6. Update data pada peserta training

        $getIdTr=$this->generateCodeTraining($request);
        $request['idTr']=$getIdTr; //tambah prperty idTr dari data

        $validator=Validator::make($request->all(),$this->validatorListEdit($request),$this->validatorMessage());
        if($validator->fails()){
            return response()->json(array(
                'success'=>false,
                'errors'=>$validator->getMessageBag()->toArray()
            ),400);
        }

        training::where('idTr',$request->idTrOld)->update($this->dataTrainingInput($request));
        if($request->idTrOld!=$request->idTr){ 
            trainingPeserta::where('idTr',$request->idTrOld)->update(['idTr'=>$request->idTr]);
            Storage::move($this->fileDirectory('absensi').$request->idTrOld.'.pdf',$this->fileDirectory('absensi').$request->idTr.'.pdf');
            Storage::move($this->fileDirectory('dokumen').$request->idTrOld.'.pdf',$this->fileDirectory('dokumen').$request->idTr.'.pdf');
            $this->fileStatus($request);
            $this->saveFile($request,$request->idTr);
            $this->trainingPesertaInput($request);
        }else{
            $this->fileStatus($request);
            $this->saveFile($request,$request->idTr);
            $this->trainingPesertaInput($request);
        }

      return response()->json(array(
        'success'=>true,
        'errors'=>false,
        'idTr'=>$getIdTr
        ),200);
    }

    public function downloadFileAbsensi(Request $request){
        return Storage::download($this->fileDirectory('absensi').$request->idTr.'.pdf');
    }
    
    public function downloadFileDokumen(Request $request){
        return Storage::download($this->fileDirectory('dokumen').$request->idTr.'.pdf');
    }

    public function deleteTraining(Request $request){
        training::where('idTr',$request->idTr)->delete();
        trainingPeserta::where('idTr',$request->idTr)->delete();
        Storage::delete($this->fileDirectory('absensi').$request->idTr.'.pdf');
        Storage::delete($this->fileDirectory('dokumen').$request->idTr.'.pdf');
        return redirect('/tr');
    }

    public function newTaf(){
        return view('training-taf-new',[
            'title'=>'training',
            'subTitle'=>'taf',
            'user'=>Auth::user(),
            'kodeTraining'=>kodeTraining::all(),
            'uraianMateri'=>uraianMateri::all(),
            'lokasiTraining'=>lokasiTraining::all(),
            'lembagaTraining'=>lembagaTraining::all(),
            'instructor'=>instructor::all(),
            'dataManpower'=>$this->getManpowerAll()->where('status','=','AKTIF')->get(),
        ]);
    }

    public function newTafSave(Request $request){
        $getIdTaf=$this->getTafCode($request);
        $request['idTaf']=$getIdTaf; //tambah prperty idTr dari data
        $validator=Validator::make($request->all(),$this->validatorTafList($request),$this->validatorTafMessage());
        if($validator->fails()){
            return response()->json(array(
                'success'=>false,
                'errors'=>$validator->getMessageBag()->toArray()
            ),400);
        }
        tafData::create($this->tafDataInput($request));
        $this->savePeserta($request);
        return response()->json(array(
            'success'=>true,
            'data'=>$request->idTaf
        ),200);
    }

    public function tafDetail(Request $request){
        return view ('training-taf-detail',[
            'title'=>'training',
            'subTitle'=>'taf',
            'user'=>Auth::user(),
            'dataTaf'=>tafData::dataTaf()->where('idTaf','=',$request->data)->get(),
            'dataPeserta'=>tafPeserta::getData()->where('idTaf','=',$request->data)->get()
        ]);
    }

    public function tafEdit(Request $request){
        return view ('training-taf-edit',[
            'title'=>'training',
            'subTitle'=>'taf',
            'user'=>Auth::user(),
            'kodeTraining'=>kodeTraining::all(),
            'uraianMateri'=>uraianMateri::all(),
            'lokasiTraining'=>lokasiTraining::all(),
            'lembagaTraining'=>lembagaTraining::all(),
            'dataTaf'=>tafData::dataTaf()->where('idTaf','=',$request->enak)->get(),
            'dataManpower'=>$this->getManpowerAll()->where('status','=','AKTIF')->get(),
            'jenisTaf'=>['Pelatihan','Kursus']
            ]);
    }

    public function bankSoalMain(Request $request){
        return view('training-bankSoal',[
            'title'=>'training',
            'subTitle'=>'soal',
            'user'=>Auth::user(),
            'data'=>bankSoalUtama::all()
        ]);
        
    }

    public function soalDetail(Request $request){
        return view('training-bankSoalDetail',[
            'title'=>'training',
            'subTitle'=>'soal',
            'user'=>Auth::user(),
            'dataUtama'=>bankSoalUtama::where('idSoalUtama',$request->bintangKecil)->get(),
            'blankImgPath'=>env('FILE_HOST').'imgQuestions?img=blank.jpg',
            'blankImgPathMatchingB'=>env('FILE_HOST').'imgQuestions?img=blank.jpg'
        ]);
    }

    public function hemm(Request $request){
        $data=[];
        $handler=json_decode($request->d);
        // dd($handler);
        switch ($handler->handler) {
            case 'isiSoal':
                $aa=$this->ambilDataSoal($handler->id);
                $data=[
                    'status'=>'success',
                    'soal'=>$aa['data'],
                    'jenis'=>$aa['jenis'],
                    'qty'=>$aa['qty']
                    ];
                break;
            case 'deleteItem':
                $this->deleteSoalIsi($handler->delId,$handler->id);
                $aa=$this->ambilDataSoal($handler->id);
                $data=[
                    'status'=>'success',
                    'soal'=>$aa['data'],
                    'jenis'=>$aa['jenis'],
                    'qty'=>$aa['qty']
                    ];
                break;
            case 'deleteSoalMatching':
                $this->deleteSoalMatching($handler->idSoalIsi);
                $aa=$this->ambilDataSoal($handler->idSoalUtama);
                $data=[
                    'status'=>'success',
                    'soal'=>$aa['data'],
                    'jenis'=>$aa['jenis'],
                    'qty'=>$aa['qty']
                    ];
                break;
            case 'submitSoalMatchingA':
                $error=$this->validationSoalMatchingA($handler); /// validasi soal///
                if(count($error)>0){
                    $data=[
                        'status'=>'error',
                        'errors'=>$error
                    ];
                    
                }else{

                    $this->insertSoalMatchingA($handler);
                    $aa=$this->ambilDataSoal($handler->data->idSoalUtama);
                    $data=[
                        'status'=>'success',
                        'soal'=>$aa['data'],
                        'jenis'=>$aa['jenis'],
                        'qty'=>$aa['qty']
                        ];
                    
                }
                break;
            case 'submitSoalMatchingB':
                $error=$this->validationSoalMatchingB($handler);
                if(count($error)>0){
                    $data=[
                        'status'=>'error',
                        'errors'=>$error
                    ];
                }else{
                    $v=$this->insertSoalMatchingB($handler);
                    $data=[
                        'status'=>'success',
                        'idSoalIsi'=>$v
                    ];                    
                }
                break;
            case 'submitSoalTf':
                $valid=$this->validationSoal($handler->data);
                if(count($valid)>0){
                    $data=[
                        'status'=>'error',
                        'errors'=>$valid
                    ];
                }
                else{
                    if($handler->data->editOrNew==='new'){
                        $idSoalIsi=$this->insertSoal($handler);
                        $data=[
                            'status'=>'success',
                            'idSoalIsi'=>$idSoalIsi,
                        ];
                    }
                    else{
                        $idSoalIsi=$this->editSoal($handler);
                        $data=[
                            'status'=>'success',
                            'idSoalIsi'=>$idSoalIsi,
                        ];
                    }
                }
                break;
            case 'submitSoalMc':
                $valid=$this->validationSoal($handler->data);
                if(count($valid)>0){
                    $data=[
                        'status'=>'error',
                        'errors'=>$valid
                    ];
                }
                else{
                    if($handler->data->editOrNew==='new'){
                        // dd($handler);
                        $idSoalIsi=$this->insertSoal($handler);
                        $data=[
                            'status'=>'success',
                            'idSoalIsi'=>$idSoalIsi,
                        ];
                    }
                    else{
                        $idSoalIsi=$this->editSoal($handler);
                        $data=[
                            'status'=>'success',
                            'idSoalIsi'=>$idSoalIsi,
                        ];
                    }
                    
                }
                break;
            case 'imgBlankPathSoal':
                $data=[
                    'path'=>env('FILE_HOST').'imgQuestions?img=blank.jpg'
                ];
                break;
            case 'getSoalSatuan':
                $soal = $this->getSoalSatuan($handler->idSoalISi , $handler->idSoalUtama);
                $data=[
                    'status'=>'success',
                    'data'=>$soal
                ];
                break;
            case 'getSoalMatchingSatuanA' :
                $soal=$this->getSoalMatchingSatuanA($handler);
                $data=[
                    'status'=>'success',
                    'data'=>$soal
                ];
                break;
            case 'getSoalMatchingSatuanB' :
                $soal=$this->getSoalMatchingSatuanB($handler);
                $data=[
                    'status'=>'success',
                    'data'=>$soal
                ];
                break;
            default:
                # code...
                break;
        }
        return response()->json($data,200);
    }

    public function soalImageSend(Request $request){
        if($request->imgRemove==1){
            if(Storage::exists(env('SOAL_IMG_PATH').$request->idSoalIsi.'.jpg')){
                Storage::delete(env('SOAL_IMG_PATH').$request->idSoalIsi.'.jpg');
            }
        }
        if($request->hasFile('file')){
            $request->file->storeAs(env('SOAL_IMG_PATH'),$request->idSoalIsi.'.jpg');
            // dd('ngok');
        }
        $aa=$this->ambilDataSoal($request->idSoalUtama);
        $data=[
            'status'=>'success',
            'soal'=>$aa['data'],
            'jenis'=>$aa['jenis'],
            'qty'=>$aa['qty']
            ];

        return response()->json($data,200);
    }
    public function soalImg(Request $request){
        return response()->file(storage_path('app/questionImage/'.$request->img));
    }
    public function tafGetPesertaEdit(Request $request){
        $data=tafPeserta::getData()->where('idTaf','=',$request->idTaf)->get();
        return response()->json(array(
         'success'=>true,
         'data'=>$data
         ),200);
         
    }
    public function tafEditSave(Request $request){
        $validator=Validator::make($request->all(),$this->validatorTafList($request),$this->validatorTafMessage());
        if($validator->fails()){
            return response()->json(array(
                'success'=>false,
                'errors'=>$validator->getMessageBag()->toArray()
            ),400);
        }

        tafData::where('idTaf',$request->idTaf)->update($this->tafDataInput($request));
        $this->updatePesertaTaf($request);
        return response()->json(array(
            'success'=>true,
            'data'=>$request->idTaf
        ),200);
    }

    public function tafDelete(Request $request){
        tafData::where('idTaf',$request->crut)->delete();
        tafPeserta::where('idTaf',$request->crut)->delete();

        return redirect('/tr-taf');
    }

    public function tafGetDataForGeneratePdf(Request $request){
        $data=tafData::dataTaf()->where('idTaf','=',$request->idTaf)->get();
        if($data->first()->kodeTraining!="-"){
            $materi=$data->first()->judul;
        }else{
            $materi=$data->first()->uraianMateri;
        }
        $dataTaf=array($data->first()->idTaf,
                        $materi,
                        $data->first()->namaLembaga,
                        date_format(date_create($data->first()->startDate),"d-M-Y"),
                        date_format(date_create($data->first()->endDate),"d-M-Y"),
                        date_format(date_create($data->first()->createDate),"d-M-Y"),
                        $data->first()->lokasiTraining,
                        ($data->first()->biaya!=null)? $data->first()->biaya:"",
                        ($data->first()->pjo!=null)? $data->first()->pjo:"",
                        ($data->first()->divisi!=null)?$data->first()->divisi:"",
                        ($data->first()->dept!=null)?$data->first()->dept:"",
                        ($data->first()->hr!=null)?$data->first()->hr:"",
                        ($data->first()->to!=null)?$data->first()->to:"",
                        ($data->first()->from!=null)?$data->first()->from:"",
                        ($data->first()->subject!=null)?$data->first()->subject:"",
                        $data->first()->jenisTaf);
        $data=tafPeserta::getData()->where('idTaf','=',$request->idTaf)->get();

        foreach ($data as $key=>$value) {
            if($value->perusahaan!=1){
                $nrp[$key]="-";
            }else{
                $nrp[$key]=$value->nrp;
            }
            $nama[$key]=$value->nama;
            $dept[$key]=$value->section;
            $jbt[$key]=$value->jabatanStr;
            $jointDate[$key]=date_format(date_create($value->jointDate),"d-M-Y");
        }
        $psrtTaf=array($nrp,$nama,$dept,$jbt,$jointDate);

        return response()->json(array(
            'success'=>true,
            'dataTaf'=>$dataTaf,
            'psrtTaf'=>$psrtTaf

        ),200);
    }

    public function getDataTrainingDetail(Request $request){
        $training=training::dataTrainingAll()
                    ->where('trainings.idTr','=',$request->idTr)
                    ->get();
        $peserta=$this->getDataManpowerTraining($request->idTr);
        // dd($training);
        return response()->json(array(
            'data'=>$training,
            'peserta'=>$peserta,
        ),200);
    }

    

    // callback function---------------------------------------------------------------------

    private function validationSoalMatchingB($data){
        $error=[];
        $t=true;
        foreach ($data->soal->soal as $soalV) {
            if($soalV->soal!=''){
                $t=false;
                if($soalV->kunci===''){
                    $error[]='Soal '.$soalV->soal.' jawaban masih kosong';
                }
            }
        }
        if($t){
            $error[]='Minimal 1 soal diisi ya jangan dibiarin kosong semua';
        }
        if($data->modalStatus==='new'){
            if($data->soal->fileStatus===false){
                $error[]='Upload gambar !! soal ini wajib ada gambar';
            }
        }else{
            if($data->soal->fileStatus===false && $data->soal->imgDelStatus===1){
                $error[]='Upload gambar !! soal ini wajib ada gambar';
            }
        }
        if($data->soal->soalMain===''){
            $error[]='perintah soal masih kosong';
        }

        return $error;
    }
    private function validationSoalMatchingA($data){
        $error=[];
        $logicSoal=true;
        $logicChoice=true;
        $soal=$data->data->soal;
        $choice=$data->data->choice; 

        foreach ($soal as $sv) {
            if($logicSoal){
                ($sv->soal!='')?$logicSoal=false:'';
            }
        }
        foreach ($choice as $cv) {
            if($logicChoice){
                ($cv->choice!='')?$logicChoice=false:'';
            }
        }

        foreach ($soal as $sv) {
            $logic=false;
            if($sv->soal !=''){
                foreach ($choice as $cv) {
                    if ($sv->kunci===$cv->choiceAbj){
                        $logic=true;
                        if($cv->choice===''){
                            $error[]='Soal '.$sv->soal.' jawabannya masih kosong';
                        }
                    }
                }
                if($logic!=true){
                    $error[]='Soal '.$sv->soal.' tidak ada jawaban yang cocok dengan pilihan jawaban';
                }
            }
        }

        ($data->data->soalMain==='' ||$data->data->soalMain===null)? $error[]='perintah masih kosong':'';
        ($logicSoal)? $error[]='Soal masih kosong, minimal 1 soal diisi':'';
        ($logicChoice)? $error[]='Pilihan Jawaban masih kosong, minimal 1 diisi':'';

        return $error;
    }

    private function insertSoalMatchingB($data){
        $b='';
        function insertSoalB($z){
            $idSoalIsi=uniqid('soalIsi');
            bankSoalIsi::create([
                'idSoalUtama'=>$z->soal->idSoalUtama,
                'idSoalIsi'=>$idSoalIsi,
                'soal'=>$z->soal->soalMain,
                'jenisSoal'=>$z->soal->jenis
            ]);
            
            foreach ($z->soal->soal as $soalV) {
                if($soalV->soal !=''){
                    bankSoalMatchingSoal::create([
                        'idSoalIsi'=>$idSoalIsi,
                        'soal'=>$soalV->soal,
                        'kunci'=>strtoupper($soalV->kunci),
                    ]);
                }
            }

            return $idSoalIsi;
        }

        function editSoalB($n){
            // dd($n);
            $idSoalIsi=$n->soal->idSoalIsi;
            $p=bankSoalIsi::where('idSoalISi',$idSoalIsi)->get();
            $l=bankSoalMatchingSoal::where('idSoalIsi',$idSoalIsi)->get();
            if($p->first()->soal != $n->soal->soalMain){
                bankSoalIsi::where('idSoalIsi',$idSoalIsi)->update(['soal'=>$n->soal->soalMain]);
            }
            foreach ($n->soal->soal as $soalV) {
                if($soalV->id==='new'){
                    if($soalV->soal!=''){
                        bankSoalMatchingSoal::create([
                            'idSoalIsi'=>$idSoalIsi,
                            'soal'=>$soalV->soal,
                            'kunci'=>$soalV->kunci
                        ]);
                    }
                }else{
                    foreach ($l as $lv) {
                        if($soalV->id==$lv->id){
                            if($soalV->soal !=''){
                                if($soalV->soal != $lv->soal || $soalV->kunci != $lv->kunci){
                                    bankSoalMatchingSoal::where('id',$soalV->id)->update([
                                        'soal'=>$soalV->soal,
                                        'kunci'=>$soalV->kunci
                                    ]);
                                }
                            }else{
                                bankSoalMatchingSoal::where('id',$lv->id)->delete();
                            }
                        }
                    }
                }
            }

           

            return $idSoalIsi;
        }


        if($data->modalStatus==='new'){
            $b=insertSoalB($data);
        }else{
            $b=editSoalB($data);
        }

        return $b;
    }
    private function insertSoalMatchingA($data){
        function editSoal($w){
            $a=$w->data->soal;
            $b=$w->data->choice;
            $c=$w->data->soalMain;
            $d=$w->data->idSoalIsi;
            

            $cc=bankSoalIsi::where('idSoalIsi',$d)->get();
            if($c != $cc->first()->soal){
                bankSoalIsi::where('idSoalIsi',$d)->update(['soal'=>$c]);
            }

            $aa=bankSoalMatchingSoal::where('idSoalIsi',$d)->get();
            foreach ($a as $av) {
                if($av->id==='new' && $av->soal !=''){
                    bankSoalMatchingSoal::create([
                        'idSoalIsi'=>$d,
                        'soal'=>$av->soal,
                        'kunci'=>$bv->choice
                    ]);
                }else{
                    foreach ($b as $bv) {
                        if($av->kunci===$bv->choiceAbj){
                            foreach ($aa as $aav) {
                                if($av->id==$aav->id && $aav->soal != $av->soal || $aav->kunci != $bv->choice){
                                    if($av->soal !=''){
                                        bankSoalMatchingSoal::where('id',$av->id)->update([
                                            'soal'=>$av->soal,
                                            'kunci'=>$bv->choice
                                        ]);
                                    }else{
                                        bankSoalMatchingSoal::where('id',$av->id)->delete();
                                    }
                                }
                                
                            }
                        }
                    }
                }
            }

            $bb=bankSoalMatchingChoice::where('idSoalIsi',$d)->get();
            foreach ($b as $bv) {
                if($bv->id !='new'){
                    foreach ($bb as $bbv) {
                        if($bv->id==$bbv->id && $bv->choice != $bbv->pilihanJawaban){
                            if($bv->choice !=''){
                                bankSoalMatchingChoice::where('id',$bv->id)->update(['pilihanJawaban'=>$bv->choice]);
                            }else{
                                bankSoalMatchingChoice::where('id',$bv->id)->delete();
                            }
                        }
                        
                    }
                }else{
                        if($bv->choice !=''){
                            bankSoalMatchingChoice::create([
                                'idSoalIsi'=>$d,
                                'pilihanJawaban'=>$bv->choice]);
                            }
                        
                    }
                }
            


            return $d;
        }

        function insertSoal($e){
            $idSoalIsi=uniqid('soalIsi');
            $a=$e->data->soal;
            $b=$e->data->choice;
            foreach ($a as $av) {
                foreach ($b as $bv) {
                    if($av->kunci===$bv->choiceAbj && $av->soal !=''){
                        bankSoalMatchingSoal::create([
                            'idSoalIsi'=>$idSoalIsi,
                            'soal'=>$av->soal,
                            'kunci'=>$bv->choice,
                        ]);
                    }
                }
            }
            foreach ($b as $bv) {
                if($bv->choice !=''){
                    bankSoalMatchingChoice::create([
                        'idSoalIsi'=>$idSoalIsi,
                        'pilihanJawaban'=>$bv->choice,
                    ]);
                }
            }
            
            bankSoalIsi::create([
                'idSoalUtama'=>$e->data->idSoalUtama,
                'idSoalIsi'=>$idSoalIsi,
                'soal'=>$e->data->soalMain,
                'jenisSoal'=>$e->data->jenis
            ]);
    
            return $idSoalIsi;
        }


        $q='';
        if($data->modalStatus==='new'){
            $q=insertSoal($data);
        }else{
            $q=editSoal($data);
        }
        return $q;
    }

    private function getSoalMatchingSatuanB($handler){
        $idSoalIsi=$handler->idSoalIsi;
        $idSoalUtama=$handler->idSoalUtama;
        $soal=[];
        $fileStatus=false;
        $filePath='';

        $f=bankSoalIsi::where('idSoalIsi',$idSoalIsi)->get();
        $g=bankSoalMatchingSoal::where('idSoalIsi',$idSoalIsi)->get();
        if(Storage::exists(env('SOAL_IMG_PATH').$idSoalIsi.'.jpg')){
            $fileStatus=true;
            $filePath=env('FILE_HOST').'imgQuestions?img='.$idSoalIsi.'.jpg';
        }
        foreach ($g as $gv) {
            $soal[]=[
                'id'=>$gv->id,
                'soal'=>$gv->soal,
                'kunci'=>$gv->kunci
            ];
        }
        $data=[
            'soal'=>[
                'soal'=>$soal,
                'soalMain'=>$f->first()->soal,
                'fileStatus'=>$fileStatus,
                'filePath'=>$filePath,
                'jenis'=>3,
                'idSoalIsi'=>$idSoalIsi,
                'idSoalUtama'=>$idSoalUtama,
            ],
            'modalStatus'=>'edit'
        ];
        
        return $data;
    }



    private function getSoalMatchingSatuanA($handler){
        $idSoalIsi=$handler->idSoalIsi;
        $idSoalUtama=$handler->idSoalUtama;
        $soal=[];
        $choice=[];
        $soalMain=bankSoalIsi::where('idSoalUtama',$idSoalUtama)
                                ->where('idSoalIsi',$idSoalIsi)
                                ->get();
        $h=bankSoalMatchingSoal::where('idSoalIsi',$idSoalIsi)->get();
        $j=bankSoalMatchingChoice::where('idSoalIsi',$idSoalIsi)->get();

        foreach ($h as $hv) {
            $soal[]=[
                'id' => $hv->id,
                'soal'=> $hv->soal,
                'kunci'=> $hv->kunci
            ];
        }

        foreach ($j as $jv) {
            
            $choice[]=[
                'id' => $jv->id,
                'choice' => $jv->pilihanJawaban
            ];
        }

        $data=[
            'soalMain'=>$soalMain->first()->soal,
            'fileStatus'=>false,
            'filePath'=>'',
            'jenis'=>3,
            'idSoalIsi'=>$idSoalIsi,
            'idSoalUtama'=>$idSoalUtama,
            'soal'=>$soal,
            'choice'=>$choice
        ];

        return $data;
    }
    private function getSoalSatuan($idSoalIsi,$idSoalUtama){
        $choice=[];
        $key='';
        $filePath='';
        $fileStatus=false;
        $soalSatuan=bankSoalIsi::where('idSoalIsi',$idSoalIsi)->get();
        // dd($soalSatuan);
        $jawaban=bankSoalJawaban::where('idSoalIsi',$idSoalIsi)->get();
        foreach ($jawaban as $value) {
            $choice[]=[
                'id'=>$value->id,
                'value'=>$value->pilihanJawaban
            ];
            if($value->jawabanBenar===1){
                $key=$value->pilihanJawaban;
            }
        }
        if(Storage::exists(env('SOAL_IMG_PATH').$idSoalIsi.'.jpg')){
            $fileStatus=true;
            $filePath=env('FILE_HOST').'imgQuestions?img='.$idSoalIsi.'.jpg';
        }
        $data=[
            'idSoalUtama'=>$idSoalUtama,
            'idSoalIsi'=>$idSoalIsi,
            'jenis'=>$soalSatuan->first()->jenisSoal,
            'soal'=>$soalSatuan->first()->soal,
            'choice'=>$choice,
            'key'=>$key,
            'fileStatus'=>$fileStatus,
            'filePath'=>$filePath
        ];

        return $data;
    }
    private function validationSoal($data){
        $errors=[];
       if($data->isi===''||$data->isi===null){
        $errors[]=[
            'id'=>'isi',
            'message'=>'soal masih kosong isi dong'
        ];
       }
       if($data->jawabanBenar===''||$data->jawabanBenar===null){
        $errors[]=[
            'id'=>'jawabanBenar',
            'message'=>'kunci jawaban belum ditentukan'
        ];
       }
       return $errors;
    }
   
    private function insertSoal($handler){
        $soal=$handler->data->isi;
        $jawaban=$handler->data->pilihanJawaban;
        $kunci=$handler->data->jawabanBenar;
        $jenis=$handler->data->jenis;
        $idSoalUtama=$handler->id;
        $idSoalIsi=uniqid('soalIsi');
        
        bankSoalIsi::create([
            'idSoalUtama'=>$idSoalUtama,
            'idSoalIsi'=>$idSoalIsi,
            'soal'=>$soal,
            'jenisSoal'=>$jenis
        ]);

        foreach ($jawaban as $value) {
            if($value->value!=''&& $value->value!=null){
                ($value->value===$kunci)?$key=1:$key=0;
                bankSoalJawaban::create([
                    'idSoalIsi'=>$idSoalIsi,
                    'pilihanJawaban'=>$value->value,
                    'jawabanBenar'=>$key
                ]);
            }
        }
        return $idSoalIsi;
    }
    private function editSoal($handler){
        $soal=$handler->data->isi;
        $jawaban=$handler->data->pilihanJawaban;
        $kunci=$handler->data->jawabanBenar;
        $jenis=$handler->data->jenis;
        $idSoalUtama=$handler->data->idSoalUtama;
        $idSoalIsi=$handler->data->idSoalIsi;
        // dd($jawaban);
        $soalOld=bankSoalIsi::where('idSoalISi',$handler->data->idSoalIsi)->get();
        if($soalOld->first()->soal!=$soal){
            bankSoalIsi::where('idSoalIsi',$handler->data->idSoalIsi)
            ->update(['soal'=>$soal]);
        }
        
        foreach ($jawaban as $value) {
            if($value->id==='new'){  
                if($value->value!=''){  
                    $key=0;
                    ($value->value===$kunci)?$key=1:$key=0;
                    bankSoalJawaban::create([
                        'idSoalIsi'=>$idSoalIsi,
                        'pilihanJawaban'=>$value->value,
                        'jawabanBenar'=>$key
                    ]);
                }
            }
            else{
                    if($value->value===''){
                        bankSoalJawaban::where('id',$value->id)->delete();
                    }
                    else{
                        $key=0;
                        ($value->value===$kunci)?$key=1:$key=0;
                        bankSoalJawaban::where('id',$value->id)->update([
                            'pilihanJawaban'=>$value->value,
                            'jawabanBenar'=>$key
                        ]);
                    }
    
            }
          
        }
        return $idSoalIsi;
    }

    private function deleteSoalMatching($idSoalIsi){
        bankSoalIsi::where('idSoalIsi',$idSoalIsi)->delete();
        bankSoalMatchingSoal::where('idSoalIsi',$idSoalIsi)->delete();
        bankSoalMatchingChoice::where('idSoalIsi',$idSoalIsi)->delete();
        if(Storage::exists(env('SOAL_IMG_PATH').$idSoalIsi.'.jpg')){
            Storage::delete(env('SOAL_IMG_PATH').$idSoalIsi.'.jpg');
        }
    }
    private function deleteSoalIsi($id,$id2){
        $deleteSoal=bankSoalIsi::where('idSoalUtama',$id2)
                                ->where('idSoalIsi',$id)
                                ->delete();
        $deleteChoice=bankSoalJawaban::where('idSoalIsi',$id)->delete();
        if(Storage::exists(env('SOAL_IMG_PATH').$id.'.jpg')){
            Storage::delete(env('SOAL_IMG_PATH').$id.'.jpg');
        }

    }
    public function ambilDataSoal($kode){
        $dataAll=[];
        $jenis=[];
        $data=[];
        $qtyMatchingMain=0;
        $qtyMatchingSub=[];
        $qtyMc=0;
        $qtyTf=0;
        $soalIsi=bankSoalIsi::where('idSoalUtama',$kode)->get();
        $ans=bankSoalJawaban::get();

        foreach ($soalIsi as $value) {

            switch ($value->jenisSoal) {
                case 3:
                    $soal=[];
                    $choice=[];
                    $im=0;
                    $qtyMatchingMain++;
                    $soalMatching=bankSoalMatchingSoal::where('idSoalIsi',$value->idSoalIsi)->get();
                    $soalMatchingChoice=bankSoalMatchingChoice::where('idSoalIsi',$value->idSoalIsi)->get();
                    foreach ($soalMatching as $m) {
                        $im++;
                        $soal[]=[
                            'id'=>$m->id,
                            'soal'=>$m->soal,
                            'kunci'=>$m->kunci
                        ];
                    }
                    $qtyMatchingSub[]=$im;
                    foreach ($soalMatchingChoice as $n) {
                        $choice[]=[
                            'id'=>$n->id,
                            'choice'=>$n->pilihanJawaban
                        ];
                    }
                    $data[]=[
                        'idSoalUtama'=>$value->idSoalUtama,
                        'idSoalIsi'=>$value->idSoalIsi,
                        'jenis'=>$value->jenisSoal,
                        'soalMain'=>$value->soal,
                        'soal'=>$soal,
                        'choice'=>$choice,
                        'fileStatus'=>$this->getSoalImgPath($value->idSoalIsi)['fileStatus'],
                        'filePath'=>$this->getSoalImgPath($value->idSoalIsi)['filePath']
                    ];
                    $jenis[]=$value->jenisSoal;
                    break;                    
                default:
                    $choice=[];
                    $key='';
                    if($value->jenisSoal===1){
                        $qtyMc++;
                    }elseif($value->jenisSoal===2){
                        $qtyTf++;
                    }
                    foreach ($ans as $valueAns) {
                        if($value->idSoalIsi===$valueAns->idSoalIsi){
                            $choice[]=[
                                'value'=>$valueAns->pilihanJawaban,
                                'id'=>$valueAns->id,
                            ];
                            if($valueAns->jawabanBenar===1){
                                $key=$valueAns->pilihanJawaban;
                            }
                        }
                    }
                    $data[]=[
                        'idSoalUtama'=>$value->idSoalUtama,
                        'idSoalIsi'=>$value->idSoalIsi,
                        'jenis'=>$value->jenisSoal,
                        'soal'=>$value->soal,
                        'choice'=>$choice,
                        'key'=>$key,
                        'fileStatus'=>$this->getSoalImgPath($value->idSoalIsi)['fileStatus'],
                        'filePath'=>$this->getSoalImgPath($value->idSoalIsi)['filePath']
                    ];
                    $jenis[]=$value->jenisSoal;
                    
                    break;
            }

            $jenis=array_unique($jenis);
        }
        $dataAll=[
            'data'=>$data,
            'jenis'=>$jenis,
            'qty'=>[
                'qtyMatching'=>$qtyMatchingMain,
                'qtySubMatching'=>$qtyMatchingSub,
                'qtyMc'=>$qtyMc,
                'qtyTf'=>$qtyTf,
                ]
        ];
        return $dataAll;
    }
    private function getSoalImgPath($id){
        $fileStatus=false;
        $filePath='';
        if(Storage::exists(env('SOAL_IMG_PATH').$id.'.jpg')){
            $fileStatus=true;
            $filePath=env('FILE_HOST').'imgQuestions?img='.$id.'.jpg';
        }
        return ['fileStatus'=>$fileStatus,'filePath'=>$filePath];
    }
    public function updatePesertaTaf($request){
        $data=json_decode($request->peserta);
        foreach ($data as $value) {
            if($value->newData && $value->delete){
                
            }elseif(!$value->newData && $value->delete){
                tafPeserta::where('idTaf',$request->idTaf)->where('nrp',$value->nrp)->delete();
            }elseif($value->newData && !$value->delete){
                tafPeserta::create([
                    'idTaf'=>$request->idTaf,
                    'nrp'=>$value->nrp
                ]);
            }elseif(!$value->newData && !$value->delete){
                
            }
        }
    }

    public function savePeserta($request){
        $peserta=json_decode($request->peserta);
        foreach ($peserta as $value) {
            tafPeserta::create([
                'idTaf'=>$request->idTaf,
                'nrp'=>$value->nrp
            ]);
        }
    }


    public function tafDataInput($request){
        $data=[
            'idTaf'=>$request->idTaf,
            'kodeTraining'=>$request->kodeTraining,
            'kodeUraianMateri'=>$request->uraianMateri,
            'lembaga'=>$request->lembaga,
            'startDate'=>$request->startDate,
            'endDate'=>$request->endDate,
            'lokasi'=>$request->lokasi,
            'biaya'=>$request->biaya,
            'pjo'=>$request->diajukan,
            'divisi'=>$request->disetujui,
            'dept'=>$request->diperiksa,
            'hr'=>$request->divHead,
            'createDate'=>$request->createDate,
            'to'=>$request->to,
            'from'=>$request->from,
            'subject'=>$request->subject,
            'jenisTaf'=>$request->jenisTaf
        ];
        return $data;
    }

    public function validatorTafMessage(){
        $data=[
            "createDate"=>"isi create datenya",
            "to"=>"Tujuannya kemana ?",
            "from"=>"Dari mana ?",
            "subject"=>"Tentang apa ?",
            "kodeTraining"=>"judul Training nya apa?",
            "uraianMateri"=>"Kalau mau dikosongi gunakan -",
            "lokasi"=>"Lokasi dimana ?",
            "lembaga"=>"Lembaganya siapa ?",
            "startDate"=>"Kapan Mulai trainingnya ?",
            "endDate"=>"Sampai kapan ?",
            "peserta"=>"Ini TAF Tidak ada pesertanya ya ?"
        ];

        return $data;
    }

    public function validatorTafList($request){
        $data=[
            "createDate"=>['Required'],
            "to"=>['Required'],
            "from"=>['Required'],
            "subject"=>['Required'],
            "kodeTraining"=>['Required'],
            "uraianMateri"=>['Required'],
            "lokasi"=>['Required'],
            "lembaga"=>['Required'],
            "startDate"=>['Required'],
            "endDate"=>['Required'],
            "peserta"=>[Rule::notIn(['[]'])]
        ];

        return $data;
    }

    public function getTafCode($request){
        $romawi=array('O','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
        $bulan=date_format(date_create($request->startDate),'n');
        $tahun=date_format(date_create($request->startDate),'Y');
        $a=tafData::dataTaf()->get();
        $i=0;
        $b=[];
        foreach ($a as $value) {
            $b[]=[date_format(date_create($value->startDate),'n'),
                date_format(date_create($value->startDate),'Y')];
        }
        foreach ($b as $value) {
            if($value[0]===$bulan && $value[1]===$tahun){
                $i++;
            }
        }
        if($i+1<100){
            if($i+1<10){
                $noTaf="00".$i+1;
            }else{
                $noTaf="0".$i+1;
            }
        }
        $data=$noTaf."/PPD-MACO/".$romawi[$bulan]."/".$tahun;
        return $data;
    }
    public function getManpowerAll(){
        $data=DB::table('manpowers')
                ->leftJoin('perusahaans','manpowers.perusahaan','=','perusahaans.id')
                ->select('manpowers.*','perusahaans.perusahaan','perusahaans.abrevation','perusahaans.id as idPerusahaan');

                return $data;
    }

    public function dataTraining($search){
        $data=training::dataTrainingAll()
                    ->where('kode_trainings.judul','like','%'.$search.'%')
                    ->orWhere('uraian_materis.uraianMateri','like','%'.$search.'%')
                    ->orWhere('lokasi_trainings.lokasiTraining','like','%'.$search.'%')
                    ->orWhere('lembaga_trainings.lembaga','like','%'.$search.'%')
                    ->orWhere('instructors.namaInstructor','like','%'.$search.'%')
                    ->orderBy('trainings.start','DESC')
                    ->paginate(10)
                    ->withQueryString();
        return $data;
    }

    public function fileDirectory($handler){
        if($handler==='absensi'){
            return env('FILE_ABSENSI_DIRECTORY');
        }else{
            return env('FILE_DOCUMENT_DIRECTORY');
        }
    }
    public function categoryLIst(){
        return [
            'PUBLIC',
            'IHT'
        ];
    }
    public function programTrainingList(){
        return[
            'PPD',
            'AMI',
            'OHS',
            'ID'
        ];
    }
    public function hardSoftList(){
        return [
            'HARD',
            'SOFT'
        ];
    }


    public function getDataManpowerTraining($id){
        $manpowerTraining=DB::table('manpowers')
        ->leftJoin('perusahaans','manpowers.perusahaan','=','perusahaans.id')
        ->join('training_pesertas','manpowers.nrp','=','training_pesertas.nrp')
        ->join('trainings','training_pesertas.idtr','=','trainings.idtr')
        ->join('kode_trainings','trainings.kodeTr','=','kode_trainings.kode')
        ->join('uraian_materis','trainings.uraianMateri','=','uraian_materis.id')
        ->join('instructors','trainings.instructor','=','instructors.id')
        ->join('lembaga_trainings','trainings.lembaga','=','lembaga_trainings.id')
        ->join('lokasi_trainings','trainings.lokasi','=','lokasi_trainings.id')
        ->select('manpowers.nrp',
        'manpowers.nama',
        'manpowers.jabatanFn',
        'manpowers.noMinePermit',
        'training_pesertas.pre',
        'training_pesertas.post',
        'training_pesertas.practice',
        'training_pesertas.result',
        'training_pesertas.remark',
        'manpowers.perusahaan as idPerusahaan',
        'perusahaans.perusahaan',
        'perusahaans.abrevation as perusahaanAbr',
        'trainings.kodeTr',
        'trainings.uraianMateri as kodeUraianMateri',
        'trainings.lokasi',
        'trainings.lembaga as kodeLembaga',
        'trainings.instructor',
        'trainings.remark as trainingRemark',
        'trainings.programTraining',
        'trainings.category',
        'trainings.hardSoft',
        'uraian_materis.uraianMateri',
        'kode_trainings.judul',
        'trainings.start',
        'trainings.end',
        'lokasi_trainings.lokasiTraining',
        'instructors.namaInstructor',
        'lembaga_trainings.lembaga',
        'trainings.idTr')
        ->where('trainings.idTr','=',$id)
        ->get();

        return $manpowerTraining;
    }

    public function validatorList($request){
        $idTr=[];
        foreach(training::all() as $a){
            $idTr[]=$a->idTr;
        }
        return[
            'idTr'=>[Rule::notIn($idTr)],
            'kodeTraining'=>['Required'],
            'uraianMateri'=>['Required'],
            'lokasi'=>['Required'],
            'lembaga'=>['Required'],
            'instructor'=>['Required'],
            // 'category'=>,
            // 'programTraining'=>,
            // 'hardSoft'=>,
            'startDate'=>['Required'],
            'endDate'=>['Required'],
            'peserta'=>[Rule::notIn(['[]'])]
            // 'remark'=>,
        ];
    }

    public function validatorListEdit($request){
        $idTr=[];
        $idTrOld=$request->idTrOld;
        foreach(training::all() as $a){
            if($a->idTr!=$idTrOld){
            $idTr[]=$a->idTr;
            }
        }
        return[
            'idTr'=>[Rule::notIn($idTr)],
            'kodeTraining'=>['Required'],
            'uraianMateri'=>['Required'],
            'lokasi'=>['Required'],
            'lembaga'=>['Required'],
            'instructor'=>['Required'],
            // 'category'=>,
            // 'programTraining'=>,
            // 'hardSoft'=>,
            'startDate'=>['Required'],
            'endDate'=>['Required'],
            'peserta'=>[Rule::notIn(['[]'])]
            // 'remark'=>,
        ];
    }

    public function validatorMessage(){
        return[
            'idTr'=>'Event training ini sudah ada di database',
             'kodeTraining'=>'Kode training tidak boleh kosong guys7',
             'uraianMateri'=>'Tidak boleh kosong',
             'lokasi'=>'Tidak boleh kosong',
             'lembaga'=>'Tidak boleh kosong',
             'instructor'=>'Tidak boleh kosong',
            //  'category'=>,
            //  'programTraining'=>,
            //  'hardSoft'=>,
             'startDate'=>'Start date harus diisi',
             'endDate'=>'End date harus diisi',
             // 'remark'=>,
        ];
    }

    public function dataTrainingInput($request){
       return[
            'idTr'=>$request->idTr,
            'kodeTr'=>$request->kodeTraining,
            'uraianMateri'=>$request->uraianMateri,
            'lokasi'=>$request->lokasi,
            'lembaga'=>$request->lembaga,
            'instructor'=>$request->instructor,
            'category'=>$request->category,
            'programTraining'=>$request->programTraining,
            'hardSoft'=>$request->hardSoft,
            'start'=>$request->startDate,
            'end'=>$request->endDate,
            'remark'=>$request->remark,
        ];
    }
    public function trainingPesertaInput($request){
       $data=$request->peserta;
       $data=json_decode($data);
       foreach ($data as $key) {
        if($key->newData){
                if(!$key->delete){
                    trainingPeserta::create($this->inputPeserta($key,$request->idTr));
                }
            }
        else{
            if($key->delete){
                trainingPeserta::where('idTr',$request->idTr)->where('nrp',$key->nrp)->delete();
            }else{
                // trainingPeserta::create($this->inputPeserta($key,$request->idTr));
            }
        }
       }
    }

    public function generateCodeTraining($request){
        $idTr=$request->instructor."_".$request->lembaga."_".floor(25570 +strtotime($request->startDate) / 86400).$request->kodeTraining;
        return $idTr;
    }

    public function inputPeserta($data,$idTr){
        ($data->preTest=="")? $pre=null:$pre=$data->preTest;
        ($data->postTest=="")? $post=null:$post=$data->postTest;
        ($data->practice=="")? $prac=null:$prac=$data->practice;
        return[
            'idTr'=>$idTr,
            'nrp'=>$data->nrp,
            'pre'=>$pre,
            'post'=>$post,
            'practice'=>$prac,
            'result'=>$data->result,
            'remark'=>$data->remark
        ];
    }

    public function saveFile($request,$idTr){
        $filePathAbsensi='public/document/training/absensiTraining';
        $filePathDokumen='public/document/training/dokumenTraining';
        if($request->hasFile('fileAbsensi')){
            $request->fileAbsensi->storeAs($filePathAbsensi,$idTr.".pdf");
        }

        if($request->hasFile('fileDokumenTraining')){
            $request->fileDokumenTraining->storeAs($filePathDokumen,$idTr.".pdf");
        }
    }

    public function fileStatus($request){
        $data=json_decode($request->fileStatus);
        if($data->absensi->delete){
            Storage::delete($this->fileDirectory('absensi').$request->idTrOld.'.pdf');
        }
        if($data->dokumen->delete){
            Storage::delete($this->fileDirectory('dokumen').$request->idTrOld.'.pdf');
        }
    }
}

