<?php

namespace App\Http\Controllers;

use App\Models\manpower;
use App\Models\trainingMatrix;
use App\Models\trainingPeserta;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


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
}

