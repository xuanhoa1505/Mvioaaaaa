@extends('admin')
@section('MvioAdmin')
  

    <!-- Main content -->
    <section class="content">
    <div class="card card-primary">
              
              <!-- /.card-header -->
              <!-- form start -->
              @foreach($edit_product as $key => $data)
            <form action="{{URL::to('/update-product/'.$data->id)}}" method="post" enctype="multipart/form-data">	
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
                        <label>Tên người dùng:</label>
                        <input type="text" name="name" class="form-control" value="{{$data->name}}">
                      </div>
                    </div>
                  
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              @endforeach
            </div>
    </section>
@endsection