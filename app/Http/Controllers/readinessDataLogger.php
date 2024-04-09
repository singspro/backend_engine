<?php

namespace App\Http\Controllers;

use App\Models\resumeMechanicReadiness;
use Illuminate\Http\Request;
use App\Models\manpower;
use App\Models\matrixKompetensi;
use App\Models\ojiReport;
use App\Models\trainingMatrix;
use App\Models\trainingPeserta;

class readinessDataLogger extends Controller
{

    public function logDataReadiness(){
        $allTrainingOpen=0;
        $allTrainingClose=0;
        $allCompetencyOpen=0;
        $allCompetencyClose=0;
        $allMekanik=0;
        $dataMechanicAktif=manpower::where('perusahaan',1)
        ->where('status','AKTIF')
        ->where('jabatanStr','MECHANIC')
        ->where('spesialis','!=','-')
        ->where('spesialis','!=',null)
        ->where('spesialis','!=','')
        ->where('grade','!=','-')
        ->where('grade','!=','')
        ->where('grade','!=',null)
        ->get();

        $subSections=$this->getSubSection($dataMechanicAktif);
        foreach ($subSections as $value) {
            $a=manpower::where('subSection',$value)->first();
            $competency=readinessCompetencyLog::getQtyReadinessAll($value);
            $training=readinessTrainingLog::readinessTrainingAll($value);
            resumeMechanicReadiness::create([
                'jobArea'=>$a->jobArea,
                'subSection'=>$value,
                'qtyManpower'=>$training['resume']['manpower'],
                'comQtyOpen'=>$competency['resume']['open'],
                'comQtyClose'=>$competency['resume']['close'],
                'compAch'=>$competency['resume']['ach'],
                'trQtyOpen'=>$training['resume']['open'],
                'trQtyClose'=>$training['resume']['close'],
                'trAch'=>$training['resume']['ach'],
                'readiness'=>round(($competency['resume']['ach']+$training['resume']['ach'])/2,2)
            ]);

            $allTrainingOpen+=$training['resume']['open'];
            $allTrainingClose+=$training['resume']['close'];
            $allCompetencyOpen+=$competency['resume']['open'];
            $allCompetencyClose+=$competency['resume']['close'];
            $allMekanik+=$competency['resume']['manpower'];
        }
        $allReadinessTraining=round($allTrainingClose/($allTrainingClose+$allTrainingOpen)*100,2);
        $allReadinessCompetency=round($allCompetencyClose/($allCompetencyClose+$allCompetencyOpen)*100,2);
        resumeMechanicReadiness::create([
            'jobArea'=>'all',
            'subSection'=>'all',
            'qtyManpower'=>$allMekanik,
            'comQtyOpen'=>$allCompetencyOpen,
            'comQtyClose'=>$allCompetencyClose,
            'compAch'=>$allReadinessCompetency,
            'trQtyOpen'=>$allTrainingOpen,
            'trQtyClose'=>$allTrainingClose,
            'trAch'=>$allReadinessTraining,
            'readiness'=>round(($allReadinessCompetency+$allReadinessTraining)/2,2)
        ]);
        
    }
    private function getSubSection($data){
        $sections=[];
        foreach ($data as $vData) {
            $sections[]=$vData->subSection;
        }
        return array_values(array_unique($sections));
    }
}

class readinessCompetencyLog{
    public static function getQtyReadinessAll($subSection='all'){
        $hasil=[];
        $totalOpen=0;
        $totalClose=0;
        $mekanik=manpower::manpowerAll()
        ->where('status','AKTIF')
        ->where('jabatanStr','MECHANIC')
        ->where('spesialis','!=',null)
        ->where('spesialis','!=','')
        ->where('spesialis','!=','-');
        if($subSection !=='all'){
            $mekanik->where('subSection',$subSection);
        }


        $manpower=$mekanik->get();
        foreach ($manpower as $vManpower) {
            $compMatch=[];
            $compNotMatch=[];
            $mC=matrixKompetensi::lengkap()
            ->where('spcl',$vManpower->spesialis)
            ->where('grade',$vManpower->grade)
            ->get();

            $recordOji=ojiReport::where('nrp',$vManpower->nrp)
            ->where('jenisOji','!=','NON MANDATORY')
            ->get();

            foreach ($mC as $vMc) {
                $found=false;
                
                foreach ($recordOji as $vRecordOji) {
                    if($vMc->kode===$vRecordOji->kodeKompetensi){
                        $compMatch[]=[$vMc->kode,$vMc->namaKompetensi];
                        // dd($vMc);
                        $found=true;
                        break;
                    }
                }

                if(!$found){
                    $compNotMatch[]=[$vMc->kode,$vMc->namaKompetensi];
                }

            }
            $qtyOpen=count($compNotMatch);
            $qtyClose=count($compMatch);
            $hasil[]=[
                'nrp'=>$vManpower->nrp,
                'nama'=>$vManpower->nama,
                'jabatanStr'=>$vManpower->jabatanStr,
                'jabatanFn'=>$vManpower->jabatanFn,
                'grade'=>$vManpower->grade,
                'spcl'=>$vManpower->spesialis,
                'subSection'=>$vManpower->subSection,
                'jobArea'=>$vManpower->jobArea,
                'compClose'=>$compMatch,
                'compOpen'=>$compNotMatch,
                'qtyOpen'=>$qtyOpen,
                'qtyClose'=>$qtyClose,
                'ach'=>$qtyClose+$qtyOpen===0?0:round($qtyClose/($qtyClose+$qtyOpen)*100,2)
            ];

            $totalOpen+=$qtyOpen;
            $totalClose+=$qtyClose;
        }
        $result=[
            'data'=>$hasil,
            'resume'=>[
                'open'=>$totalOpen,
                'close'=>$totalClose,
                'ach'=>round($totalClose/($totalClose+$totalOpen)*100,2),
                'manpower'=>count($manpower)
            ]
            ];
        return $result;
    }
}


class readinessTrainingLog {
    public static function readinessTrainingAll($subSection='all'){
 
        $x=[];
        $totalOpen=0;
        $totalClose=0;
        $manpower=manpower::where('perusahaan','1')
                ->where('jabatanStr','mechanic')
                ->where('status','aktif')
                ->where('grade','!=','null')
                // ->where('grade','!=','mpp')
                ->where('spesialis','!=','-');


        if($subSection !=='all'){
            $manpower->where('subSection',$subSection);
        }

        $mekanik= $manpower->get();
                foreach ($mekanik as $vMekanik) {
                
                $clo=[];
                $op=[];
                    $matrik=trainingMatrix::where('jabatan',$vMekanik->jabatanStr)
                    ->where('grade',$vMekanik->grade)
                    ->get();
                    // dd($matrik);
                    foreach ($matrik as $vMatrik) {
                        $found=false;
                        $training=trainingPeserta::recordTraining()
                        ->where('training_pesertas.nrp',$vMekanik->nrp)
                        ->get();
                        foreach ($training as $vTraining) {
                            if($vMatrik->spclRole===0){
                                if($vMatrik->mandatory===$vTraining->trainingPrefix){
                                    $clo[]=$vMatrik->mandatory;
                                    $found=true;
                                    break;
                                }
                            }else{
                                if($vMatrik->mandatory===$vTraining->trainingPrefix && $vTraining->trainingSpcl===$vMekanik->spesialis){
                                    $clo[]=$vMatrik->mandatory;
                                    $found=true;
                                    break;
                                }
                            }
                        }
                        if(!$found){
                            $op[]=$vMatrik->mandatory;
                        }
                    }
                    $close=count($clo);
                    $open=count($op);
                    $x[]=[
                        'nrp'=>$vMekanik->nrp,
                        'nama'=>$vMekanik->nama,
                        'area'=>$vMekanik->jobArea,
                        'subSection'=>$vMekanik->subSection,
                        'grade'=>$vMekanik->grade,
                        'spcl'=>$vMekanik->spesialis,
                        'open'=>$open,
                        'close'=>$close,
                        'trainingOpen'=>$op,
                        'trainingClose'=>$clo,
                        'ach'=>(($open+$close)===0)? 0 : round($close/($open+$close)*100,2)
                    ];

                    $totalOpen+=$open;
                    $totalClose+=$close;
    
                }
                $hasil=[
                    'data'=>$x,
                    'resume'=>[
                        'open'=>$totalOpen,
                        'close'=>$totalClose,
                        'ach'=>round($totalClose/($totalOpen+$totalClose)*100,2),
                        'manpower'=>count($mekanik)
                    ]
                    ];
                return $hasil;
    }

}
