<?php

use App\Http\Controllers\bankSoal;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logOutController;
use App\Http\Controllers\manpowerController;
use App\Http\Controllers\mentorController;
use App\Http\Controllers\trainingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// halaman dashboard
Route::get('/',[dashboardController::class,'dashboard'])->middleware('auth');
Route::get('/somplak',[dashboardController::class,'mechanicData'])->middleware('auth');
Route::get('/kopiHitam',[dashboardController::class,'listManpowerStatistic'])->middleware('auth');


// halaman login
Route::get('/login',[loginController::class,'loginUser'])->middleware('guest');
Route::post('/ngok',[loginController::class,'mlebu'])->middleware('guest');


//halaman loggout
Route::post('/janganTinggalinAkuKasih',[logOutController::class,'metu'])->middleware('auth');


// halaman manpower
Route::get('/mp', [manpowerController::class,'manpowerData'])->middleware('auth');
Route::get('/detail{slug}', [manpowerController::class,'manpowerDetailData'])->middleware('auth');
Route::get('/error{slug}', [manpowerController::class,'manpowerDetailDataError'])->middleware('auth');
Route::get('/success{slug}', [manpowerController::class,'manpowerDetailDataSuccess'])->middleware('auth');
Route::get('/mp-delete', [manpowerController::class,'manpowerDetailDelete'])->middleware('auth');
Route::get('/new-mp', [manpowerController::class,'manpowerNew'])->middleware('auth');
Route::post('mp-new-save',[manpowerController::class,'mpNewSave'])->middleware('auth');
Route::post('updateMp',[manpowerController::class,'updateMpSave'])->middleware('auth');


// halaman training
Route::get('/tr',[trainingController::class,'trainingData'])->middleware('auth');
Route::get('/tr-new',[trainingController::class,'trainingNew'])->middleware('auth');
Route::get('/tr-taf',[trainingController::class,'trainingTaf'])->middleware('auth');
Route::post('/trainingSave',[trainingController::class,'trainingNewSave'])->middleware('auth');
Route::get('/trainingDetail',[trainingController::class,'trainingDetail'])->middleware('auth');
Route::get('/trainingEdit',[trainingController::class,'trainingEdit'])->middleware('auth');
Route::post('/getPeserta',[trainingController::class,'getPesertaTraining'])->middleware('auth'); 
Route::post('/koclok',[trainingController::class,'trainingEditSave'])->middleware('auth');
Route::get('/kuntul',[trainingController::class,'downloadFileAbsensi'])->name('jokoPrasetyo')->middleware('auth');
Route::get('/kintil',[trainingController::class,'downloadFileDokumen'])->name('ecmv')->middleware('auth');
Route::get('/anget',[trainingController::class,'deleteTraining'])->name('multiflo')->middleware('auth');
Route::get('/soalMain',[trainingController::class,'bankSoalMain'])->middleware('auth');
Route::get('/soalDetail',[trainingController::class,'soalDetail'])->middleware('auth');
Route::post('/soalData',[trainingController::class,'hemm'])->middleware('auth');
Route::get('/soalNew',[trainingController::class,'soalNew'])->middleware('auth');
Route::post('/soalNewSubmit1',[trainingController::class,'submitNewSoal1'])->middleware('auth');
Route::get('/soalEvent',[trainingController::class,'soalEvent'])->middleware('auth');
Route::post('/deleteSoal',[trainingController::class,'deleteSoal'])->middleware('auth');
Route::get('/eventDetail',[trainingController::class,'eventDetailGass'])->middleware('auth');
route::delete('/deleteEvent',[trainingController::class,'deleteEventGas'])->middleware('auth');
Route::get('/showResult',[trainingController::class,'pengerjaan'])->middleware('auth');



// halaman training TAF
Route::get('/ixx',[trainingController::class,'newTaf'])->middleware('auth');
Route::post('/tafNewSave',[trainingController::class,'newTafSave'])->middleware('auth');
Route::post('/dikenyot',[trainingController::class,'tafEditSave'])->middleware('auth');
Route::get('/lampunut',[trainingController::class,'tafDetail'])->middleware('auth');
Route::get('/sabun',[trainingController::class,'tafEdit'])->middleware('auth');
Route::get('/ngonok',[trainingController::class,'tafDelete'])->middleware('auth');
Route::post('/nurulNurjani',[trainingController::class,'tafGetPesertaEdit'])->middleware('auth');
Route::post('/enakenak',[trainingController::class,'tafGetDataForGeneratePdf'])->middleware('auth');
Route::post('/hotSekali',[trainingController::class,'getDataTrainingDetail'])->middleware('auth');


// halaman mentoring
Route::get('/mentor',[mentorController::class,'mentorData'])->middleware('auth');
Route::post('/iHateu',[mentorController::class,'saveAllMentor'])->middleware('auth');
Route::get('/mentor-new', [mentorController::class,'mentorNew'])->middleware('auth');
Route::post('/getMentorData',[mentorController::class,'targetOjiOpen'])->middleware('auth');
Route::post('/iloveu',[mentorController::class,'listCodeCompetensi'])->middleware('auth');
Route::post('/asemKecut',[mentorController::class,'mentorDetail'])->middleware('auth');
Route::get('/kentut',[mentorController::class,'downloadAbsensi'])->middleware('auth');
Route::post('/bbwIsHot',[mentorController::class,'dataEditOji'])->middleware('auth');
Route::post('/moncrot',[mentorController::class,'dataEditOjiSave'])->middleware('auth');
Route::post('/kocok',[mentorController::class,'deleteMentor'])->middleware('auth');


//halaman bank soal
Route::get('/soal',[bankSoal::class,'soal']);
Route::get('/imgQuestions',[trainingController::class,'soalImg'])->middleware('auth');
Route::post('/imgSend',[trainingController::class,'soalImageSend'])->middleware('auth');


//Test apis

Route::get('/test',[Controller::class,'test'])->middleware('auth');

