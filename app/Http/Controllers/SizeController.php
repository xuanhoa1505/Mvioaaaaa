<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class SizeController extends Controller
{
    public function AuthLogin(){
        $id = Session::get('id');
        if($id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
      }
    
    
    
        public function addsize($id , Request $request){
          $this->AuthLogin();
          $all_size = DB::table('Product')->where('Product.id',$id)->get();
          $all_img = DB::table('size_product')->where('size_product.id_pro',$id)->get();
            return view('admin.size.addsize')->with('all_size',$all_size)->with('all_img',$all_img);
        }
}
