@extends('layouts.admin.dashboard')
@section('title', 'Party-create')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Party</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create Party</li>
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
                <h3 class="card-title">Create Party</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('party.store') }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" value="{{ old('name') }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stl_no" class="col-sm-2 col-form-label">STL No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="stl_no" class="form-control" id="stl_no" placeholder="Enter stl no" value="{{  $new_stl_no }}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="contact_person" class="col-sm-2 col-form-label">Contact Person</label>
                    <div class="col-sm-10">
                        <input type="text" name="contact_person" class="form-control" id="contact_person" value="{{ old('contact_person') }}" placeholder="Enter contact person">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="designation" class="col-sm-2 col-form-label">Designation</label>
                    <div class="col-sm-10">
                        <input type="text" name="designation" class="form-control" id="designation" value="{{ old('designation') }}" placeholder="Enter designation">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}" placeholder="Enter phone" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Enter email">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}" placeholder="Enter address">
                    </div>
                  </div>                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                  <a href="{{ route('party.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
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