<?php

namespace App\Http\Controllers;

use App\Models\kodeKompetensi;
use App\Models\manpower;
use App\Models\resumeMechanicReadiness;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\matrixKompetensi;
use App\Models\ojiReport;
use App\Models\trainingMatrix;
use App\Models\trainingPeserta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class v1DashboardReadiness extends Controller
{
    public function loginDashboard(){
        return response()->json([
            'status'=>'ok',
            'user'=>Auth::user()->name
        ],200);
    }
    public function Apilogin(Request $request){
        $validator=validator::make($request->all(),[
            'name'=>'Required',
            'password'=>'Required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>'error',
                'message'=>$validator->errors()
            ],200);
        }

        $user=User::where('name',$request->name)->first();
        if(!$user||!hash::check($request->password,$user->password)){
            return response()->json([
                'status'=>'failed',
                'message'=>'invalid Credential'
            ],401);
        }

        $token =$user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'status'=>'ok',
            'user'=>$user,
            'token'=>$token
        ],200);
    }

    public function getResumeRead(){
        $t=readinessTraining::readinessTrainingAll();
        $template[]=  [
                "name"=> "TRAINING READINESS",
                "total"=> $t['resume']['close'].' / '.$t['resume']['open']+$t['resume']['close']." Tr.",
                "progress"=> $t['resume']['ach'].'%',
                "time"=> "Knowledge",
                "status"=>"Outstanding",
                "info"=> [
                    [
                        "title"=> "HIGHEST",
                        "value"=> $t['resume']['outStanding']['highest']['spcl'].' ('.$t['resume']['outStanding']['highest']['value'].' Tr.)',
                        "class"=> "text-theme"
                    ],
                    [
                        "title"=> "LOWEST",
                        "value"=> $t['resume']['outStanding']['lowest']['spcl'].' ('.$t['resume']['outStanding']['lowest']['value'].' Tr.)',
                        "class"=> "text-theme text-opacity-50"
                        ]
                    ],
                    "chartData"=> [
                        round(100-$t['resume']['ach'],2), $t['resume']['ach']
                    ],
                    "chartType"=> "donut",
                    "chartHeight"=> 50
                    
                ];
        $c=readinessCompetency::getQtyReadinessAll();
                $template[]=  
                    [
                        "name"=> "COMPETENCY READINESS",
                        "total"=> $c['resume']['close'].' / '.$c['resume']['open']+$c['resume']['close']." Comp.",
                        "progress"=> $c['resume']['ach'].'%',
                        "time"=> "Skill",
                        "status"=>"Outstanding",
                        "info"=> [
                            [
                                "title"=> "HIGHEST",
                                "value"=> $c['resume']['outStanding']['highest']['spcl'].' ('.$c['resume']['outStanding']['highest']['value'].' Comp.)',
                                "class"=> "text-theme"
                            ],
                            [
                                "title"=> "LOWEST",
                                "value"=> $c['resume']['outStanding']['lowest']['spcl'].' ('.$c['resume']['outStanding']['lowest']['value'].' Comp.)',
                                "class"=> "text-theme text-opacity-50"
                                ]
                            ],
                            "chartData"=> [
                                round(100-$c['resume']['ach'],2), $c['resume']['ach']
                            ],
                            "chartType"=> "donut",
                            "chartHeight"=> 50
                            
                    ];

            return response()->json([
            'status'=>'ok',
            'data'=>$template
        ],200);
    }

    public function getDataServer(){
        $tr=[];
        $co=[];
        $template2=[];
        $readinessMilestone=readinessMilestone::get();

        foreach ($readinessMilestone as $value) {
            $tr[]=$value->trAch;
            $co[]=$value->compAch;
            $tanggal=$value->created_at;
            $template2[]=date_format($tanggal,'Y, M');
        }

        $template1=[
            [
            'name'=>'Training R.', 
            'data'=> $tr
            ],
            [
            'name'=>'Competency R.', 
            'data'=> $co
            ],
        ];

        return response()->json([
            'status'=>'ok',
            'series'=>$template1,
            'category'=>$template2
        ],200);
    }
    public function getDataStats(){
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

        return response()->json([
            'status'=>'ok',
            'data'=>$this->getReadinessTrainingBySection($this->getSubSection($dataMechanicAktif))
        ],200);
    }

    private function getSubSection($data){
        $sections=[];
        foreach ($data as $vData) {
            $sections[]=$vData->subSection;
        }
        return array_values(array_unique($sections));
    }

    private function countMechanic($mech,$subSecTion){
        $qty=0;
        foreach ($mech as $vMech) {
            if($vMech->subSection===$subSecTion){
                $qty++;
            }
        }
        return $qty;
    }

    private function countReadiness($data){
        $open=0;
        $close=0;
        foreach ($data as $vData) {
            $open+=$vData['open'];
            $close+=$vData['close'];
        }


        return round($close/($open+$close)*100,2);
    }

    private function getReadinessTrainingBySection($sections){
        $filter=[];
        foreach ($sections as $vSection) {
            $a=[];
            $readinessTraining=readinessTraining::readinessTrainingAll($vSection);
            $readinessCompetency=readinessCompetency::getQtyReadinessAll($vSection);
            $readinessMilestone=readinessMilestone::get($vSection);
            foreach ($readinessMilestone as $value) {
                $a[]=$value->readiness;
            }
            $template=[
                "title"=> $vSection,
                "total"=> count($readinessTraining['data']),
                "info"=> [
                    [
                        "icon"=> "far fa-user fa-fw me-1",
                        "text"=> $readinessTraining['resume']['ach']."% Training Readiness"
                    ],
                    [
                        "icon"=> "far fa-user fa-fw me-1",
                        "text"=> $readinessCompetency['resume']['ach'].'% Competency Readiness'
                    ],
                    [
                        "icon"=> "far fa-check-circle fa-fw me-1",
                        "text"=> round(($readinessTraining['resume']['ach']+$readinessCompetency['resume']['ach'])/2,2)."% Mechanic Readiness"
                    ],
                    [
                        "icon"=> "far fa-times-circle fa-fw me-1",
                        "text"=> "note: Exclude MPP"
                        ]
                    ],
                    "chartData"=> [
                        [
                          "name"=> "Visitors",
                          "data"=> $a
                        ]
                      
                          ],
                    "chartType"=> "bar",
                    "chartHeight"=> 40
                    ];
                    $filter[]=$template;
                }
        return $filter;
    }
    
}

class readinessMilestone{
    public static function get($subSection='all'){
        $readinessLog=resumeMechanicReadiness::where('subSection',$subSection)->orderBy('created_at','asc')->limit(12)->get();
        return $readinessLog;
    }
}
class readinessCompetency{
    public static function getQtyReadinessAll($subSection='all'){
        $hasil=[];
        $totalOpen=0;
        $totalClose=0;
        
        $compOpen=[];
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
            $spclOpen=[];
            $mC=matrixKompetensi::lengkap()
            ->where('spcl',$vManpower->spesialis)
            ->where('grade',$vManpower->grade)
            ->get();
            $spcl=$vManpower->spesialis;

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
                    $spclOpen[]=$spcl;
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
            
            $compOpen=array_merge($compOpen,$spclOpen);
        }
        $compOpen=array_count_values($compOpen);
        arsort($compOpen);
        $spclHigh=array_key_first($compOpen);
        $spclHighValue=$compOpen[$spclHigh];

        asort($compOpen);
        $spclLow=array_key_first($compOpen);
        $spclLowValue=$compOpen[$spclLow];
        $result=[
            'data'=>$hasil,
            'resume'=>[
                'open'=>$totalOpen,
                'close'=>$totalClose,
                'ach'=>round($totalClose/($totalClose+$totalOpen)*100,2),
                'outStanding'=>[
                    'highest'=>[
                        'spcl'=>$spclHigh,
                        'value'=>$spclHighValue
                    ],
                    'lowest'=>[
                        'spcl'=>$spclLow,
                        'value'=>$spclLowValue
                    ]
                ],
            ]
            ];
        return $result;
    }
}


class readinessTraining {
    public static function readinessTrainingAll($subSection='all'){
 
        $x=[];
        $totalOpen=0;
        $totalClose=0;
        $spclOpens=[];
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
                $spclOpen=[];
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
                            $spclOpen[]=$vMekanik->spesialis;
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

                    $spclOpens=array_merge($spclOpens,$spclOpen);
                }

                $spclOpens=array_count_values($spclOpens);

                arsort($spclOpens);
                $spclHigh=array_key_first($spclOpens);
                $spclHighValue=$spclOpens[$spclHigh];
                
                asort($spclOpens);
                $spclLow=array_key_first($spclOpens);
                $spclLowValue=$spclOpens[$spclLow];
                $hasil=[
                    'data'=>$x,
                    'resume'=>[
                        'open'=>$totalOpen,
                        'close'=>$totalClose,
                        'ach'=>round($totalClose/($totalOpen+$totalClose)*100,2),
                        'outStanding'=>[
                            'highest'=>[
                                'spcl'=>$spclHigh,
                                'value'=>$spclHighValue
                            ],
                            'lowest'=>[
                                'spcl'=>$spclLow,
                                'value'=>$spclLowValue
                            ]
                        ],

                    ]
                    ];
                return $hasil;
    }

}

