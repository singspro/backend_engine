<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\manpower;
use App\Models\instructor;
use App\Models\targetOji;
use App\Models\kodeKompetensi;
use App\Models\ojiReport;
use Illuminate\Support\Facades\Storage;

class mentorController extends Controller
{
    public function mentorNew(Request $request){
        $a=explode(",",env('JENIS_MENTOR'));
        $jenis=[];
        foreach ($a as $key => $value) {
            $jenis[]=$value;
        }
        return view('mentor-new',[
            'title'=>'mentor',
            'subTitle'=>'new',
            'manpowerData'=>manpower::manpowerAll()->where('status','AKTIF')->get(),
            'jenis'=>$jenis,
            'user'=>Auth::user()
        ]);
    }

    public function targetOjiOpen(Request $request){
        return response()->json(array(
            'status'=>true,
            'data'=>$this->targetOjiOpenByNrp($request->nrp)
        ),200);
    }

    public function listCodeCompetensi(){
        return response()->json(array(
            'status'=>true,
            'code'=>kodeKompetensi::all(),
            'instructor'=>instructor::all()
        ),200);
    }

     public function mentorData(){
        if(Request('search')){
            $data=$this->dataOji(Request('search'));
        }else{
            $data=ojiReport::dataOjiAll()->orderBy('startDate','DESC')->paginate(10);
        }
        return view('mentor-data',[
            'title'=>'mentor',
            'subTitle'=>'data',
            'dataOji'=>$data,
            'user'=>Auth::user()
        ]);
    }

    public function saveAllMentor(Request $request){   
         
        $idOji=$this->saveNewMentor($request);
        $this->saveAbsensi($request,$idOji);

        return response()->json(array(
            'success'=>true
        ),200);
    }

    public function mentorDetail(Request $request){

        $data=$this->dataOjiById($request->id);
        return response()->json([
            'success'=>true,
            'data'=>$data->first(),
            'file'=>Storage::exists($this->filePathAbsensiOji().$request->id.'.pdf')
        ],200);
        
    }

    public function downloadabsensi(Request $request){

        return Storage::download($this->filePathAbsensiOji().$request->id.'.pdf');
    }
    
    public function dataEditOji(Request $request){
        $dataOjiById=$this->dataOjiById($request->idOji);
        $data=explode('_',$request->idOji);
        $a=explode(",",env('JENIS_MENTOR'));
        $jenis=[];
        foreach ($a as $key => $value) {
            $jenis[]=$value;
        }
        return response()->json([
            'success'=>true,
            'manpower'=>manpower::all(),
            'targetOji'=>$this->targetOjiOpenByNrp($data[0]),
            'kodeKompetensi'=>kodeKompetensi::all(),
            'instructor'=>instructor::all(),
            'jenis'=>$jenis,
            'dataOjiByID'=>$dataOjiById->first(),
            'file'=>Storage::exists($this->filePathAbsensiOji().$request->idOji.'.pdf')
        ],200);
    }

    public function dataEditOjiSave(Request $request){
        $this->updateOjiReport($request);
        $this->updateOjiFile($request);
        return response()->json([
            'success'=>true,

        ],200);
    }

    public function deleteMentor(Request $request){
        $this->deleteDataMentor($request);
        $this->deleteMentorFile($request);
        return response()->json([
            'success'=>true
        ],200);
    }

    //function callback---------------------------------------------

    public function deleteDataMentor($request){
        ojiReport::where('idOji',$request->idOji)->delete();
    }

    public function deletementorFile($request){
        if(Storage::exists($this->filePathAbsensiOji().$request->idOji.'.pdf')){
            Storage::delete($this->filePathAbsensiOji().$request->idOji.'.pdf');
        }
    }
    public function updateOjiReport($request){
        ojiReport::where('idOji',$request->idOjiOld)->update($this->dataOjiUpdate($request));
    }
    public function updateOjiFile($request){
        $tahun=date_format(date_create($request->startDateEdit),"Y");
        $idOji=$request->namaEdit."_".$request->materiEdit."_".$tahun;
        if($idOji!=$request->idOjiOld){
            if(Storage::exists($this->filePathAbsensiOji().$request->idOjiOld.'.pdf')){
                Storage::move($this->filePathAbsensiOji().$request->idOjiOld.'.pdf',$this->filePathAbsensiOji().$idOji.'.pdf');
            }
        }

        if($request->delete==='true'){
            Storage::delete($this->filePathAbsensiOji().$request->idOjiOld.'.pdf');
            dd($request->delete);
        }

        if($request->hasFile('fileAbsensi')){
            $request->fileAbsensi->storeAs($this->filePathAbsensiOji(),$idOji.".pdf");
        }


    }

    public function dataOjiUpdate($request){
        $tahun=date_format(date_create($request->startDateEdit),"Y");
        $idOji=$request->namaEdit."_".$request->materiEdit."_".$tahun;
        return [
            'idOji'=>$idOji,
            'nrp'=>$request->namaEdit,
            'kodeKompetensi'=>$request->materiEdit,
            'startDate'=>$request->startDateEdit,
            'endDate'=>$request->endDateEdit,
            'startTime'=>$request->startTimeEdit,
            'endTime'=>$request->endTimeEdit,
            'instructor'=>$request->instructorEdit,
            'jenisOji'=>$request->jenisEdit,
            'remark'=>$request->remarkEdit
        ];
    }
    public function dataOjiById($request){

        $dataOji=ojiReport::dataOjiAll()
                ->where('oji_reports.idOji','=',$request)
                ->get();

        return $dataOji;

    }
    public function dataOji($request){
        $dataOji=ojiReport::dataOjiAll()
                ->where('manpowers.nama','like','%'.$request.'%')
                ->orWhere('oji_reports.kodeKompetensi','like','%'.$request.'%')
                ->orWhere('instructors.namaInstructor','like','%'.$request.'%')
                ->orderBy('startDate','DESC')
                ->paginate(10)->withQueryString();
        return $dataOji;
    }



    public function filePathAbsensiOji(){
        $filePathAbsensi='public/document/mentor/absensi/';
        return $filePathAbsensi;
    }
    public function saveAbsensi($request,$idOji){
        
        if($request->hasFile('file')){
            $request->file->storeAs($this->filePathAbsensiOji(),$idOji.".pdf");
        }
    }

    public function saveNewMentor($request){
        $nama=explode("||",$request->nameSelected);
        $materi=explode("||",$request->materi);
        $instructor=explode("||",$request->instructor);
        $tahun=date_format(date_create($request->startDate),"Y");
        $idOji=$nama[0]."_".$materi[0]."_".$tahun;
        ojiReport::create([
            'idOji'=>$idOji,
            'nrp'=>$nama[0],
            'kodeKompetensi'=>$materi[0],
            'startDate'=>$request->startDate,
            'endDate'=>$request->endDate,
            'startTime'=>$request->startTime,
            'endTime'=>$request->endTime,
            'instructor'=>$instructor[0],
            'jenisOji'=>$request->jenis,
            'remark'=>$request->remark
        ]);

        return $idOji;
    }

    public function targetOjiOpenByNrp($nrp){

        $targetOpen=DB::table('target_ojis')
                            ->leftJoin('oji_reports','target_ojis.idOji','=','oji_reports.idOji')
                            ->join('kode_kompetensis','target_ojis.kodeKompetensi','=','kode_kompetensis.kode')
                            ->select('target_ojis.nrp',
                            'kode_kompetensis.namaKompetensi',
                            'target_ojis.kodeKompetensi',
                            'oji_reports.idOji',
                            'target_ojis.jenisOji')
                            ->where('oji_reports.idOji','=',null)
                            ->where('target_ojis.nrp','=',$nrp)
                            ->where('target_ojis.tahun','=',env('TARGET_KPI'))
                            ->get();

        return $targetOpen;

    }

}
