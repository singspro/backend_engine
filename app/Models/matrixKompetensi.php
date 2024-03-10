<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class matrixKompetensi extends Model
{
    use HasFactory;
    public static function lengkap(){
        $data=DB::table('matrix_kompetensis')
                    ->leftJoin('kode_kompetensis','kode_kompetensis.kode','=','matrix_kompetensis.kode')
                    ->select('matrix_kompetensis.*','kode_kompetensis.namaKompetensi');
        return $data;
    }
}
