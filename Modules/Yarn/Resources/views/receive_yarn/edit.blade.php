@extends('layouts.admin.dashboard')
@section('title', 'Yarn-update')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Receive Yarn</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Receive Yarn</li>
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
                <h3 class="card-title">Update Receive Yarn</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {!! Form::model($rec_yarn, ['method' => 'PATCH','route' => ['receive_yarn.update', $rec_yarn->id]]) !!}
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" value="{{ $rec_yarn->date }}" required readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select id="party_id" class="form-control" required disabled>
                            <option value=null>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{$party->id}}" @if($party->id == $rec_yarn->party_id) selected @endif>{{$party->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="chalan" class="col-sm-2 col-form-label">Chalan No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $rec_yarn->chalan }}" required readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="gate_pass" class="col-sm-2 col-form-label">Gate pass</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $rec_yarn->gate_pass }}" required readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="brand" class="col-sm-2 col-form-label">Yarn Brand</label>
                    <div class="col-sm-10">
                        <input type="text" name="brand" class="form-control" value="{{ $rec_yarn->brand }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="count" class="col-sm-2 col-form-label">Yarn count</label>
                    <div class="col-sm-10">
                        <input type="text" name="count" class="form-control" value="{{ $rec_yarn->count }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="lot" class="col-sm-2 col-form-label">Yarn lot</label>
                    <div class="col-sm-10">
                        <input type="text" name="lot" class="form-control" value="{{ $rec_yarn->lot }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="quantity" class="col-sm-2 col-form-label">Receiving quantity</label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="quantity" class="form-control" value="{{ $rec_yarn->quantity }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Note</label>
                    <div class="col-sm-10">
                        <input type="text" name="note" class="form-control" value="{{ $rec_yarn->note }}">
                    </div>
                  </div>
                                    
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                  <a href="{{ route('receive_yarn.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
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