<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class access_token_table extends Model
{
    use HasFactory;

    protected $guarded=[];

    public static function accessToken(){
        $data=DB::table('access_token_tables')
                ->leftJoin('bank_soal_events','access_token_tables.kodeEvent','=','bank_soal_events.kodeEvent')
                ->select('access_token_tables.*','bank_soal_events.*');
        return $data;
    }
}
