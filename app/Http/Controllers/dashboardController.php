<?php

namespace App\Http\Controllers;

use App\Models\manpower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
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
