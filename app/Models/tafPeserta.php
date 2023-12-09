<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tafPeserta extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function getData(){
        $data=DB::table('taf_pesertas')
        ->leftJoin('manpowers','taf_pesertas.nrp','=','manpowers.nrp')
        ->select('manpowers.*','taf_pesertas.idTaf');

        return $data;
    }
}
