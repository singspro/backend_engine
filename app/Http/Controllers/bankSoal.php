<?php

namespace App\Http\Controllers;

use App\Models\bankSoalEvent;
use App\Models\bankSoalIsi;
use App\Models\bankSoalJawaban;
use App\Models\bankSoalMatchingChoice;
use App\Models\bankSoalMatchingSoal;
use Illuminate\Support\Facades\Storage;


use App\Models\access_token_table;

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
        $token='SingsPro'.Str::random(255);
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
                        'tokenPeserta'=>$table->tokenPeserta
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
    public function dataOrangYangTest(Request $request){
        $j=$request->header('singspro');
        $i=access_token_table::accessToken()->where('access_token_tables.accessToken','=',$j)->get();
        if(count($i)>0){
            $data=bankSoalHasilPeserta::where('tokenPeserta',$request->header('tokenPeserta'))->get();
            $idSoalUtama=bankSoalEvent::where('kodeEvent',$i->first()->kodeEvent)->get();
            return response()->json(array(
                'status'=>'ok',
                'data'=>[
                    'nama'=>$data->first()->nama,
                    'jabatan'=>$data->first()->jabatanFn,
                    'perusahaan'=>$data->first()->perusahaan,
                    'tokenPeserta'=>$data->first()->tokenPeserta,
                    'soal'=>$this->ambilDataSoal($idSoalUtama->first()->idSoalUtama)
                ]
            ),200);
        }

        return response()->json(array(
            'status'=>'error',
            'data'=>''
        ),404);
    }

    public function kumpulkanTest(Request $request){
        $j=$request->header('singspro');
        $i=access_token_table::accessToken()->where('access_token_tables.accessToken','=',$j)->get();
        if(count($i)>0){
            return response()->json(array(
                'status'=>'ok',
                'data'=>$request->data
            ),200);
        }
        return response()->json(array(
            'status'=>'error',
            'data'=>''
        ),404);
    }

    public function imageSoal(Request $request){
        
        return response()->file(storage_path('app/questionImage/'.$request->img));
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
        'tokenPeserta'=>'iLoveBbwBokonkSemoxszz'.Str::random(255),
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
        $filePath=env('FILE_HOST_CLIENT').'xnxx?img='.$id.'.jpg';
    }
    return ['fileStatus'=>$fileStatus,'filePath'=>$filePath];
}

}

