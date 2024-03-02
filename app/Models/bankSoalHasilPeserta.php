<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class bankSoalHasilPeserta extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function details(){
        $data=DB::table('bank_soal_hasil_pesertas')
                        ->leftJoin('bank_soal_events','bank_soal_hasil_pesertas.kodeEvent','=','bank_soal_events.kodeEvent')
                        ->leftJoin('bank_soal_utamas','bank_soal_events.idSoalUtama','=','bank_soal_utamas.idSoalUtama')
                        ->select(
                            'bank_soal_hasil_pesertas.nilai as hasilNilai',
                            'bank_soal_hasil_pesertas.*',
                            'bank_soal_events.*',
                            'bank_soal_utamas.*');
        return $data;

    }

}