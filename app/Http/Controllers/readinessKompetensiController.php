<?php

namespace App\Http\Controllers;

use App\Models\manpower;
use App\Models\matrixKompetensi;
use App\Models\ojiReport;
use Illuminate\Http\Request;

class readinessKompetensiController extends Controller
{   

    public function getReadinesMentahan(){
        return response()->json([
            'status'=>'ok',
            'data'=>$this->getQtyReadinessAll()
        ],200);
    }
    public function getReadinessOpen(Request $request){
        if($request->code==='bbw'){
            $dataReadinessComp= $this->readinessOpen($this->getQtyReadinessAll());
            // return response()->json([
            //     'status'=>'ok',
            //     'data'=>$dataReadinessComp
            // ],200);

            return json_encode($dataReadinessComp);
        }
        return response()->json([
            'status'=>'error',
        ],404);

    }
    
    public function getQtyReadiness(Request $request){
        if($request->code==='bbw'){
            $dataReadinessComp= $this->prosentaseReadiness($this->getQtyReadinessAll());
            // return response()->json([
            //     'status'=>'ok',
            //     'data'=>$dataReadinessComp
            // ],200);

            return json_encode($dataReadinessComp);
        }
        return response()->json([
            'status'=>'error',
        ],404);

    }
    public function getQtyReadinessLocale(){
        return $this->prosentaseReadiness($this->getQtyReadinessAll());
    }

    //-------------------------------------------------------------------------------------------------------------------------//
    //-------------------------------------------------------------------------------------------------------------------------//
    //-------------------------------------------------------------------------------------------------------------------------//
    //-------------------------------------------------------------------------------------------------------------------------//
    //-------------------------------------------------------------------------------------------------------------------------//
    //-------------------------------------------------------------------------------------------------------------------------//
    //-------------------------------------------------------------------------------------------------------------------------//
    //-------------------------------------------------------------------------------------------------------------------------//

    private function readinessOpen($data){
        $hasil=[];
        foreach ($data as $vData) {
            foreach ($vData['compOpen'] as $vVData) {
                $hasil[]=[
                    'nrp'=>$vData['nrp'],
                    'nama'=>$vData['nama'],
                    'jabatanStr'=>$vData['jabatanStr'],
                    'jabatanFn'=>$vData['jabatanFn'],
                    'grade'=>$vData['grade'],
                    'spcl'=>$vData['spcl'],
                    'subSection'=>$vData['subSection'],
                    'jobArea'=>$vData['jobArea'],
                    'open'=>$vVData[0],
                    'judul'=>$vVData[1],
                ];
            }
        }
        return $hasil;
    }
    private function prosentaseReadiness($data){
        $hasil=[];
        foreach ($data as $key => $vData) {
            $open=count($vData['compOpen']);
            $close=count($vData['compClose']);
            $prosentase=$open+$close===0?0:round($close/($close+$open)*100,2);
            $hasil[]=[
                'nrp'=>$vData['nrp'],
                'nama'=>$vData['nama'],
                'jabatanStr'=>$vData['jabatanStr'],
                'jabatanFn'=>$vData['jabatanFn'],
                'grade'=>$vData['grade'],
                'spcl'=>$vData['spcl'],
                'subSection'=>$vData['subSection'],
                'jobArea'=>$vData['jobArea'],
                'open'=>$open,
                'close'=>$close,
                'prosentase'=>$prosentase
            ];
        }
        return $hasil;
    }
    private function getQtyReadinessAll(){
        $hasil=[];
        $manpower=manpower::manpowerAll()
        ->where('status','AKTIF')
        ->where('jabatanStr','MECHANIC')
        ->where('spesialis','!=',null)
        ->where('spesialis','!=','')
        ->where('spesialis','!=','-')
        ->get();
        
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
                'compOpen'=>$compNotMatch
            ];
        }

        return $hasil;
    }
}

