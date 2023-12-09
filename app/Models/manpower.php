<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class manpower extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function manpowerAll(){
        $data=DB::table('manpowers')
                ->leftJoin('perusahaans','manpowers.perusahaan','=','perusahaans.id')
                ->select('manpowers.*',
                'perusahaans.perusahaan as perusahaanText');
                return $data;
    }

 
}
