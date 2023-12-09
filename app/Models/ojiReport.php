<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ojiReport extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function dataOjiAll(){
        $dataOji=DB::table('oji_reports')
                ->leftJoin('manpowers','oji_reports.nrp','=','manpowers.nrp')
                ->leftJoin('kode_kompetensis','oji_reports.kodeKompetensi','=','kode_kompetensis.kode')
                ->leftJoin('instructors','oji_reports.instructor','=','instructors.id')
                ->select('oji_reports.*',
                'manpowers.nama',
                'manpowers.subSection',
                'manpowers.jabatanFn',
                'manpowers.jobArea',
                'kode_kompetensis.namaKompetensi',
                'instructors.namaInstructor');

        return $dataOji;
    }
}
