<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class bankSoalHasilJawabanModel extends Model
{
    use HasFactory;
    protected $guarded=[];
    public static function detail(){
        $data=DB::table('bank_soal_hasil_jawaban_models')
        ->leftJoin('bank_soal_events','bank_soal_hasil_jawaban_models.kodeEvent','=','bank_soal_events.kodeEvent')
        ->select('bank_soal_hasil_jawaban_models.*','bank_soal_events.*');

    return $data;
    }
}
