<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class DetailController extends Controller
{
    public function AuthLogin(){
        $id = Session::get('id');
        if($id){
            return Redirect::to('home');
        }else{
            return Redirect::to('')->send();
        }
    }
    public function detail($slug) {
        $this->AuthLogin();
        $product = DB::table('Product')->where('slug',$slug)->first();
        $size = DB::table('size_product')->where('id_pro',$product->id)->get();
        $related_product = DB::table('Product')->where('id_type',$product->id_type)->paginate(4);
        return view('home.detail', compact('product', 'size', 'related_product'));
    }
}
