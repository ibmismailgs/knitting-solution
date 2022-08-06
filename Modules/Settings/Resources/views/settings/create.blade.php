@extends('layouts.admin.dashboard')
@section('title', 'Company-Settings')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
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
                <h3 class="card-title">New Settings</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('setting.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                  <div class="form-row">

                    <div class="col-md-4">
                      <div class="position-relative form-group">
                        <label for="name" class="">Company Name</label>
                        <input type="text" name="company_name" class="form-control" id="date" placeholder="Enter Company Name" value="{{ old('company_name') }}"  required>
                      </div> 
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="name" class="">Compnay Phone</label>
                          <input type="text" name="company_phone" id="company_phone" class="form-control" placeholder="Enter Company Phone" value="{{ old('company_phone') }}" required>
                      </div>   
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="name" class="">Company Email</label>
                          <input type="email" name="company_email" class="form-control" id="company_email" placeholder="Enter Company Email" value="{{ old('company_email') }}" required>
                      </div>   
                    </div>

                  </div>  

                  <div class="form-row">
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                        <label for="name" class="">Company Website</label>
                        <input type="text" name="company_website" class="form-control" id="company_website" placeholder="Enter Website Name" value="{{ old('company_website') }}"  required>
                      </div> 
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="name" class="">Company Address</label>
                          <input type="text" name="address" id="address" class="form-control" placeholder="Enter Company Address" value="{{ old('address') }}" required>
                      </div>   
                    </div>
                    <div class="col-md-4">
                      <div class="position-relative form-group">
                          <label for="name" class="">Copyright Text</label>
                          <input type="text" name="copyright_text" class="form-control" id="copyright_text" placeholder="Enter Copyright Text" value="{{ old('copyright_text') }}" required>
                      </div>   
                    </div> 
                  </div> 

                  <div class="form-row">
                   <div class="col-md-6">
                      <div class="position-relative form-group">
                          <label for="name" class="">Company Logo</label>
                          <input type="file" class="form-control" name="company_logo" id="Company_logo" onchange="previewFile(this);">
                          {{-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> --}}
                      </div>   
                    </div>
                    <div class="col-md-6">
                      <img id="previewImg" class="rounded mx-auto d-block mt-3 mb-3" src="{{ asset('admin/dist/img/') }}" alt="Company Logo" height="150px" width="150px"> <br>
                    </div>

                  </div>
                  
                  <div class="form-row">
                    <div class="col-md-6">
                       <div class="position-relative form-group">
                           <label for="name" class="">Company Logo</label>
                           <input type="file" class="form-control" name="invoice_logo" id="invoice_logo" onchange="loadFile(event);">
                           {{-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> --}}
                       </div>   
                     </div>
                     <div class="col-md-6">
                       <img id="previewInvoice" class="rounded mx-auto d-block mt-3 mb-3" src="{{ asset('admin/dist/img/') }}" alt="Company Logo" height="150px" width="150px"> <br>
                     </div>
 
                   </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                  <a href="{{ route('bill.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
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
  var loadFile = function(event) {
      var output = document.getElementById('previewInvoice');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
      }
  }
</script>
@endsection