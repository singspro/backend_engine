<?php


use App\Http\Controllers\bankSoal;
use App\Http\Controllers\trainingReadinessController;
use App\Models\manpower;
use App\Models\ojiReport;
use App\Models\targetOji;
use App\Models\targetTraining;
use App\Models\trainingPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/manpowerppdmaco',function(Request $request){
    return manpower::manpowerAll()
                                            ->where('status',$request->b)
                                            ->where('section',$request->c)
                                            ->where('jobArea',$request->ee,$request->e)
                                            ->where('subSection',$request->dd,$request->d)
                                            ->get();
});

Route::get('/ojippdmaco',function(Request $request){
    if($request->code!="bbw"){
        return response(null,404);
    }
    return targetOji::progressOji()->orderBy('oji_reports.startDate','DESC')->get();
});

Route::get('/ojiAll',function(Request $request){
    if($request->code!="bbw"){
        return response(null,404);
    }
    return ojiReport::dataOjiAll()->orderBy('oji_reports.startDate','DESC')->get();
});

Route::get('/monitoringtrainingppdmaco',function(Request $request){
    if($request->code!="bbw"){
        return response(null,404);
    }
    $target=targetTraining::targetTrainings()->get();
    $actual=trainingPeserta::traininPesertas()->get();
    $hasil=[];
    $status=false;
    
    foreach ($target as $t) {
        foreach ($actual as $a) {
            $th=(int)date_format(date_create( $a->start),'Y');

            if($t->nrp===$a->nrp && $t->kodeTr===$a->kodeTr && $t->tahun===$th){
                $dump=[
                    'nrp'=>$t->nrp,
                    'nama'=>$t->nama,
                    'jabatan'=>$t->jabatanFn,
                    'jobArea'=>$t->jobArea,
                    'grade'=>$t->grade,
                    'statusMp'=>$t->sts,
                    'kode'=>$t->kodeTr,
                    'judul'=>$t->judul,
                    'jenis'=>$t->jenisTraining,
                    'targetInstructor'=>$t->namaInstructor,
                    'targetStart'=>($t->start===null)?'-':$t->start,
                    'targetEnd'=>($t->end===null)?'-':$t->end,
                    'tahun'=>$t->tahun,
                    'status'=>'close',
                    'closeBy'=>$a->namaInstructor,
                    'start'=>$a->start,
                    'end'=>$a->end
                ];
                $hasil[]=$dump;
                $status=true;
            }
        }
        if(!$status){

            $dump=[
                'nrp'=>$t->nrp,
                'nama'=>$t->nama,
                'jabatan'=>$t->jabatanFn,
                'jobArea'=>$t->jobArea,
                'grade'=>$t->grade,
                'statusMp'=>$t->sts,
                'kode'=>$t->kodeTr,
                'judul'=>$t->judul,
                'jenis'=>$t->jenisTraining,
                'targetInstructor'=>$t->namaInstructor,
                'targetStart'=>($t->start===null)?'-':$t->start,
                'targetEnd'=>($t->end===null)?'-':$t->end,
                'tahun'=>$t->tahun,
                'status'=>'open',
                'closeBy'=>'-',
                'start'=>'-',
                'end'=>'-'
            ];
            $hasil[]=$dump;

        }
        $status=false;
    }
    return $hasil;
});

Route::get('/recordTraining',function(Request $request){
    if($request->code!="bbw"){
        return response(null,404);
    }
    $training=trainingPeserta::recordTraining()->get();
    foreach ($training as $value) {
        $data[]=[
            'idTr'=>$value->idTr,
            'nrp'=>$value->nrp,
            'nama'=>$value->nama,
            'perusahaan'=>$value->perusahaan,
            'section'=>$value->section,
            'subSection'=>$value->subSection,
            'jabatanFn'=>$value->jabatanFn,
            'grade'=>$value->grade,
            'status'=>$value->status,
            'kodeTr'=>$value->kodeTr,
            'judul'=>($value->kodeTr==='-')? $value->urnMtr :$value->judul,
            'start'=>$value->start,
            'end'=>$value->end,
            'lembaga'=>$value->lbg,
            'instructor'=>$value->namaInstructor,
            'lokasi'=>$value->lksTrn,
            'preTest'=>$value->pre,
            'posTest'=>$value->post,
            'practice'=>$value->practice,
            'result'=>$value->result,
            'remark'=>$value->remark
        ];
    }
    return $data;


});

Route::get('/trainingReadiness',[trainingReadinessController::class,'trainingReadinessAll']);
Route::get('/trainingReadinessApi',[trainingReadinessController::class,'trainingReadinessAllForExcel']);
Route::get('/trainingReadinessTiremanApi',[trainingReadinessController::class,'readinessAllTiremanForExcel']);

Route::post('/soalLogin',[bankSoal::class,'login']);
Route::get('/getParam',[bankSoal::class,'getParam']);
Route::get('/mp',[bankSoal::class,'manpowerData']);
Route::post('/submitInternal',[bankSoal::class,'orangDalam']);
Route::get('/mpTest',[bankSoal::class,'dataOrangYangTest']);
Route::post('/ansSubmit',[bankSoal::class,'kumpulkanTest']);
Route::get('/xnxx',[bankSoal::class,'imageSoal']);





