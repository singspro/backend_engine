<?php

namespace App\Models;

use App\Models\trainingPeserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class targetTraining extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function targetTrainings(){
        $data=DB::table('target_trainings')
                        ->leftJoin('kode_trainings','target_trainings.kodeTr','=','kode_trainings.kode')
                        ->leftJoin('instructors','target_trainings.instructor','=','instructors.id')
                        ->leftJoin('lembaga_trainings','target_trainings.lembaga','=','lembaga_trainings.id')
                        ->leftJoin('lokasi_trainings','target_trainings.lokasi','=','lokasi_trainings.id')
                        ->leftJoin('manpowers','target_trainings.nrp','=','manpowers.nrp')
                        ->select(
                                'target_trainings.*',
                                'instructors.namaInstructor',
                                'lembaga_trainings.lembaga as namaLembaga',
                                'lokasi_trainings.lokasiTraining',
                                'manpowers.nama' ,
                                'manpowers.jabatanFn',
                                'manpowers.grade',
                                'manpowers.jobArea',
                                'kode_trainings.judul'
                                )
                        ->orderBy('target_trainings.start','ASC')
                        ->orderBy('target_trainings.nrp','ASC');
        return $data;
    }
}
