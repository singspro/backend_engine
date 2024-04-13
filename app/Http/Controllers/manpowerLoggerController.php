<?php

namespace App\Http\Controllers;

use App\Models\manpower;
use App\Models\manpowerLogger;
use Illuminate\Http\Request;

class manpowerLoggerController extends Controller
{
    public function log(){
        $qty=new hitungMp;
        $hasil=$qty->all()->get();
        foreach ($hasil as $value) {
            manpowerLogger::create($value);
        }
        $hasil=$qty->byJobArea()->get();
        foreach ($hasil as $value) {
            manpowerLogger::create($value);
        }

    }
}

class hitungMp{
   
    private static $hasil,$subSection,$filter,$filtered;
    function __construct(){
        self::$filter=[
            'basic'=>[
                ['perusahaan','=',1],
                ['subSection','!=',''],
                ['subSection','!=',null],
                ['subSection','!=','-'],
                ['section','=','PLANT'],
                ['status','=','AKTIF'],
                ['jabatanStr','=','MECHANIC'],
                ['grade','!=','-'],
                ['grade','!=',''],
                ['grade','!=',null],
                ['grade','not like','%MPP%']
            ],
        ];

        self::$filtered=[[]];
    }

    /**
     * @param array $filter
     */
    private function filter($filter){
        $fil=$filter;
        $ff=self::$filter['basic'];
        count($filter)>0?$ff=array_merge($ff,$fil):'';
        return $ff;
    }
    /**
     * @param array $filter
     */
    private function count($filter=[]){
        $manpower=manpower::where($this->filter($filter))->get();
        return count($manpower);
    }

    private function getJobArea($f){
        $manpower=$manpower=manpower::where($this->filter($f))->get(['jobArea']);
        foreach ($manpower as $value) {
         $jobArea[]=$value->jobArea;
        }
        return array_values(array_unique($jobArea));
    }
    private function getSubSection($f){
        $manpower=$manpower=manpower::where($this->filter($f))->get(['subSection']);
        foreach ($manpower as $value) {
         $subSection[]=$value->subSection;
        }
        return array_values(array_unique($subSection));
    }
    private function getGrade($f){
        $manpower=$manpower=manpower::where($this->filter($f))->get(['grade']);
        foreach ($manpower as $value) {
         $grade[]=$value->grade;
        }
        return array_values(array_unique($grade));
    }

    public function all(){
        $a=self::count([]);
        $hasil[]=[
            'perusahaan'=>1,
            'jobArea'=>'all',
            'subSection'=>'all',
            'jabatan'=>'MECHANIC',
            'grade'=>'all',
            'status'=>'AKTIF',
            'jumlah'=>$a
        ];
        self::$hasil=$hasil;
        return new hitungMp;
    }

    public function byLevelDetail(){
        $hasil=[];
            $jobArea=$this->getJobArea([]);
            foreach ($jobArea as $vJobArea) {
                $subSection=$this->getSubSection([['jobArea','=',$vJobArea]]);
                foreach ($subSection as $vSubSection) {
                    $grade=$this->getGrade([['jobArea','=',$vJobArea],['subSection','=',$vSubSection]]);
                    foreach ($grade as $vGrade) {
                        $a=$this->count([['jobArea','=',$vJobArea],['subSection','=',$vSubSection],['grade','=',$vGrade]]);
                        $hasil[]=[
                                'perusahaan'=>1,
                                'jobArea'=>$vJobArea,
                                'subSection'=>$vSubSection,
                                'jabatan'=>'MECHANIC',
                                'grade'=>$vGrade,
                                'status'=>'AKTIF',
                                'jumlah'=>$a
                            ];
                    }
                }
            }
        
        self::$hasil=$hasil;
        return new hitungMp;
    }

    public function byJobArea(){
        $hasil=[];
            $jobArea=$this->getJobArea([]);
            foreach ($jobArea as $vJobArea) {
                        $a=$this->count([['jobArea','=',$vJobArea]]);
                        $hasil[]=[
                                'perusahaan'=>1,
                                'jobArea'=>$vJobArea,
                                'subSection'=>'all',
                                'jabatan'=>'MECHANIC',
                                'grade'=>'all',
                                'status'=>'AKTIF',
                                'jumlah'=>$a
                            ];
                    
            }
        self::$hasil=$hasil;
        return new hitungMp;
    }

    public function get(){
        return self::$hasil;
    }

}





