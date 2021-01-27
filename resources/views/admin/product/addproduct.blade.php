@extends('admin')
@section('MvioAdmin')
<!-- Main content -->
<section class="content">
   <div class="card card-primary">
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
         <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert">'.$message.'</span>';
                Session::put('message',null);
            }
            ?>
         <div class="card-body">
            {{ csrf_field() }}
            <div class="row">
               <div class="col-sm-6">
                  <!-- text input -->
                  <div class="form-group">
                     <label>Tên sản phẩm:</label>
                     <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm ...">
                  </div>
               </div>
               <div class="col-sm-6">
                  <!-- text input -->
                  <div class="form-group">
                     <label>Mã sản phẩm:</label>
                     <input type="text" name="ma" class="form-control" placeholder="Mã sản phẩm ...">
                  </div>
               </div>
            </div>
            <div class="row">
            <div class="col-sm-6">
                  <!-- select -->
                  <div class="form-group">
                     <label>Danh mục :</label>
                     <a href="javascript:;" class="form-control" id="button-categores">
                        Lựa chọn danh mục<i style="float:right;margin-right: -8px;margin-top: 5px;font-size: 15px;" class="fas fa-angle-down"></i>
                     </a>
                     <div class="list-categores" style="display:none;">
                        <ul>
                        @foreach($categores1 as $key1=>$data1)
                           <li>
                              <input type="checkbox" id="category{{$data1->id}}" name="category{{$data1->id}}" value="{{$data1->id}}">
                              {{ $data1->name }}
                              @if( $data1->sub_categories == 'co')
                                    <ul style="padding:0 0 0 20px;">
                                    @foreach($categores2 as $key2=>$data2)
                                    @if( $data1->id == $data2->id_category )
                                       <li>
                                          <input type="checkbox" id="category{{$data2->id}}" name="category{{$data2->id}}" value="{{$data1->id}}">
                                          {{ $data2->name }}
                                          @if( $data2->sub_categories == 'co')
                                          <ul style="padding:0 0 0 20px;">
                                          @foreach($categores3 as $key3=>$data3)
                                          @if( $data2->id == $data3->id_category)
                                                <li>
                                                   <input type="checkbox" id="category{{$data3->id}}" name="category{{$data3->id}}" value="{{$data3->id}}">
                                                   {{ $data3->name }}
                                                </li>
                                          @endif
                                          @endforeach
                                          </ul>
                                          @endif
                                       </li>
                                    @endif
                                    @endforeach
                                    </ul>
                              @endif
                           </li>
                        @endforeach
                        </ul>
                     </div>
                  </div>
               </div>
               
       
           
               <div class="col-sm-6">
                  <!-- select -->
                  <div class="form-group">
                     <label>Nhà thiết kế</label>
                     <select class="form-control" name="id_des">
                        @foreach($cate_des as $key => $des)
                        <option value="{{$des->id}}">{{$des->name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
             
            </div>
            <div class="row">
               <div class="col-sm-12">
                  <!-- text input -->
                  <div class="form-group">
                     <label>Mô tả sản phẩm:</label>
                     <input type="text" name="des" class="form-control" placeholder="Mô tả sản phẩm ...">
                  </div>
               </div>
               <div class="col-sm-12">
                  <!-- text input -->
                  <div class="form-group">
                     <label>Nguyên Liệu:</label>
                     <input type="text" name="pro_nguyenlieu" class="form-control" placeholder="Nguyên liệu sản phẩm ...">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6">
                  <!-- text input -->
                  <div class="form-group">
                     <label>Giá gốc:</label>
                     <input type="text" name="price" class="form-control" placeholder="Mô tả sản phẩm ...">
                  </div>
               </div>
               <div class="col-sm-6">
                  <!-- text input -->
                  <div class="form-group">
                     <label>Giá sale:</label>
                     <input type="text" name="price_sale" class="form-control" placeholder="Nguyên liệu sản phẩm ...">
                  </div>
               </div>
            </div>
            <div class="row">
             <div class="col-sm-12">
               <!-- text input -->
               <div class="form-group">
                  <label style="width: 100%;">Size: <a id="add-size" href="javascript:;" style="float: right;">Thêm mới</a></label>
                  <table class="table">
                     <thead id="side_product">
                        <tr>
                           <th>Size</th>
                           <th>Số lượng</th>
                          
                        </tr>
                     </thead>
                     <tbody id="side_product">

                     </tbody>
                  </table>
               </div>
             </div>
            </div>
        
         <div class="row">
            <div class="col-sm-6">
               <!-- text input -->
               <div class="form-group">
                  <label>Loại sản phẩm:</label>
                  <select class="form-control" name="muc">
                     <option value="0">Sản phẩm bán chạy</option>
                     <option value="1">Sản phẩm New</option>
                     <option value="2">Sản phẩm Sele</option>
                  </select>
               </div>
            </div>
            <div class="col-sm-6">
               <!-- text input -->
               <div class="form-group">
                  <label>Kích Hoạt Tài Khoản</label>
                  <select class="form-control" name="pro_stt">
                     <option value="0">Không kích hoạt</option>
                     <option value="1">Kích hoạt</option>
                  </select>
               </div>
            </div>
         </div>
         <div class="form-group">
            <label for="exampleInputFile">Avata</label>
            <div class="input-group">
               <div class="custom-file">
                  <input type="file" name="img" class="custom-file-input" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile"></label>
               </div>
               <div class="input-group-append">
                  <span class="input-group-text">Upload</span>
               </div>
            </div>
         </div>
         <!-- /.card-body -->
         <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
         </div>
      </form>
   </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script>
      $("#button-categores").click(function(){
         $(".list-categores").toggle();
      });
      $(document).ready(function(){
        $dem = 1;
        $("#add-size").click(function(){
          $("#side_product")
          .append
          (' <tr> <td><input type="text" name="size'+ $dem +'" class="form-control" placeholder="size"></td><td><input type="text" name="soluong'+ $dem +'" class="form-control" placeholder="số lượng"></td>  </tr>');
          $dem+=1;
        });
      });
   </script>
  
</section>
<style>
.list-categores {
   max-height: 200px;
    overflow: auto;
    border-radius: 5px;
    border: 1px solid #d2d6dc;
    padding: 10px;
    width: 300px;
    position: absolute;
    z-index: 99999;
    background: #ffffff;
}
</style>
@endsection