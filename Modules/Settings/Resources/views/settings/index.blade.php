@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Company-Settings')
@section('content')
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Company Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Company Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Company Settings</h3>
              </div>
              <!-- /.card-header -->
              <form action="{{ route('setting.update', $companySettings->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
              <div class="card-body">
                <div class="form-row">
                  <div class="col-md-4">
                    <div class="position-relative form-group">
                      <label for="name" class="">Company Name</label>
                      <input type="text" name="company_name" class="form-control" id="company_name" placeholder="Enter Name" value="{{ old('company_name', optional($companySettings)->company_name) }}"  required>
                    </div> 
                  </div>
                  <div class="col-md-4">
                    <div class="position-relative form-group">
                        <label for="name" class="">Compnay Phone</label>
                        <input type="text" name="company_phone" id="company_phone" class="form-control" placeholder="Enter Company Phone" value="{{ old('company_phone',optional($companySettings)->company_phone) }}" required>
                    </div>   
                  </div>
                  <div class="col-md-4">
                    <div class="position-relative form-group">
                        <label for="name" class="">Company Email</label>
                        <input type="text" name="company_email" class="form-control" id="company_email" placeholder="Enter Company Email" value="{{ old('company_email',optional($companySettings)->company_email) }}" required>
                    </div>   
                  </div>
                </div>  

                <div class="form-row">
                  <div class="col-md-4">
                    <div class="position-relative form-group">
                      <label for="name" class="">Company Website</label>
                      <input type="text" name="company_website" class="form-control" id="company_website" placeholder="Enter Name" value="{{ old('company_website',optional($companySettings)->company_website) }}"  required>
                    </div> 
                  </div>
                  <div class="col-md-4">
                    <div class="position-relative form-group">
                        <label for="name" class="">Company Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address',optional($companySettings)->address) }}" required>
                    </div>   
                  </div>
                  <div class="col-md-4">
                    <div class="position-relative form-group">
                        <label for="name" class="">Copyright Text</label>
                        <input type="text" name="copyright_text" class="form-control" id="copyright_text" placeholder="Enter Copyright Text" value="{{ old('copyright_text',optional($companySettings)->copyright_text) }}" required>
                    </div>   
                  </div>
                </div>  

                <div class="form-row">
                  <div class="col-md-3">
                    <div class="position-relative form-group">
                        <label for="name" class="">Company Logo</label>
                        <input type="file" class="form-control" name="company_logo" id="Company_logo" onchange="previewFile(this);">
                    </div>   
                  </div>
                  <div class="col-md-3">
                    <img id="previewImg" class="rounded mx-auto d-block mt-3 mb-3" src="{{ url('admin/dist/img/settings',$companySettings->company_logo) }}" alt="Company Logo" height="100px" width="100px"> <br>
                  </div>
                  
                  <div class="col-md-3">
                    <div class="position-relative form-group">
                        <label for="name" class="">Invoice Logo</label>
                        <input type="file" class="form-control" name="invoice_logo" id="invoice_logo" onchange="loadFile(event);">
                    </div>   
                  </div>
                  <div class="col-md-3">
                    <img id="previewInvoice" class="rounded mx-auto d-block mt-3 mb-3" src="{{ url('admin/dist/img/settings',$companySettings->invoice_logo) }}" alt="Company Logo" height="100px" width="100px"> <br>
                  </div> 
                </div>
                 
                          {{--  --}}
                          {{-- <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="name" class="">Company Logo</label>
                                <input type="file" class="form-control" name="company_logo" id="Company_logo" onchange="previewFile(this);">
                            </div>   
                          </div>
                          <div class="col-md-3">
                            <img id="previewImg" class="rounded mx-auto d-block mt-3 mb-3" src="{{ url('admin/dist/img/settings',$companySettings->company_logo) }}" alt="Company Logo" height="100px" width="100px"> <br>
                          </div> --}}
                          {{--  --}}
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">Save Changes</button>
              </div>
            </form>
            </div>
            <!-- /.card -->

            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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