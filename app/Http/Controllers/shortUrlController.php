<?php

namespace App\Http\Controllers;


use App\Models\shortUrlRev2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class shortUrlController extends Controller
{
    public function submitNew(Request $request){
        $validator=Validator::make($request->all(),[
            'urlShort'=>'required|unique:short_url_rev2s,slug|regex:/^\S*$/u',
            'redirect'=>'required',
        ],[
            'urlShort.required'=>'tidak boleh koosong',
            'urlShort.unique'=>'url ini sudah ada',
            'urlShort.regex'=>'tidak boleh ada spasi',
            'redirect'=>'tidak boleh kosong',
        ]);
        if ($validator->fails()){
                 return redirect()
                        ->to('/newShortUrl')
                        ->withErrors($validator)
                        ->withInput();          
        }
        $urlLower=strtolower($request->urlShort);
        shortUrlRev2::create([
            'urlShroten'=>url('/').'/link_'.$urlLower,
            'slug'=>$urlLower,
            'urlTarget'=>$request->redirect,
            'remark'=>$request->remark,
            'creator'=>Auth::user()->name
        ]);
       return redirect()->to('/shrotUrl');
    }
    public function urlPendek(Request $request){
        return view('short-shortUrlMainPage',[
            'title'=>'Shorten URL',
            'subTitle'=>'URL',
            'user'=>Auth::user(),
            'table'=>shortUrlRev2::get()
        ]);
    }

    public function redirectGuys($slug){
        $d=shortUrlRev2::where('slug',$slug)->first();
        if($d){
            return redirect()->to($d->urlTarget);
        }else{
            return view('short-notFound',[]);
        }
        
    }

    public function deleteUrlGuys(Request $request){
        shortUrlRev2::where('id',$request->data)->delete();
        return response()->json([
            'status'=>'ok',
        ],200);
    }

    public function newShortGuys(){
        return view('short-new',[
            'title'=>'Shorten URL',
            'subTitle'=>'newURL',
            'user'=>Auth::user(),
            'table'=>shortUrlRev2::get()
        ]);
    }

}
