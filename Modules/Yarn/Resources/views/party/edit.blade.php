@extends('layouts.admin.dashboard')
@section('title', 'Party-update')
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
              {!! Form::model($party, ['method' => 'PATCH','route' => ['party.update', $party->id]]) !!}
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="name" value="{{ $party->name }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stl_no" class="col-sm-2 col-form-label">STL No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="stl_no" class="form-control" id="stl_no" value="{{ $party->stl_no }}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="contact_person" class="col-sm-2 col-form-label">Contact Person</label>
                    <div class="col-sm-10">
                        <input type="text" name="contact_person" class="form-control" id="contact_person" value="{{ $party->contact_person }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="designation" class="col-sm-2 col-form-label">Designation</label>
                    <div class="col-sm-10">
                        <input type="text" name="designation" class="form-control" id="designation" value="{{ $party->designation }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="phone" class="form-control" id="phone" value="{{ $party->phone }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="email" value="{{ $party->email }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" name="address" class="form-control" id="address" value="{{ $party->address }}">
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