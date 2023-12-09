<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tafData extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function dataTaf(){
        $data=DB::table('taf_data')
                    ->leftJoin('kode_trainings','taf_data.kodeTraining','=','kode_trainings.kode')
                    ->leftJoin('uraian_materis','taf_data.kodeUraianMateri','=','uraian_materis.id')
                    ->leftJoin('lembaga_trainings','taf_data.lembaga','=','lembaga_trainings.id')
                    ->leftJoin('lokasi_trainings','taf_data.lokasi','=','lokasi_trainings.id')
                    ->select('taf_data.*',
                            'kode_trainings.judul',
                            'uraian_materis.uraianMateri',
                            'lembaga_trainings.lembaga as namaLembaga',
                            'lokasi_trainings.lokasiTraining');
        return $data;
    }
}
