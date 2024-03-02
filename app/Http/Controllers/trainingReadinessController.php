<?php

namespace App\Http\Controllers;

use App\Models\manpower;
use App\Models\trainingMatrix;
use App\Models\trainingPeserta;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;



class trainingReadinessController extends Controller
{   
    public function trainingReadinessAll(){
        $data=$this->readinessAll();
        return json_encode($data);
    }
    public function trainingReadinessAllForExcel(Request $request){
        $data=$this->readinessAllForExcel();
        if($request->code!="bbw"){
            return response(null,404);
        }
        return json_encode($data);
    }
    public function achTrainingReadinessAll(){
        $ach=[];
        $open=0;
        $close=0;
        $data=$this->readinessAll();
        foreach ($data as $value) {
            $open+=$value['open'];
            $close+=$value['close'];
        }
        $ach=[
            'open'=>$open,
            'close'=>$close,
        ];

        return json_encode($ach);
    }
    public function readinessAll(){
        $progress=[];
        $open=0;
        $close=0;
        $matrik=trainingMatrix::get();
        $mekanik=manpower::where('perusahaan','1')
                            ->where('jabatanStr','mechanic')
                            ->where('status','aktif')
                            ->where('grade','!=','null')
                            ->where('grade','!=','mpp')
                            ->where('spesialis','!=','-')
                            ->get();
        $training=trainingPeserta::recordTraining()->get();

        foreach ($mekanik as $valueMekanik) {
            $open=0;
            $close=0;
            $trainingOpen=[];
            $trainingClose=[];

            foreach ($matrik as $valueMatrik) {  // cocokan 1 mekanik dengan matrik training
                $status=false;
                if($valueMatrik->grade===$valueMekanik->grade){  //apakah grade sesuai dengan grade yang ada di matrik ?

                    foreach ($training as $valueTraining) { // jika sesuai maka cocokan mekanik dengan record training 
                        if($valueMatrik->spclRole===1){
                            if($valueTraining->trainingSpcl===$valueMekanik->spesialis && $valueMatrik->mandatory===$valueTraining->trainingPrefix && $valueTraining->nrp===$valueMekanik->nrp){ //
                                $status=true;
                            }
                        }
                        else{
                            if($valueMatrik->mandatory===$valueTraining->trainingPrefix && $valueTraining->nrp===$valueMekanik->nrp){ //
                                $status=true;
                            }
                        }
                     
                    }
                    

                    if ($status) {
                        $close++;
                        $trainingClose[]=$valueMatrik->mandatory;
                    } else {
                        $open++;
                        $trainingOpen[]=$valueMatrik->mandatory;
                    }
                    
                }
            }


            if($close+$open===0){
                $ach='-';
            }else{
                $ach=round($close/($close+$open)*100 ,2). ' %';
            }
            $x=[
                'nrp'=>$valueMekanik->nrp,
                'nama'=>$valueMekanik->nama,
                'area'=>$valueMekanik->jobArea,
                'subSection'=>$valueMekanik->subSection,
                'grade'=>$valueMekanik->grade,
                'spcl'=>$valueMekanik->spesialis,
                'open'=>$open,
                'close'=>$close,
                'trainingOpen'=>$trainingOpen,
                'trainingClose'=>$trainingClose,
                'ach'=>$ach
            ];
            $progress[]=$x;
        }
        
        return $progress;
    }

    public function readinessAllForExcel(){
        $progress=[];
        $open=0;
        $close=0;
        $matrik=trainingMatrix::get();
        $mekanik=manpower::where('perusahaan','1')
                            ->where('jabatanStr','mechanic')
                            ->where('status','aktif')
                            ->where('grade','!=','null')
                            ->where('grade','!=','mpp')
                            ->where('spesialis','!=','-')
                            ->get();
        $training=trainingPeserta::recordTraining()->get();

        foreach ($mekanik as $valueMekanik) {
            $open=0;
            $close=0;
            $trainingOpen='';
            $trainingClose='';

            foreach ($matrik as $valueMatrik) {  // cocokan 1 mekanik dengan matrik training
                $status=false;
                if($valueMatrik->grade===$valueMekanik->grade){  //apakah grade sesuai dengan grade yang ada di matrik ?

                    foreach ($training as $valueTraining) { // jika sesuai maka cocokan mekanik dengan record training 
                        if($valueMatrik->spclRole===1){
                            if($valueTraining->trainingSpcl===$valueMekanik->spesialis && $valueMatrik->mandatory===$valueTraining->trainingPrefix && $valueTraining->nrp===$valueMekanik->nrp){ //
                                $status=true;
                            }
                        }
                        else{
                            if($valueMatrik->mandatory===$valueTraining->trainingPrefix && $valueTraining->nrp===$valueMekanik->nrp){ //
                                $status=true;
                            }
                        }
                     
                    }
                    

                    if ($status) {
                        $close++;
                        ($trainingClose==='')? $trainingClose=$trainingClose.$valueMatrik->mandatory : $trainingClose=$trainingClose.', '.$valueMatrik->mandatory;
                    }else{    
                        $open++;
                        ($trainingOpen==='')? $trainingOpen=$trainingOpen.$valueMatrik->mandatory : $trainingOpen=$trainingOpen.', '.$valueMatrik->mandatory;
                        
                    }
                    
                }
            }


            if($close+$open===0){
                $ach='-';
            }else{
                $ach=round($close/($close+$open)*100 ,2). ' %';
            }
            $x=[
                'nrp'=>$valueMekanik->nrp,
                'nama'=>$valueMekanik->nama,
                'area'=>$valueMekanik->jobArea,
                'subSection'=>$valueMekanik->subSection,
                'grade'=>$valueMekanik->grade,
                'spcl'=>$valueMekanik->spesialis,
                'open'=>$open,
                'close'=>$close,
                'trainingOpen'=>$trainingOpen,
                'trainingClose'=>$trainingClose,
                'ach'=>$ach
            ];
            $progress[]=$x;
        }
        
        return $progress;
    }

    public function readinessAllTiremanForExcel(Request $request){
        if($request->code!="bbw"){
            return response(null,404);
        }

        $tireMan=manpower::manpowerAll()
                            ->where('jabatanStr','FIELD SUPPORT')
                            ->where('jabatanFn','like','%TIREMAN%')
                            ->where('status','AKTIF')
                            ->get();
        $recordTraining=trainingPeserta::recordTraining()
                            ->where('manpowers.jabatanStr','FIELD SUPPORT')
                            ->where('manpowers.jabatanFn','like','%TIREMAN%')
                            ->get();
        $trainingMatrix=trainingMatrix::where('jabatan','TIREMAN')->get();
        $data=[];
        foreach ($tireMan as $vTire) {
            $mFound=false;
            $m=[];
            $mText='';
            foreach ($trainingMatrix as $vMatrix) {
               if($vTire->grade===$vMatrix->grade && $vMatrix->spclRole===1){
                $m[]=$vMatrix->mandatory;
                if($mText===''){
                    $mText=$vMatrix->mandatory;
                }else{
                    $mText=$mText.', '.$vMatrix->mandatory;
                }
                $mFound=true;
               }
            }

            $c=[];
            $cText='';
            $o=[];
            $oText='';
            foreach ($m as $vMandatory) {
                $found=false;
                foreach ($recordTraining as $vTraining) {
                    if($vTire->nrp===$vTraining->nrp && $vMandatory===$vTraining->kodeTr){
                        $c[]=$vMandatory;
                        if($cText===''){
                            $cText=$vMandatory;
                        }else{
                            $cText=$cText.', '.$vMandatory;
                        }
                        $found=true;       
                        break;
                    }
                }
                if(!$found){
                    $o[]=$vMandatory;
                    if($oText===''){
                        $oText=$vMandatory;
                    }else{
                        $oText=$oText.', '.$vMandatory;
                    }
                }
            }

            if($mFound){
                $ach=round(count($c)/count($m)*100 ,2). ' %';
                $mandatory=[
                    'nrp'=>$vTire->nrp,
                    'nama'=>$vTire->nama,
                    'perusahaan'=>$vTire->perusahaanText,
                    'grade'=>$vTire->grade,
                    'jobArea'=>$vTire->jobArea,
                    'qtyMandatory'=>count($m),
                    'qtyClose'=>count($c),
                    'qtyOpen'=>count($o),
                    'mandatory'=>$mText,
                    'close'=>$cText,
                    'open'=>$oText,
                    'ach'=>$ach
                ];
            }else{
                $mandatory=[
                    'nrp'=>$vTire->nrp,
                    'nama'=>$vTire->nama,
                    'perusahaan'=>$vTire->perusahaanText,
                    'grade'=>$vTire->grade,
                    'jobArea'=>$vTire->jobArea,
                    'qtyMandatory'=>'-',
                    'qtyClose'=>'-',
                    'qtyOpen'=>'-',
                    'mandatory'=>'-',
                    'close'=>'-',
                    'open'=>'-',
                    'ach'=>'-',
                ];
            }
            $data[]=$mandatory;
        }
        return json_encode($data);
    }

    public function readinessAllStafForExcel(Request $request){
        if($request->code!="bbw"){
            return response(null,404);
        }
        $hasil=[];
        $stafs=manpower::manpowerAll()
        ->where('jabatanStr','GROUP LEADER')
        ->where('status','AKTIF')
        ->where('manpowers.perusahaan','1')
        ->orWhere(function($query){
            $query->where('jabatanStr','UNIT HEAD')
            ->where('status','AKTIF')
            ->where('manpowers.perusahaan','1');
        })
        ->get();

        $recordTrainings=trainingPeserta::recordTraining()
                            ->where('manpowers.jabatanStr','GROUP LEADER')
                            ->orWhere('manpowers.jabatanStr','UNIT HEAD')
                            ->get();
        foreach ($stafs as $vStaf) {
            $mandatorys=trainingMatrix::where('jabatan',$vStaf->jabatanFn)->get();
            if(count($mandatorys)>0){
             $cekTraining=$this->cekTrainings($mandatorys, $vStaf, $recordTrainings);
             $hasil[]=$cekTraining;
            }
        }

        return json_encode($hasil);
    }

    private function cekTrainings($mandatorys,$staff,$trainings){
        $hasil=[];
        $trainingOpen='';
        $trainingClose='';
        $openInt=0;
        $closeInt=0;
        foreach ($mandatorys as $vMandatory) {
            foreach ($trainings as $vTraining) {
                $found=false;
                if($vMandatory->mandatory===$vTraining->trainingPrefixStaff && $staff->nrp===$vTraining->nrp){
                    $found=true;
                    $closeInt++;
                    $trainingClose===''?$trainingClose=$vMandatory->mandatory:$trainingClose=$trainingClose.', '.$vMandatory->mandatory;
                    break;
                }
            }

            if(!$found){
                $openInt++;
                $trainingOpen===''?$trainingOpen=$vMandatory->mandatory:$trainingOpen=$trainingOpen.', '.$vMandatory->mandatory;
            }
            
        }
        $hasil=[
            'nrp'=>$staff->nrp,
            'nama'=>$staff->nama,
            'jabatanStr'=>$staff->jabatanStr,
            'jabatanFn'=>$staff->jabatanFn,
            'jobArea'=>$staff->jobArea,
            'openInt'=>$openInt,
            'closeInt'=>$closeInt,
            'open'=>$trainingOpen,
            'close'=>$trainingClose,
            'ach'=>round($closeInt/($closeInt+$openInt)*100,2)
        ];
        return $hasil;
    }
}

