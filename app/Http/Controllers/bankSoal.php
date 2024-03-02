<?php

namespace App\Http\Controllers;

use App\Models\bankSoalEvent;
use App\Models\bankSoalHasilJawabanModel;
use App\Models\bankSoalIsi;
use App\Models\bankSoalJawaban;
use App\Models\bankSoalMatchingChoice;
use App\Models\bankSoalMatchingSoal;
use App\Models\bankSoalUtama;
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
    public function orangUmum(Request $request){
        $j=$request->header('singspro');
        $i=access_token_table::accessToken()->where('access_token_tables.accessToken','=',$j)->get();
        if(count($i)>0){
                $table=$this->inputDataPesertaGeneral($request);
                return response()->json(array(
                    'status'=>'ok',
                    'data'=>[
                        'tokenPeserta'=>$table->tokenPeserta
                        ],
                ),200);
            
        }  
        return response()->json(array(
            'status'=>'error',
            'data'=>null
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
        $h=$request->header('tokenPeserta');
        $i=access_token_table::accessToken()->where('access_token_tables.accessToken','=',$j)->get();
        if(count($i)>0){
            return response()->json(array(
                'status'=>'ok',
                'data'=>$this->koreksi($request,$i->first()->kodeEvent,$h),
            ),200);
        }
        return response()->json(array(
            'status'=>'error',
            'data'=>null
        ),404);
    }

    public function imageSoal(Request $request){
        
        return response()->file(storage_path('app/questionImage/'.$request->img));
    }

    public function hasilTest(Request $request){
        $j=$request->header('singspro');
        $h=$request->header('tokenPeserta');
        $i=access_token_table::accessToken()->where('access_token_tables.accessToken','=',$j)->get();
        if(count($i)>0){
            return response()->json(array(
                'status'=>'ok',
                'data'=>$this->ambilHasilTest($h),
            ),200);
        }
        return response()->json(array(
            'status'=>'error',
            'data'=>null
        ),404);
    }
// -------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------------------------------
public function ambilHasilTest($h){
    $dataPengerjaan=bankSoalHasilPeserta::details()->where('tokenPeserta',$h)->get();
    $data=[
        'releaseNilai'=>$dataPengerjaan->first()->nilai,
        'bahasSoal'=>$dataPengerjaan->first()->bahas,
        'nilai'=>$dataPengerjaan->first()->nilai===0?null:$dataPengerjaan->first()->hasilNilai
    ];
    return $data;
}
private function koreksi($data,$kodeEvent,$tokenPeserta){
   
    $e=bankSoalEvent::where('kodeEvent',$kodeEvent)->get();
    $soal=$data->soal['data'];
    // $soal=$data->soal;
    $ans=$data->ans;
    $bahasSoal=$e->first()->bahas? true:false;
    // $bahasSoal=true;
    $releaseNilai=true;
    $hasilKoreksi=[];
    foreach ($soal as $vSoal) {
        if($vSoal['jenis']===1){
            $hasilKoreksi[]=$this->koreksiSoal1($vSoal, $ans, $tokenPeserta);
        }
        if($vSoal['jenis']===2){
            $hasilKoreksi[]=$this->koreksiSoal2($vSoal, $ans, $tokenPeserta);
        }
        if($vSoal['jenis']===3){
            $aa=$this->koreksiSoal3($vSoal, $ans, $tokenPeserta);
            foreach ($aa as $vAa) {
                $hasilKoreksi[]=$vAa;
            }
            
        }
    }
    $resume=$this->hitungNilai($hasilKoreksi);
    bankSoalHasilPeserta::where('tokenPeserta',$tokenPeserta)
                            ->update([
                                'benar'=>$resume['benar'],
                                'salah'=>$resume['jumlahSoal']-$resume['benar'],
                                'nilai'=>$resume['nilai']
                            ]);
    $data=[
        'bahas'=>$bahasSoal,
        'releaseNilai'=>$releaseNilai
    ];
    return $data;
}

private function hitungNilai($i){
    $j=0;
    $b=0;
    foreach ($i as $vi) {
        $j++;
        if($vi['nilai']===1){
            $b++;
        }
    }
    return [
        'jumlahSoal'=>$j,
        'benar'=>$b,
        'nilai'=>round($b/$j*100,2)
    ];
}

private function koreksiSoal1($soal, $ans,$tokenPeserta){
    $f=bankSoalHasilPeserta::details()->where('tokenPeserta','=',$tokenPeserta)->get();
    $j=null;
    foreach($ans as $vAns){
        if($vAns['jenis']===1 && $vAns['idSoalIsi']===$soal['idSoalIsi']){
            $j=$vAns['value'];
        }
    }

    $kunci=bankSoalJawaban::where('idSoalIsi',$soal['idSoalIsi'])
                            ->where('jawabanBenar',1)
                            ->get();
    if($j===$kunci->first()->pilihanJawaban){
        $a=[
            'jenis'=>1,
            'idSoalIsi'=>$soal['idSoalIsi'],
            'nilai'=>1
        ];
    }else{
        $a=[
            'jenis'=>1,
            'idSoalIsi'=>$soal['idSoalIsi'],
            'nilai'=>0
        ];
    }

    bankSoalHasilJawabanModel::create([
            'kodeEvent'=>$f->first()->kodeEvent,
            'tokenPeserta'=>$f->first()->tokenPeserta,
            'revisiSoal'=>$f->first()->revisi,
            'idSoalUtama'=>$f->first()->idSoalUtama,
            'idSoalIsi'=>$soal['idSoalIsi'],
            'jenis'=>1,
            'idSoalMatch'=>null,
            'jawaban'=>$j
        
    ]);

    return $a;
}
private function koreksiSoal2($soal, $ans, $tokenPeserta){
    $f=bankSoalHasilPeserta::details()->where('tokenPeserta','=',$tokenPeserta)->get();
    $j=null;
    foreach($ans as $vAns){
        if($vAns['jenis']===2 && $vAns['idSoalIsi']===$soal['idSoalIsi']){
            $j=$vAns['value'];
        }
    }
 
    $kunci=bankSoalJawaban::where('idSoalIsi',$soal['idSoalIsi'])
                            ->where('jawabanBenar',1)
                            ->get();
    if($j===$kunci->first()->pilihanJawaban){
        $a=[
            'jenis'=>2,
            'idSoalIsi'=>$soal['idSoalIsi'],
            'nilai'=>1
        ];
    }else{
        $a=[
            'jenis'=>2,
            'idSoalIsi'=>$soal['idSoalIsi'],
            'nilai'=>0
        ];
    }

    bankSoalHasilJawabanModel::create([
        'kodeEvent'=>$f->first()->kodeEvent,
        'tokenPeserta'=>$f->first()->tokenPeserta,
        'revisiSoal'=>$f->first()->revisi,
        'idSoalUtama'=>$f->first()->idSoalUtama,
        'idSoalIsi'=>$soal['idSoalIsi'],
        'jenis'=>2,
        'idSoalMatch'=>null,
        'jawaban'=>$j
    ]);

    return $a;
}
private function koreksiSoal3($soal, $ans,$tokenPeserta){
    $f=bankSoalHasilPeserta::details()->where('tokenPeserta','=',$tokenPeserta)->get();
    $a=[];
    $saveAnswer=function($f,$soal,$subId,$jawaban){
        bankSoalHasilJawabanModel::create([
            'kodeEvent'=>$f->first()->kodeEvent,
            'tokenPeserta'=>$f->first()->tokenPeserta,
            'revisiSoal'=>$f->first()->revisi,
            'idSoalUtama'=>$f->first()->idSoalUtama,
            'idSoalIsi'=>$soal['idSoalIsi'],
            'jenis'=>3,
            'idSoalMatch'=>$subId,
            'jawaban'=>$jawaban
        ]);
        return null;
    };

    foreach ($soal['soal'] as $vSoal) {
       
        $k=bankSoalMatchingSoal::where('idSoalIsi',$soal['idSoalIsi'])
                                        ->where('id',$vSoal['id'])
                                        ->get();
        $j=null;
        foreach ($ans as $vAns) {
            if($vAns['jenis']===3 && $vAns['subSoalId']===$vSoal['id'] && $vAns['idSoalIsi']===$soal['idSoalIsi']){
                $j=$vAns['value'];
                break;
            }
        }
        if($j===$k->first()->kunci){
            $saveAnswer($f,$soal,$vSoal['id'],$j);
            $a[]=[
                'jenis'=>3,
                'idSoalIsi'=>$soal['idSoalIsi'],
                'nilai'=>1
            ];
        }else{
            $saveAnswer($f,$soal,$vSoal['id'],$j);
            $a[]=[
                'jenis'=>3,
                'idSoalIsi'=>$soal['idSoalIsi'],
                'nilai'=>0
            ];
        }
    }   
    return $a;
}



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
private function inputDataPesertaGeneral($req){
    $token=$req->header('singspro');
    $kodeEvent=access_token_table::where('accessToken',$token)->get();

    $table=bankSoalHasilPeserta::create([
        'kodeEvent'=>$kodeEvent->first()->kodeEvent,
        'idMp'=>null,
        'tokenPeserta'=>'iLoveBbwBokonkSemoxszz'.Str::random(255),
        'nama'=>$req->nama,
        'jabatanFn'=>$req->jabatan,
        'perusahaan'=>$req->perusahaan,
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
                        // 'kunci'=>$m->kunci
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
                    // 'key'=>$key,
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

