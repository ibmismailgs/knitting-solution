@extends('layouts.admin.dashboard')
@section('title', 'Employee-update')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Employee</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Employee</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($employee, ['method' => 'PATCH','enctype'=>'multipart/form-data','route' => ['employee.update', $employee->id]])  !!}
                @csrf
                <div class="card-body">
                  <div class="form-row">
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                        <label for="name" class="">Employee Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter EMployee Name" value="{{ old('name',optional($employee)->name) }}"  required>
                      </div> 
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="phone" class="">Phone</label>
                          <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Employee Phone" value="{{ old('phone',optional($employee)->phone) }}" required>
                      </div>   
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="name" class="">Date Of Birth</label>
                          <input type="date" name="dob" class="form-control" id="dob" placeholder="Enter Birth Date" value="{{ old('dob',optional($employee)->dob) }}" required>
                      </div>   
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                        <label for="email" class="">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old('email',optional($employee)->email) }}"  required>
                      </div> 
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                        <label for="f_name" class="">Father's Name</label>
                        <input type="text" name="f_name" class="form-control" id="f_name" placeholder="Enter Father's Name" value="{{ old('f_name',optional($employee)->f_name) }}"  required>
                      </div> 
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="m_name" class="">Mother's Name</label>
                          <input type="text" name="m_name" id="m_name" class="form-control" placeholder="Enter Mother's Phone" value="{{ old('m_name',optional($employee)->m_name) }}" required>
                      </div>   
                    </div>

                  </div> 
                  <div class="form-row">
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="nid" class="">NID</label>
                          <input type="text" name="nid" class="form-control" id="nid" placeholder="Enter NID Number" value="{{ old('nid',optional($employee)->nid) }}" required>
                      </div>   
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                        <label for="present_address" class="">Present Address</label>
                        <input type="text" name="present_address" class="form-control" id="present_address" placeholder="Enter Present Address" value="{{ old('present_address',optional($employee)->present_address) }}"  required>
                      </div> 
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="permanent_address" class="">Permanent Address</label>
                          <input type="text" name="permanent_address" id="permanent_address" class="form-control" placeholder="Enter Permanent Address" value="{{ old('permanent_address',optional($employee)->permanent_address) }}" required>
                      </div>   
                    </div>
                  </div> 
                  <div class="form-row">
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="join_date" class="">Joining Date</label>
                          <input type="date" name="join_date" class="form-control" id="join_date" placeholder="Enter Joining Date" value="{{ old('join_date',optional($employee)->join_date) }}" required>
                      </div>   
                    </div>
                    <div class="col-md-4">
                       <div class="position-relative form-group">
                           <label for="name" class="">Employee Photo</label>
                           <input type="file" class="form-control" name="image" id="image" onchange="previewFile(this);">
                           {{-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> --}}
                       </div>   
                     </div>
                     <div class="col-md-4">
                       <img id="previewImg" class="rounded mx-auto d-block mt-3 mb-3" src="{{ url('admin/employee_img',$employee->image) }}" alt="Employee Photo" height="200px" width="180px"> <br>
                     </div>
                   </div> 
                   {{-- <label for="vehicle1">Add User</label><br>
                   <input type="checkbox" id="add_user" name="add_user" value="1">
                   <hr>
                   <div class="form-row" id="user_access">
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                        <label for="name">Role</label>
                        <select name="roles" id="role" class="form-control">
                            <option value=null>Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{$role}}">{{$role}}</option>
                            @endforeach
                        </select>
                      </div> 
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                        <label for="password" class="">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" value="{{ old('password') }}" >
                      </div> 
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="password_confirmation" class="">Confirm Password</label>
                          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Enter Permanent Address" autocomplete="new-password">
                      </div>   
                    </div>
                  </div>  --}}
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                  <a href="{{ route('employee.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
@section('script')
<script>
  function previewFile(input){
      var file = $("input[type=file]").get(0).files[0];

      if(file){
          var reader = new FileReader();

          reader.onload = function(){
              $("#previewImg").attr("src", reader.result);
          }

          reader.readAsDataURL(file);
      }
  }
</script>
@endsection