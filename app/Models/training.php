<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class training extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Get the kodeTraining that owns the training
     *
     *
     */
    public function kodeTraining(): BelongsTo
    {
        return $this->belongsTo(kodeTraining::class,'kodeTr','kode');
    }
    public function lokasiTraining(): BelongsTo
    {
        return $this->belongsTo(lokasiTraining::class,'lokasi','id');
    }
    public function lembagaTraining():BelongsTo
    {
        return $this->belongsTo(lembagaTraining::class,'lembaga','id');
    }
    public function instructorList():BelongsTo 
    {
        return $this->belongsTo(instructor::class,'instructor','id');
    }

    public static function dataTrainingAll(){
        $data=DB::table('trainings')
                    ->leftJoin('kode_trainings','trainings.kodeTr','=','kode_trainings.kode')
                    ->leftJoin('instructors','trainings.instructor','=','instructors.id')
                    ->leftJoin('lembaga_trainings','trainings.lembaga','=','lembaga_trainings.id')
                    ->leftJoin('uraian_materis','trainings.uraianMateri','=','uraian_materis.id')
                    ->leftJoin('lokasi_trainings','trainings.lokasi','=','lokasi_trainings.id')
                    ->select('trainings.*',
                    'kode_trainings.judul',
                    'uraian_materis.uraianMateri',
                    'lokasi_trainings.lokasiTraining',
                    'lembaga_trainings.lembaga',
                    'instructors.namaInstructor');
                    
        return $data;
    }
}