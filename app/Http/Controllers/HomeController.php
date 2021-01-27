<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function AuthLogin(){
        $id = Session::get('id');
        if($id){
            return Redirect::to('home');
        }else{
            return Redirect::to('')->send();
        }
    }
    public function index(){
        $this->AuthLogin();
        //$dts= Customers::all();

       $Bestsellers  = DB::table('Product')->where('muc','0')->orderby('id','desc')->get(); 
     $Newarrivals = DB::table('Product')->where('muc','1')->orderby('id','desc')->get(); 
        $Sales = DB::table('Product')->where('muc','2')->orderby('id','desc')->get(); 
        $Logo = DB::table('Logo')->where('stt','1')->get(); 
       return view('home.home')->with('Bestsellers', $Bestsellers )
        ->with('Newarrivals', $Newarrivals )->with('Sales', $Sales )->with('Logo',$Logo);
        //return view('home.home',compact('dts'));
    }



}