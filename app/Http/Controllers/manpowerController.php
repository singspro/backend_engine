<?php

namespace App\Http\Controllers;

use App\Models\ojiReport;
use App\Models\tafPeserta;
use App\Models\targetOji;
use App\Models\targetTraining;
use Illuminate\Http\Request;
use \App\Models\manpower;
use App\Models\trainingPeserta;
use App\Models\manpowerHistory;
use App\Models\training;
use App\Models\perusahaan;
use App\Models\section;
use App\Models\jobArea;
use App\Models\subSection;
use App\Models\jabatanStruktural;
use App\Models\jabatanFungsional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\File; 



class manpowerController extends Controller
{
  
    
    public function manpowerData(Request $request)
    {   
        
        if(Request('search')){
            $data=$this->getManpowerSearch($request->search);
        }else{
            $data=$this->getManpowerAll()->paginate(10);
        }
        return view('manpower-data',[
            'title'=>'manpower',
            'subTitle'=>'data',
            'dataMp'=>$data,
            'user'=>Auth::user()
           
        ]);
    }

    public function manpowerDetailData($slug)
    {     
                
         return view('manpower-detail',[
            'title'=>'manpower',
            'subTitle'=>'data',
            'mpDetail'=>$this->getManpowerAll()->where('nrp',$slug)->get(),
            'training'=>$this->getDataManpowerTraining($slug),
            'statusList'=>$this->statusList(),
            'tabBtn'=>['active','',''],
            'tab'=>['active show','',''],
            'foto'=>asset('storage/profileImage/'.$slug.".jpg"),
            'errorImage'=>'assets/img/blankProfileImage.jpg',
            'fotoBlank'=>'assets/img/blankProfileImage.jpg',
            'error'=>false,
            'success'=>false,
            'listPerusahaan'=>perusahaan::all(),
            'listSection'=>section::all(),
            'listJobArea'=>jobArea::all(),
            'listSubSection'=>subSection::all(),
            'listStruktural'=>jabatanStruktural::all(),
            'listFungsional'=>jabatanFungsional::all(),
            'user'=>Auth::user()
        ]);
    }

    public function manpowerDetailDataError($slug)
    {    

        return view('manpower-detail',[
            'title'=>'manpower',
            'subTitle'=>'data',
            'mpDetail'=>$this->getManpowerAll()->where('nrp',$slug)->get(),
            'statusList'=>$this->statusList(),
            'tabBtn'=>['','','active'],
            'tab'=>['','','active show'],
            'foto'=>asset('storage/profileImage/'.$slug.".jpg"),
            'training'=>$this->getDataManpowerTraining($slug),
            'errorImage'=>'assets/img/blankProfileImage.jpg',
            'error'=>true,
            'success'=>false,
            'listPerusahaan'=>perusahaan::all(),
            'listSection'=>section::all(),
            'listJobArea'=>jobArea::all(),
            'listSubSection'=>subSection::all(),
            'listStruktural'=>jabatanStruktural::all(),
            'listFungsional'=>jabatanFungsional::all(),
            'user'=>Auth::user()
        ]);
    }

    public function manpowerDetailDataSuccess($slug)
    {    

        return view('manpower-detail',[
            'title'=>'manpower',
            'subTitle'=>'data',
            'mpDetail'=>$this->getManpowerAll()->where('nrp',$slug)->get(),
            'statusList'=>$this->statusList(),
            'training'=>$this->getDataManpowerTraining($slug),
            'tabBtn'=>['active','',''],
            'tab'=>['active show','',''],
            'foto'=>asset('storage/profileImage/'.$slug.".jpg"),
            'errorImage'=>'assets/img/blankProfileImage.jpg',
            'error'=>false,
            'success'=>true,
            'listPerusahaan'=>perusahaan::all(),
            'listSection'=>section::all(),
            'listJobArea'=>jobArea::all(),
            'listSubSection'=>subSection::all(),
            'listStruktural'=>jabatanStruktural::all(),
            'listFungsional'=>jabatanFungsional::all(),
            'user'=>Auth::user()
        ]);
    }

    public function manpowerDetailDelete(Request $request)
    {
        $key=$request->query('ngok');
        manpower::where('nrp',$key)->delete();
        Storage::delete(env('PROFILE_IMAGE_DIRECTORY').$key.'.jpg');
        return redirect()->action([$this::class,'manpowerData']);
    }

    public function manpowerNew()
    {
        return view('manpower-new',[
            'title'=>'manpower',
            'subTitle'=>'new',
            'foto'=>'assets/img/blankProfileImage.jpg',
            'statusList'=>$this->statusList(),
            'listPerusahaan'=>perusahaan::all(),
            'listSection'=>section::all(),
            'listJobArea'=>jobArea::all(),
            'listSubSection'=>subSection::all(),
            'listStruktural'=>jabatanStruktural::all(),
            'listFungsional'=>jabatanFungsional::all(),
            'listManpower'=>manpower::all(),
            'user'=>Auth::user()
        ]);
    }

    public function mpNewSave(Request $request)
    {
         $manpower=manpower::all();
        $validator=Validator::make($request->all(),$this->validatorList($manpower,$request),$this->messageValidator($request));
        if ($validator->fails()){
             return redirect('/new-mp')
                        ->withErrors($validator)
                        ->withInput();          
        }
        manpower::create($this->ruleSetData($request)); //masukkan ke database
        if($request->hasFile('file'))
        {
           $request->file->storeAs(env('PROFILE_IMAGE_DIRECTORY'),$request->nrp.".jpg");
        }
        return redirect('/detail'.$request->nrp);

    }


    public function updateMpSave(Request $request)
    {
        $manpower=manpower::all();
        $manpower=$manpower->diff(manpower::whereIn('nrp',[$request->oldNrp])->get());
        $validator=Validator::make($request->all(),$this->validatorList($manpower,$request),$this->messageValidator($request));
        if ($validator->fails()){
            // dd($validator);
                 return redirect()
                        ->action([$this::class,'manpowerDetailDataError'],['slug'=>$request->oldNrp])
                        ->withErrors($validator)
                        ->withInput();          
        }

        manpowerHistory::create($this->ruleSetDataHistoryManpower($request->oldNrp)); //masukkan ke history
        manpower::where('nrp',$request->oldNrp)->update($this->ruleSetData($request)); //masukkan ke databse
        if($request->oldNrp!=$request->nrp){

            DB::table('target_ojis')
                ->selectRaw("REPLACE(idOji,'".$request->oldNrp."','".$request->nrp."')")
                ->where('nrp',$request->oldNrp);
            DB::table('oji_reports')
                ->selectRaw("REPLACE(idOji,'".$request->oldNrp."','".$request->nrp."')")
                ->where('nrp',$request->oldNrp);
            targetOji::where('nrp',$request->oldNrp)->update(['nrp'=>$request->nrp]);
            ojiReport::where('nrp',$request->oldNrp)->update(['nrp'=>$request->nrp]);
            trainingPeserta::where('nrp',$request->oldNrp)->update(['nrp'=>$request->nrp]);
            tafPeserta::where('nrp',$request->oldNrp)->update(['nrp'=>$request->nrp]);
            targetTraining::where('nrp',$request->oldNrp)->update(['nrp'=>$request->nrp]);

            if ($request->kunam=='1')
            {
                Storage::delete(env('PROFILE_IMAGE_DIRECTORY').'/'.$request->oldNrp.'.jpg');
            }
            elseif ($request->hasFile('file'))
            {   
                Storage::delete(env('PROFILE_IMAGE_DIRECTORY').'/'.$request->oldNrp.'.jpg');
                $request->file->storeAs(env('PROFILE_IMAGE_DIRECTORY'),$request->nrp.".jpg");
            }
            else
            {
                
                $test=Storage::move(env('PROFILE_IMAGE_DIRECTORY').'/'.$request->oldNrp.'.jpg', env('PROFILE_IMAGE_DIRECTORY').'/'.$request->nrp.'.jpg');
            }
        }
        else{
            if ($request->kunam=='1')
            {
                Storage::delete(env('PROFILE_IMAGE_DIRECTORY').'/'.$request->oldNrp.'.jpg');
            }
            elseif ($request->hasFile('file'))
            {   
                $request->file->storeAs(env('PROFILE_IMAGE_DIRECTORY'),$request->nrp.".jpg");
            }
        }
        
        return redirect()->action([$this::class,'manpowerDetailDataSuccess'],['slug'=>$request->nrp]);

    }


    // RULE LIST callback function------------------------------------------------------------------------------------
    public function getManpowerAll(){
        $data=DB::table('manpowers')
                ->leftJoin('perusahaans','manpowers.perusahaan','=','perusahaans.id')
                ->select('manpowers.*','perusahaans.perusahaan','perusahaans.abrevation','perusahaans.id as idPerusahaan')
                ->orderBy('manpowers.updated_at','desc');

                return $data;
    }
    public function getManpowerSearch($search){
        $data=DB::table('manpowers')
                ->leftJoin('perusahaans','manpowers.perusahaan','=','perusahaans.id')
                ->select('manpowers.*','perusahaans.perusahaan','perusahaans.abrevation')
                ->where('manpowers.nama','like','%'.$search.'%')
                ->orWhere('manpowers.nrp','like','%'.$search.'%')
                ->orWhere('manpowers.remark','like','%'.$search.'%')
                ->orderBy('manpowers.updated_at','desc')
                ->paginate(10)
                ->withQueryString();

                return $data;
    }

    public function getDataManpowerTraining($slug){
        $manpowerTraining=DB::table('manpowers')
        ->join('training_pesertas','manpowers.nrp','=','training_pesertas.nrp')
        ->join('trainings','training_pesertas.idtr','=','trainings.idtr')
        ->join('kode_trainings','trainings.kodeTr','=','kode_trainings.kode')
        ->join('uraian_materis','trainings.uraianMateri','=','uraian_materis.id')
        ->join('instructors','trainings.instructor','=','instructors.id')
        ->join('lembaga_trainings','trainings.lembaga','=','lembaga_trainings.id')
        ->select('manpowers.nrp','trainings.kodeTr','uraian_materis.uraianMateri','kode_trainings.judul','trainings.start','instructors.namaInstructor','lembaga_trainings.lembaga','trainings.idTr')
        ->where('manpowers.nrp','=',$slug)
        ->get();

        return $manpowerTraining;
    }

    public function ruleSetData($request)
    {
        return [
            'about'=>is_null($request->about)? "-" : $request->about,
            'nrp'=>$request->nrp,
            'noMinePermit'=>strtoupper(is_null($request->noMp)? "-" : $request->noMp),
            'nama'=>strtoupper($request->fullName),
            'perusahaan'=>$request->pers,
            'jobArea'=>is_null($request->jArea)? "-":$request->jArea,
            'section'=>is_null($request->sect)? "-":$request->sect,
            'subSection'=>is_null($request->ssect)? "-":$request->ssect,
            'jabatanStr'=>is_null($request->jbtStr)?"-":$request->jbtStr,
            'jabatanFn'=>is_null($request->jbtFn)?"-":$request->jbtFn,
            'spesialis'=>is_null($request->spcl)?"-":$request->spcl,
            'grade'=>is_null($request->grade)?"-":$request->grade,
            'jointDate'=>is_null($request->jntDt)?now():$request->jntDt,
            'jointToMaco'=>is_null($request->jntMaco)?now():$request->jntMaco,
            'tempatLahir'=>is_null($request->tmpLhr)?"-":$request->tmpLhr,
            'tanggalLahir'=>$request->tglLhr,
            'noTelp1'=>is_null($request->phn1)?"-":$request->phn1,
            'noTelp2'=>is_null($request->phn2)?"-":$request->phn2,
            'email'=>is_null($request->email)?"-":$request->email,
            'status'=>is_null($request->sts)?"AKTIF":$request->sts,
            'remark'=>is_null($request->rmk)?"-":$request->rmk,
            'NotActiveStatus'=>$request->tglNonActive
        ];
    }

    public function ruleSetDataHistoryManpower($oldNrp)
    {
        $request=manpower::where('nrp',$oldNrp)->get();
        $request=$request->first();
        return [
            'idMp'=>$request->id,
            'about'=>is_null($request->about)? "-" : $request->about,
            'nrp'=>$request->nrp,
            'noMinePermit'=>strtoupper(is_null($request->noMinePermit)? "-" : $request->noMinePermit),
            'nama'=>strtoupper($request->nama),
            'perusahaan'=>$request->perusahaan,
            'jobArea'=>is_null($request->jobArea)? "-":$request->jobArea,
            'section'=>is_null($request->section)? "-":$request->section,
            'subSection'=>is_null($request->subSection)? "-":$request->subSection,
            'jabatanStr'=>is_null($request->jabatanStr)?"-":$request->jabatanStr,
            'jabatanFn'=>is_null($request->jabatanFn)?"-":$request->jabatanFn,
            'spesialis'=>is_null($request->spesialis)?"-":$request->spesialis,
            'grade'=>is_null($request->grade)?"-":$request->grade,
            'jointDate'=>is_null($request->jointDate)?now():$request->jointDate,
            'jointToMaco'=>is_null($request->jointToMaco)?now():$request->jointToMaco,
            'tempatLahir'=>is_null($request->tempatLahir)?"-":$request->tempatLahir,
            'tanggalLahir'=>$request->tanggalLahir,
            'noTelp1'=>is_null($request->noTelp1)?"-":$request->noTelp1,
            'noTelp2'=>is_null($request->noTelp2)?"-":$request->noTelp2,
            'email'=>is_null($request->email)?"-":$request->email,
            'status'=>is_null($request->status)?"AKTIF":$request->status,
            'remark'=>is_null($request->remark)?"-":$request->remark,
            'NotActiveStatus'=>$request->NotActiveStatus
        ];
    }

    public function validatorList($manpower,$request)
    {
        foreach ($manpower as $value) {$listNrp[]=$value->nrp;}
        foreach(perusahaan::all() as $a){$listPerusahaan[]=$a->id;}
        foreach(section::all() as $b){$listSection[]=$b->section;}
        foreach(jobArea::all() as $c){$listJobArea[]=$c->jobArea;}
        foreach(subSection::all() as $d){$listSubSection[]=$d->subSection;}
        foreach(jabatanStruktural::all() as $e){$listStruktural[]=$e->jabatanStruktural;}
        foreach(jabatanFungsional::all() as $f){$listFungsional[]=$f->jabatanFungsional;}

        array_push($listStruktural,"");
        array_push($listFungsional,"");
        array_push($listSubSection,"");
        array_push($listSection,"");
        array_push($listJobArea,"");

        $rule= [
        "fullName"=>['Required'],
        // "about" => [''],
        "nrp" => ['Required',Rule::notIn($listNrp)],
        // "noMp" => [''],
        "pers" => ['Required',Rule::in($listPerusahaan)],
        "sect" => [RUle::in($listSection)],
        "jArea" =>[Rule::in($listJobArea)],
        "ssect" => [Rule::in($listSubSection)],
        "jbtStr" => [Rule::in($listStruktural)],
        "jbtFn" => [Rule::in($listFungsional)],
        // "grade" => null
        // "spcl" => null
        // "jntDt" => null
        // "tmpLhr" => null
        // "tglLhr" => null
        // "phn1" => null
        // "phn2" => null
        // "email" => ['email:rfc,dns'],
        // "sts" => "AKTIF"
        // "rmk" => null
        "file"=>[File::types(['jpg','JPG'])]
        ];

        if($request->sts!='AKTIF'){
            $rule['tglNonActive']=['Required'];
        }

        return $rule;
    }

    public function messageValidator($request)
    {
        $message=[
            // 'fullName'=>':attribute tidak sesuai List'
            "fullName"=>"Nama lengkap tidak boleh kosong..",
            // "about" => [''],
            // 'nrp'=>"NRP tidak boleh kosong..",
            'nrp.required'=>'NRP tidak boleh kosong..',
            'nrp.not_in'=>'Data duplicate, data dengan :attribute ini sudah ada..',
            // "noMp" => [''],
            "pers.required" => "Perusahaan tidak boleh kosong",
            "pers.in"=>"Isi perusahaan sesuai dengan List",
            "sect" => "Pengisian tidak sesuai list, atau mending dikosongi",
            "jArea" => "Pengisian tidak sesuai list, atau mending dikosongi",
            "ssect" => "Pengisian tidak sesuai list, atau mending dikosongi",
            "jbtStr" => "Pengisian tidak sesuai list, atau mending dikosongi",
            "jbtFn" => "Pengisian tidak sesuai list, atau mending dikosongi",
            // "grade" => null
            // "spcl" => null
            // "jntDt" => null
            // "tmpLhr" => null
            // "tglLhr" => null
            // "phn1" => null
            // "phn2" => null
            "email" => "Email tidak valid",
            // "sts" => "AKTIF"
            // "rmk" => null
            "file"=>"Format foto salah brow.., format file harus JPG"
            
        ];

        if ($request->sts!="AKTIF"){
            $message['tglNonActive']="Harus diisi";
        }

        return $message;
    }

    public function statusList()
    {
     return [
         'AKTIF',
         'RESIGN',
         'PHK',
         'MUTASI',
         'TERMINASI',
         'PUTUS KONTRAK',
         'UNFIT'
     ];
    }

}
