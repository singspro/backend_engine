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
use DateInterval;
use DateTime;

class bankSoal extends Controller
{
    public function getEvtInfoGass(Request $request){
        $v=$this->accessTokenCheck($request);
        if(!$v['status']){
            return response()->json(array(
                'status'=>'error',
                'message'=>$v['message'],
                ),404);
        }

        return response()->json([
            'status'=>'ok',
            'data'=>$v['data']
        ],200);
      
    }
    public function soal(Request $request){
        return view('soal/contents/soalMain',[
            'judulTest'=>'PK Dozer'
        ]);
    }

    public function login(Request $request){
        $cekLink=$this->getEvent($request->sings);

        if(!$cekLink['status']){
            return response()->json(array(
                'status'=>'error',
                'data'=>$cekLink['message'],
            ),404);
        }

        $evt=$cekLink['eventData'];
        $token='SingsPro'.Str::random(255);
        $i=[
            'token'=>$token,           
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
        $v=$this->accessTokenCheck($request);
        if(!$v['status']){
            return response()->json(array(
                'status'=>'error',
                'message'=>$v['message'],
                ),404);
        }
        $i=$v['data'];
        return response()->json(array(
        'status'=>'ok',
        'data'=>[
            'token'=>$i->accessToken,
            'judul'=>$i->judul,
            'soalUmum'=>$i->soalUmum,
        ],
        ),200);

    }

    public function manpowerData(Request $request){
        $aa=$this->accessTokenCheck($request);
        if(!$aa['status']){
            return response()->json(array(
                'status'=>'error',
                'message'=>$aa['message'],
                ),404);
        }
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

    public function orangDalam(Request $request){
        $aa=$this->accessTokenCheck($request);
        if(!$aa['status']){
            return response()->json(array(
                'status'=>'error',
                'message'=>$aa['message'],
            ),404);
        }
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
    public function orangUmum(Request $request){
        $aa=$this->accessTokenCheck($request);
        if(!$aa['status']){
            return response()->json(array(
                'status'=>'error',
                'message'=>$aa['message'],
            ),404);
        }
        $table=$this->inputDataPesertaGeneral($request);
        return response()->json(array(
            'status'=>'ok',
            'data'=>[
                'tokenPeserta'=>$table->tokenPeserta
                ],
        ),200);
        
    }

    public function dataOrangYangTest(Request $request){
        $aa=$this->accessTokenCheck($request);
        if(!$aa['status']){
            return response()->json(array(
                'status'=>'error',
                'message'=>$aa['message'],
            ),404);
        }
        $i=$aa['data'];
        $data=bankSoalHasilPeserta::where('tokenPeserta',$request->header('tokenPeserta'))->get();
        $idSoalUtama=bankSoalEvent::where('kodeEvent',$i->kodeEvent)->get();
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'nama'=>$data->first()->nama,
                'jabatan'=>$data->first()->jabatanFn,
                'perusahaan'=>$data->first()->perusahaan,
                'tokenPeserta'=>$data->first()->tokenPeserta,
                'soal'=>$this->ambilDataSoal($idSoalUtama->first()->idSoalUtama,$idSoalUtama)
            ]
            ],200);

    }

    public function kumpulkanTest(Request $request){
        $aa=$this->accessTokenCheck($request);
        if(!$aa['status']){
            return response()->json(array(
                'status'=>'error',
                'message'=>$aa['message'],
            ),404);
        }
        $i=$aa['data'];
        $h=$request->header('tokenPeserta');
            return response()->json(array(
                'status'=>'ok',
                'data'=>$this->koreksi($request,$i->kodeEvent,$h),
            ),200);
        
    }
    public function hasilTest(Request $request){
        $aa=$this->accessTokenCheck($request);
        if(!$aa['status']){
            return response()->json(array(
                'status'=>'error',
                'message'=>$aa['message'],
            ),404);
        }
        $h=$request->header('tokenPeserta');
        return response()->json([
            'status'=>'ok',
            'data'=>$this->ambilHasilTest($h),
        ],200);
    
    }

    public function imageSoal(Request $request){
        return response()->file(storage_path('app/questionImage/'.$request->img));
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
    $ans=$data->ans;
    $bahasSoal=$e->first()->bahas? true:false;
    $releaseNilai=$e->first()->nilai===1?true:false;
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
    $resume=$this->hitungNilai($hasilKoreksi,$e);
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

private function hitungNilai($i,$e){
    $j1=0;
    $b1=0;
    $j2=0;
    $b2=0;
    $j3=0;
    $b3=0;

    $balanced=$e->first()->bobotBalanced==1?true:false;
    $bobot1=$e->first()->bobotMc;
    $bobot2=$e->first()->bobotTf;
    $bobot3=$e->first()->bobotMatch;
    foreach ($i as $vi) {

        if($vi['jenis']===1){
            $j1++;
            if($vi['nilai']===1){
            $b1++;
            }
        }
        if($vi['jenis']===2){
            $j2++;
            if($vi['nilai']===1){
            $b2++;
            }
        }
        if($vi['jenis']===3){
            $j3++;
            if($vi['nilai']===1){
            $b3++;
            }
        }
        
    }
    if($balanced){
        $jumlahSoal=$j1+$j2+$j3;
        $jawabanBenar=$b1+$b2+$b3;
        $nilai=round($jawabanBenar/$jumlahSoal*100,2);
    }else{
        $jumlahSoal=$j1+$j2+$j3;
        $jawabanBenar=$b1+$b2+$b3;

        $nilai1=$j1===0?0:round($b1/$j1*$bobot1,2);
        $nilai2=$j2===0?0:round($b2/$j2*$bobot2,2);
        $nilai3=$j3===0?0:round($b3/$j3*$bobot3,2);

        $nilai=$nilai1+$nilai2+$nilai3;
    }

    return [
        'jumlahSoal'=>$jumlahSoal,
        'benar'=>$jawabanBenar,
        'nilai'=>$nilai
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

public function accessTokenCheck($request){
    $j=$request->header('singspro');
    $i=access_token_table::accessToken()->where('access_token_tables.accessToken','=',$j)->first();
    $now=strtotime(date('Y-m-d H:i:s'));
    $eventExpired=strtotime($i->validDate);
    if($now>$eventExpired){
        return [
            'status'=>false,
            'message'=>'Link Expired',
        ];
        
    }
    if(!$i){
        return [
            'status'=>false,
            'message'=>'Event tidak ditemukan',
        ];
        
    }
    return [
        'status'=>true,
        'data'=>$i
    ];
}
private function getEvent($kodeEvent){
    $evt=bankSoalEvent::where('kodeEvent',$kodeEvent)->get();
    $now=strtotime(date('Y-m-d H:i:s'));
    $eventExpired=strtotime($evt->first()->validUntil);
        
        if(count($evt)===0){
            return [
            'status'=>false,
            'message'=>'Event Tidak Ditemukan'
            ];
        }

        if($now>$eventExpired){
            return [
            'status'=>false,
            'message'=>'Link Expired'
            ];
        }

    return [
        'status'=>true,
        'message'=>'Berhasil',
        'eventData'=>$evt
    ];
}
private function validationOrangDalam($req){
    if($req->nrp=='' || $req->nrp==null){
        return false;
    }
    return true;
}

public function ambilDataSoal($kode,$eventData){
    $dataAll=[];
    $jenis=[];
    $data=[];
    $qtyMatchingMain=0;
    $qtyMatchingSub=[];
    $qtyMc=0;
    $qtyTf=0;

    $acakTf=$eventData->first()->acakTf===1?true:false;
    $acakMatch=$eventData->first()->acakMatch===1?true:false;
    $acakMc=$eventData->first()->acakMc===1?true:false;

    $batasiMc=$eventData->first()->batasiMc;
    $batasiTf=$eventData->first()->batasiTf;

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
                if($acakMatch){
                    shuffle($soal);
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

    //kelompokkan soal
    $soal1=[];
    $soal2=[];
    $soal3=[];
    foreach ($data as $vData) {
        if($vData['jenis']===1){
            $soal1[]=$vData;
        }
        if($vData['jenis']===2){
            $soal2[]=$vData;
        }
        if($vData['jenis']===3){
            $soal3[]=$vData;
        }
    }
    // Acak Soal

    if($acakMc){
        shuffle($soal1);
    }
    if($acakTf){
        shuffle($soal2);
    }

    // mode batasi soal
    if($batasiMc<$qtyMc){
        $soal1=array_slice($soal1,$qtyMc-$batasiMc);
    }
    if($batasiTf<$qtyTf){
        $soal2=array_slice($soal2,$qtyTf-$batasiTf);
    }

    $data=[];
    $data=array_merge($soal1,$soal2,$soal3);
    $dataAll=[
        'data'=>$data,
        'jenis'=>$jenis,
        'qty'=>[
            'qtyMatching'=>$qtyMatchingMain,
            'qtySubMatching'=>$qtyMatchingSub,
            'qtyMc'=>$qtyMc,
            'qtyTf'=>$qtyTf,
        ],
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

