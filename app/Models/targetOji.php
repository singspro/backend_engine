<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class targetOji extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function progressOji(){
        $data=DB::table('target_ojis')
                ->leftJoin('manpowers','target_ojis.nrp','=','manpowers.nrp')
                ->leftJoin('oji_reports','target_ojis.idOji','=','oji_reports.idOji')
                ->leftJoin('kode_kompetensis','target_ojis.kodeKompetensi','=','kode_kompetensis.kode')
                ->leftJoin('instructors','oji_reports.instructor','=','instructors.id')
                ->select(
                    'target_ojis.idOji',
                    'target_ojis.nrp',
                    'manpowers.nama',
                    'manpowers.subSection',
                    'manpowers.jobArea',
                    'manpowers.grade',
                    'target_ojis.kodeKompetensi',
                    'kode_kompetensis.namaKompetensi',
                    'target_ojis.tahun',
                    'target_ojis.jenisOji',
                    'oji_reports.instructor',
                    'instructors.namaInstructor as closedBy',
                    'oji_reports.startDate',
                    'oji_reports.endDate',
                    'oji_reports.startTime',
                    'oji_reports.endTime',
                    'oji_reports.remark'
                );
        return $data;
    }
}
