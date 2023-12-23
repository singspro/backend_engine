<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class trainingPeserta extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function training(): BelongsTo
    {
        return $this->belongsTo(training::class, 'idTr', 'idTr');
    }

    public static function traininPesertas(){
        $data=DB::table('training_pesertas')
                        ->leftJoin('trainings','training_pesertas.idTr','=','trainings.idTr')
                        ->leftJoin('instructors','trainings.instructor','=','instructors.id')
                        ->select('training_pesertas.*',
                        'trainings.*',
                        'instructors.namaInstructor'
                        );
        return $data;
    }
    public static function recordTraining() {
        $data=DB::table('training_pesertas')
                        ->leftJoin('trainings','training_pesertas.idTr','=','trainings.idTr')
                        ->leftJoin('kode_trainings','trainings.kodeTr','=','kode_trainings.kode')
                        ->leftJoin('instructors','trainings.instructor','=','instructors.id')
                        ->leftJoin('manpowers','training_pesertas.nrp','=','manpowers.nrp')
                        ->leftJoin('uraian_materis','trainings.uraianMateri','=','uraian_materis.id')
                        ->leftJoin('lokasi_trainings','trainings.lokasi','=','lokasi_trainings.id')
                        ->leftJoin('lembaga_trainings','trainings.lembaga','=','lembaga_trainings.id')
                        ->leftJoin('perusahaans','manpowers.perusahaan','=','perusahaans.id')
                        ->select('training_pesertas.*',
                        'trainings.idTr',
                        'trainings.kodeTr',
                        'trainings.start',
                        'trainings.end',
                        'manpowers.nama',
                        'manpowers.section',
                        'manpowers.subSection',
                        'manpowers.jabatanFn',
                        'manpowers.jabatanStr',
                        'manpowers.grade',
                        'manpowers.status',
                        'perusahaans.perusahaan',
                        'kode_trainings.judul',
                        'kode_trainings.trainingPrefix',
                        'kode_trainings.spesialis as trainingSpcl',
                        'uraian_materis.uraianMateri as urnMtr',
                        'lokasi_trainings.lokasiTraining as lksTrn',
                        'lembaga_trainings.lembaga as lbg',
                        'instructors.namaInstructor'
                        );
        return $data;
    }

}
