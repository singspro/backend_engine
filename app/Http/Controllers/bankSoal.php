<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class bankSoal extends Controller
{
    public function soal(Request $request){
        return view('soal/contents/soalMain',[
            'judulTest'=>'PK Dozer'
        ]);
    }
}
