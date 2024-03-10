<?php

namespace App\Http\Controllers;

use App\Models\manpower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function getDataGuys(Request $request){
        $ss=[];
        switch ($request->data) {
            case 'levelMechanicAllChart':
                $ss=$this->mechanicGradeData();
                break;
            case 'spclComposition':
                $ss=$this->mechanicSpclData();
                break;
            case 'compReadiness':
                $comp=new readinessKompetensiController();
                $qtyComp=$comp->getQtyReadinessLocale();
                $ss=$this->hitungAllProsentase($qtyComp);
                break;
            case 'getAllReadiness':
                $comp=new readinessKompetensiController();
                $tr=new trainingReadinessController();
                $qtyComp=$comp->getQtyReadinessLocale();
                $qtyTr=$tr->readinessAll();
                $comp=$this->hitungAllProsentase($qtyComp);
                $tr=$this->hitungAllProsentase($qtyTr);
                $ss=
                [
                  'comp'=>$comp,
                   'tr'=>$tr,
                   'mR'=>round(($comp['closePer']+$tr['closePer'])/2,2),
                ];
                break;
            default:
                # code...
                break;
        }
        return response()->json([
            'status'=>'ok',
            'data'=>$ss,
        ],200);
    }
    public function dashboard(){
        return view('index',[
            'title'=>'dashboard',
            'subTitle'=>'dashboard',
            'qtyMechanic'=>$this->countManpower('MECHANIC','AKTIF',1,'PLANT'),
            'qtyTireman'=>$this->countManpower('FIELD SUPPORT','AKTIF',1,'PLANT'),
            'qtyGroupLeader'=>$this->countManpower('GROUP LEADER','AKTIF',1,'PLANT'),
            'qtyLabourSupply'=>$this->countManpowerLs('AKTIF',9,'PLANT'),
            'user'=>Auth::user()
        ]);
    }

    public function listManpowerStatistic(Request $request){
        if($request->j==="LABOUR SUPPLY"){
            $data=manpower::manpowerAll()
                    ->select('manpowers.*')
                    ->where('manpowers.perusahaan','!=',1)
                    ->where('manpowers.section','=','PLANT')
                    ->where('manpowers.status','=','AKTIF')
                    ->where('manpowers.jobArea','=',$request->ngok)
                    // ->where('manpowers.jabatanStr','=',$request->j)
                    ->where('manpowers.subSection','=',$request->s)
                    ->orderBy('manpowers.jabatanFn','ASC')
                    ->orderBy('manpowers.grade','ASC')
                    ->paginate(15)->withQueryString();

        }
        else{
            $data=manpower::manpowerAll()
                    ->select('manpowers.*')
                    ->where('manpowers.perusahaan','=',1)
                    ->where('manpowers.section','=','PLANT')
                    ->where('manpowers.status','=','AKTIF')
                    ->where('manpowers.jobArea','=',$request->ngok)
                    ->where('manpowers.jabatanStr','=',$request->j)
                    ->where('manpowers.subSection','=',$request->s)
                    ->orderBy('manpowers.jabatanFn','ASC')
                    ->orderBy('manpowers.grade','ASC')
                    ->paginate(15)->withQueryString();
        }
        return view('manpower-statistic',[
            'title'=>'dashboard',
            'subTitle'=>'dashboard',
            'user'=>Auth::user(),
            'data'=>$data
        ]);
    }

    public function mechanicData(Request $request){
        if($request->mode==='LABOUR SUPPLY'){

            $manpower=new manpowerStatistikLs();
        }
        else{

            $manpower=new manpowerStatistikSis();
        }
        $manpower->getMPStatistic($request->mode);
        return view('manpower-resume',[
            'title'=>'dashboard',
            'subTitle'=>'dashboard',
            'user'=>Auth::user(),
            'data'=>$manpower->qtyManpower,
            'subData'=>""
        ]);
    }

//-------------------------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------------------------//
private function hitungAllProsentase($d){
    $open=0;
    $close=0;
    foreach ($d as $vD) {
        $open=$open+$vD['open'];
        $close=$close+$vD['close'];
    }

    return [
        'open'=>$open,
        'close'=>$close,
        'openPer'=>($open+$close===0)? 0 : round($open/($open+$close)*100,2),
        'closePer'=>($open+$close===0)? 0 : round($close/($open+$close)*100,2),
    ];
}
private function mechanicSpclData(){
    $hasil=[];
    $spesialis=[];
    $jumlah=[];
    $data=manpower::manpowerAll()->where('status','AKTIF') 
                                ->where('manpowers.perusahaan',1)
                                ->where('jabatanStr','MECHANIC')
                                ->where('spesialis','!=','-')
                                ->where('spesialis','!=','')
                                ->get();
    foreach ($data as $vData) {
        $spcls[]=$vData->spesialis;
    }
    $spcls=array_unique($spcls);

    foreach ($spcls as $vSpcls) {
        $cc=0;
        foreach ($data as $vData) {
            if($vSpcls===$vData->spesialis){
                $cc++;
            }
        }
        
            $spesialis[]=$vSpcls;
            $jumlah[]=$cc;
    }
    
    array_multisort($jumlah,SORT_DESC,$spesialis,SORT_ASC);
    foreach ($jumlah as $key => $vJumlah) {
        $hasil[]=[
            'spcl'=>$spesialis[$key],
            'jmlh'=>$vJumlah
        ];
    }
    return $hasil;
    
}
private function mechanicGradeData(){
    $grade=['L1','L2','L3','L4','L5','L6','L7','L8','L9','L10'];
    $hasil=[];
    $data=manpower::manpowerAll()->where('status','AKTIF') 
                                ->where('manpowers.perusahaan',1)
                                ->where('jabatanStr','MECHANIC')
                                ->where('spesialis','!=','-')
                                ->where('spesialis','!=','')
                                ->get();
    foreach ($grade as $vg) {
        $cc=0;
        foreach ($data as $vData) {
            if($vg===$vData->grade){
                $cc++;
            }
        }
        $hasil[]=[
            'grade'=>$vg,
            'jumlah'=>$cc
        ];
    }
    return $hasil;
}
public function countManpower($jabatanStr, $status, $perusahaan,$section){
    $data=manpower::where('jabatanStr',$jabatanStr)
                    ->where('status',$status)
                    ->where('section',$section)
                    ->where('perusahaan',$perusahaan)
                    ->whereNotIn ('subSection',['-',''])
                    ->count();
                    return $data;
}
public function countManpowerLs( $status, $perusahaan,$section){
    $data=manpower::where('status',$status)
                    ->where('section',$section)
                    ->where('perusahaan',$perusahaan)
                    ->whereNotIn ('jabatanFn',['-',''])
                    ->count();
                    return $data;
}
}

class manpowerStatistikSis {
    public $jabatan;
    public $jobArea;
    public $subSection;

    public $qtyManpower;

    public function getJobArea(){
        $data=manpower::manpowerAll()
                ->where('manpowers.perusahaan','=',1)
                ->where('manpowers.section','=','PLANT')
                ->where('manpowers.jobArea','!=','-')
                ->where('manpowers.jobArea','!=','') 
                ->select('manpowers.jobArea')
                ->distinct()
                ->get();
        $this->jobArea=$data;
        return $this->jobArea;
    }
    public function getsubSection($jabatan){
        $data=manpower::manpowerAll()
                ->where('manpowers.perusahaan','=',1)
                ->where('manpowers.section','=','PLANT')
                ->where('manpowers.jobArea','!=','-')
                ->where('manpowers.jabatanStr','=',$jabatan)
                ->where('manpowers.jobArea','!=','') 
                ->select('manpowers.jobArea','manpowers.subSection')
                ->distinct()
                ->get();
        $this->subSection=$data;
        return $this->subSection;
    }

    public function getManpowerJobArea($jabatan){
        foreach ($this->getJobArea() as $value) {
            $data=manpower::manpowerAll()
                        ->where('manpowers.perusahaan','=',1)
                        ->where('manpowers.section','=','PLANT')
                        ->where('manpowers.status','=','AKTIF')
                        ->where('manpowers.subSection','!=','-')
                        ->where('manpowers.subSection','!=','')
                        ->where('manpowers.jabatanStr','=',$jabatan)
                        ->where('manpowers.jobArea','=',$value->jobArea)
                        ->count();
            $this->qtyManpower["JobAreaQty"][]=[  "area"=>$value->jobArea,
                                    "data"=>$data
                                ];
        }
    }

    public function getManpowerSubSection($jabatan){
            foreach ($this->getsubSection($jabatan) as $value) {
                $data=manpower::manpowerAll()
                        ->where('manpowers.perusahaan','=',1)
                        ->where('manpowers.section','=','PLANT')
                        ->where('manpowers.status','=','AKTIF')
                        ->where('manpowers.subSection','!=','-')
                        ->where('manpowers.subSection','!=','')
                        ->where('manpowers.jobArea','=',$value->jobArea)
                        ->where('manpowers.jabatanStr','=',$jabatan)
                        ->where('manpowers.subSection','=',$value->subSection)
                        ->count();
                $this->qtyManpower["subSectionQty"][]=[
                "area"=>$value->jobArea,
                "subSection"=>$value->subSection,
                "data"=>$data
                ];
            }

    }


    public function getMPStatistic($jabatan){
        $this->getManpowerJobArea($jabatan);
        $this->getManpowerSubSection($jabatan);
    }

}

class manpowerStatistikLs {
    public $jabatan;
    public $jobArea;
    public $subSection;

    public $qtyManpower;

    public function getJobArea(){
        $data=manpower::manpowerAll()
                ->where('manpowers.perusahaan','!=',1)
                ->where('manpowers.section','=','PLANT')
                ->where('manpowers.jobArea','!=','-')
                ->where('manpowers.jobArea','!=','') 
                ->select('manpowers.jobArea')
                ->distinct()
                ->get();
        $this->jobArea=$data;
        return $this->jobArea;
    }
    public function getsubSection($jabatan){
        $data=manpower::manpowerAll()
                ->where('manpowers.perusahaan','!=',1)
                ->where('manpowers.section','=','PLANT')
                ->where('manpowers.jobArea','!=','-')
                // ->where('manpowers.jabatanStr','=',$jabatan)
                ->where('manpowers.jobArea','!=','') 
                ->select('manpowers.jobArea','manpowers.subSection')
                ->distinct()
                ->get();
        $this->subSection=$data;
        return $this->subSection;
    }

    public function getManpowerJobArea($jabatan){
        foreach ($this->getJobArea() as $value) {
            $data=manpower::manpowerAll()
                        ->where('manpowers.perusahaan','!=',1)
                        ->where('manpowers.section','=','PLANT')
                        ->where('manpowers.status','=','AKTIF')
                        ->where('manpowers.subSection','!=','-')
                        ->where('manpowers.subSection','!=','')
                        // ->where('manpowers.jabatanStr','=',$jabatan)
                        ->where('manpowers.jobArea','=',$value->jobArea)
                        ->count();
            $this->qtyManpower["JobAreaQty"][]=[  "area"=>$value->jobArea,
                                    "data"=>$data
                                ];
        }
    }

    public function getManpowerSubSection($jabatan){
            foreach ($this->getsubSection($jabatan) as $value) {
                $data=manpower::manpowerAll()
                        ->where('manpowers.perusahaan','!=',1)
                        ->where('manpowers.section','=','PLANT')
                        ->where('manpowers.status','=','AKTIF')
                        ->where('manpowers.subSection','!=','-')
                        ->where('manpowers.subSection','!=','')
                        ->where('manpowers.jobArea','=',$value->jobArea)
                        // ->where('manpowers.jabatanStr','=',$jabatan)
                        ->where('manpowers.subSection','=',$value->subSection)
                        ->count();
                $this->qtyManpower["subSectionQty"][]=[
                "area"=>$value->jobArea,
                "subSection"=>$value->subSection,
                "data"=>$data
                ];
            }

    }


    public function getMPStatistic($jabatan){
        $this->getManpowerJobArea($jabatan);
        $this->getManpowerSubSection($jabatan);
    }

}
