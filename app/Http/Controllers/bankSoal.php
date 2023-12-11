<?php

namespace App\Http\Controllers;

use App\Models\access_token_table;
use App\Models\bankSoalEvent;
use App\Models\bankSoalHasilPeserta;
use App\Models\manpower;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class bankSoal extends Controller
{
    public function soal(Request $request){
        return view('soal/contents/soalMain',[
            'judulTest'=>'PK Dozer'
        ]);
    }

    public function login(Request $request){
        $evt=$this->getEvent($request);
        if(count($evt)===0){
            return response()->json(array(
                'status'=>'error'
            ),200);
        }
        $token='SingsPro-'.Str::random(255);
        $i=[
            'token'=>$token
        ];
        access_token_table::create([
           'accessToken'=>$token,
            'kodeEvent'=>$evt->first()->kodeEvent,
            'validDate'=>date_create($evt->first()->validUntil),
        ]);
        $i['soalUmum']=$evt->first()->soalUmum;
        return response()->json(array(
            'status'=>'ok',
            'data'=>$i,
        ),200);

    }

    public function getParam(Request $request){
        $j=$request->header('singspro');
        $i=access_token_table::accessToken()->where('access_token_tables.accessToken','=',$j)->get();
        if(count($i)>0){
            $i=$i->first();
            return response()->json(array(
            'status'=>'ok',
            'data'=>[
                'token'=>$i->accessToken,
                'judul'=>$i->judul,
                'soalUmum'=>$i->soalUmum,
            ],
            ),200);
        }

        return response()->json(array(
            'status'=>'error',
            'data'=>'',
            ),404);
    }

    public function manpowerData(Request $request){
        $j=$request->header('singspro');
        $i=access_token_table::accessToken()->where('access_token_tables.accessToken','=',$j)->get();
        if(count($i)>0){
            $a=manpower::manpowerAll()->where('status','AKTIF')->get();
            $b=[];
            foreach ($a as $value) {
                $b[]=[
                    'nrp'=>$value->nrp,
                    'nama'=>$value->nama,
                    'perusahaan'=>$value->perusahaanText,
                    'jabatanFn'=>$value->jabatanFn,
                ];
            }
            return response()->json(array(
                'status'=>'ok',
                'data'=>$b
                ),200);
        }

        return response()->json(array(
            'status'=>'error',
            'data'=>'',
            ),404);
    }

    public function orangDalam(Request $request){
        $j=$request->header('singspro');
        $i=access_token_table::accessToken()->where('access_token_tables.accessToken','=',$j)->get();
        if(count($i)>0){
            $valid=$this->validationOrangDalam($request);
            if($valid){
                $table=$this->inputDataPesertaSoalDalam($request);
                return response()->json(array(
                    'status'=>'ok',
                    'data'=>[
                        'idTable'=>$table->id,
                        'nama'=>$table->nama,
                        'jabatanFn'=>$table->jabatanFn,
                        'perusahaan'=>$table->perusahaan
                        ],
                ),200);
            }
            $message='NRP masih kosong';
            return response()->json(array(
                'status'=>'error',
                'data'=>'',
                'message'=>$message
                ),200);
        }
        return response()->json(array(
            'status'=>'error',
            'data'=>''
            ),404);
    }

// -------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------------------------------

private function inputDataPesertaSoalDalam($req){
    $token=$req->header('singspro');
    $kodeEvent=access_token_table::where('accessToken',$token)->get();
    $nrp=$req->nrp;
    $mp=manpower::manpowerAll()->where('nrp',$nrp)->get();

    $table=bankSoalHasilPeserta::create([
        'kodeEvent'=>$kodeEvent->first()->kodeEvent,
        'idMp'=>$mp->first()->id,
        'nama'=>$mp->first()->nama,
        'jabatanFn'=>$mp->first()->jabatanFn,
        'perusahaan'=>$mp->first()->perusahaanText,
    ]);

    return $table;

}
private function getEvent($request){
    $evt=bankSoalEvent::where('kodeEvent',$request->sings)->get();
    return $evt;
}
private function validationOrangDalam($req){
    if($req->nrp=='' || $req->nrp==null){
        return false;
    }
    return true;
}
}

