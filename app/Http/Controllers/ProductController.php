<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use App\Models\ProductModel;
use App\Models\SizeModel;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function AuthLogin(){
      $id = Session::get('id');
        if($id){
          return Redirect::to('dashboard');
        }else{
          return Redirect::to('admin')->send();
      }
    }
  
    public function all_product(){
        $this->AuthLogin();
       // $all_product = DB::table('Product')->get();
        $all_product = DB::table('Product')
        ->join('Designer','Designer.id','=','Product.id_des')
       
        ->select('Product.*', 'Designer.name AS nameDesigner')
        ->orderby('Product.id','desc')->paginate(5);
        $manager_product  = view('admin.product.listproduct')->with('all_product',$all_product);
        return view('admin')->with('admin.product.listproduct', $manager_product );
  
    }
  
      public function addproduct(){
        $this->AuthLogin();
     
        
        $cate_des = DB::table('Designer')->orderby('id','desc')->get(); 
        
        
        $categores1 = DB::table('categores')->where('level', 1)->get();
        $categores2 = DB::table('categores')->where('level', 2)->get();
        $categores3 = DB::table('categores')->where('level', 3)->get();
        
        $manager_product  = view('admin.product.addproduct')->with('cate_des', $cate_des)
        ->with('cate_des', $cate_des)
        ->with('categores1', $categores1)
        ->with('categores2', $categores2)
        ->with('categores3', $categores3);
        return view('admin')->with('admin.product.addproduct', $manager_product );
       
      }
      public function save_product(Request $request){
          $this->AuthLogin();
        //   $this->validate($request,
        //   [
        //       'name' => 'required|unique:Product',
        //       'ma' => 'required|unique:Product',
        //       'id_item' => 'required',
        //       'id_type'=>'required',
        //       'id_des'=>'required',
        //       'id_cus'=>'required',
        //       'pro_stt'=>'required',
        //       'slug'=>'required',
             
        //       'img'=>'required'
        //   ],
    
        //   [
              
        //       'id_type.required' => '*  không được để trống',
        //       'email.email'=>'* Email Chưa đúng định dạng',
        //       'name.unique'=>'* Email đã tồn tại',
        //       'ma.unique'=>'* Email đã tồn tại',
        //       'name.required' => '* Name không được để trống',
        //       'id_item.required' => '* Ngày sinh không được để trống',
        //       'id_des.required' => '* Không được để trống',
        //       'pro_stt.required' => '* Không được để trống',
        //       'slug.required' => '* Đường dẫn đẹp không được để trống',
        //       'id_cus.required' => '* phone không được để trống',
        //       'img.required' => '* Hình ảnh không được để trống',
              
    
        //   ]);
          $product = new ProductModel();
          $product->name = $request->name;
          $product->ma = $request->ma;
          $product->des = $request->des;
          $product->id_des = $request->id_des;
          $product->pro_stt = $request->pro_stt;
         $product->slug =  str_slug($request->name);
          $product->pro_nguyenlieu = $request->pro_nguyenlieu ;
          $product->price = $request->price;  
          $product->price_sale = $request->price_sale;  
          $product->muc = $request->muc; 
          $product->img = $request->img;   
          $get_image = $request->file('img');
      if($get_image){
              $get_name_image = $get_image->getClientOriginalName();
             $name_image = current(explode('.',$get_name_image));
              $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
              $get_image->move('public/Img/product',$new_image);
            $product->img = $new_image;
              $product->save();
              Session::put('message','Thêm ảnh thành công');
             return Redirect::to('all-product');
        } else {
            $product->img = '';   
            $product->save();  
        }
        $categores = DB::table('categores')->get();
        foreach($categores as $data) {
          if ($request['category'.$data->id] != null) {
            $dataCategory = array();
            $dataCategory['id_category'] = $request['category'.$data->id];
            $dataCategory['id_product'] = $product->id;
            DB::table('list_categores')->insert($dataCategory);
          }
        }
        for ($x = 1; $x <= 10; $x++) {
            $size = new SizeModel();
            if(!empty($request['size'.$x])) {
                $size->id_pro = $product->id;
                $size->name = $request['size'.$x];
                $size->soluong = $request['soluong'.$x];
                $size->save();
            }
        }
        //      $data = array();
        //      $data['name'] = $request->name;
        //      $data['ma'] = $request->ma;
        //      $data['des'] = $request->des;
        //      $data['id_item'] = $request->id_item;
        //      $data['id_type'] = $request->id_type;
        //      $data['id_des'] = $request->id_des;
        //      $data['pro_stt'] = $request->pro_stt;
        //     $data['slug'] =  str_slug($request->name);
        //      $data['id_cus'] = $request->id_cus; 
        //      $data['pro_nguyenlieu '] = $request->pro_nguyenlieu ;
        //      $data['img'] = $request->img;  
        //      $get_image = $request->file('img');
          
        //  if($get_image){
        //          $get_name_image = $get_image->getClientOriginalName();
        //         $name_image = current(explode('.',$get_name_image));
        //          $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        //          $get_image->move('public/Img/product',$new_image);
        //        $data['img'] = $new_image;
        //          DB::table('Product')->insert($data);
        //          Session::put('message','Thêm ảnh thành công');
        //         return Redirect::to('all-product');
        //     }
        //      $data['img'] = '';
            // DB::table('Product')->insert($data);
            //  Session::put('message','Thêm người dùng thành công');
            return Redirect::to('all-product');
     
     }
   
    
  
    public function unactive_product($id){
        $this->AuthLogin();
        DB::table('Product')->where('id',$id)->update(['pro_stt'=>1]);
        Session::put('message','Cho phép sản phẩm hiển thi trang chủ');
        return Redirect::to('all-product');
  
    }
    public function active_product($id){
        $this->AuthLogin();
        DB::table('Product')->where('id',$id)->update(['pro_stt'=>0]);
        Session::put('message','Không phép sản phẩm hiển thi trang chủ');
        return Redirect::to('all-product');
    }
      
     public function edit_product($id) {
        $this->AuthLogin();
        $edit_product = DB::table('Product')->where('id', $id)->get();
  
        $manager_product = view('admin.product.editproduct')->with('edit_product', $edit_product);
     
        return view('admin')->with('admin.product.editproduct', $manager_product);
     }
    public function update_product (Request $request, $id) {
        $this->AuthLogin();
        $data = array();
        $data['name'] = $request->name;
        $data['ma'] = $request->ma;
        $data['des'] = $request->des;
        $data['id_des'] = $request->id_des;
        $data['stt'] = $request->stt;
        $data['slug'] =  str_slug($request->name);
        $data['pro_nguyenlieu '] = $request->pro_nguyenlieu ;
        $data['muc'] = $request->muc;  
        $data['img'] = $request->img; 
        $get_image = $request->file('img');
  
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
           $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/Img/product',$new_image);
          $data['img'] = $new_image;
              DB::table('Product')->where('id',$id)->update($data);
              Session::put('message','sửa product thành công');
              return Redirect::to('all-product');
          }
      
          DB::table('Product')->where('id', $id)->update($data);
          Session::put('message', 'Cập nhật sản phẩm thành công');
          return Redirect::to('all-product');
    }
    public function delete_product($id) {
        $this->AuthLogin();
        DB::table('Product')->where('id', $id)->delete();
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    } 
  
     public function Invoicepro($id , Request $request){
        $this->AuthLogin();
       
        $details_product = DB::table('Product')
        ->join('Designer','Designer.id','=','Product.id_des')
        ->where('Product.id',$id)
        ->select('Product.*', 'Designer.name AS nameDesigner')
        ->get();
      
        $details_img = DB::table('Imgs')->where('Imgs.id_pro', $id)->orderby('id', 'desc')->get();
        $details_size = DB::table('size_product')->where('size_product.id_pro', $id)->orderby('id', 'asc')->get();
        $manager_product = view('admin.product.Invoicepro')->with('details_size', $details_size)->with('details_img', $details_img)->with('details_product', $details_product); 
        return view('admin')->with('admin.product.Invoicepro', $manager_product);
  
     }
}

