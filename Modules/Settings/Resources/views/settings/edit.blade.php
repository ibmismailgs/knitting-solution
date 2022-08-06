@extends('layouts.admin.dashboard')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Bill</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Bill</li>
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
                <h3 class="card-title">Update Bill</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($data, ['method' => 'PATCH','route' => ['bill.update', $data->id]]) !!}
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date" class="form-control" id="date" value="{{$data->date}}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="party_id" id="party_id" class="form-control">
                            <option value=null>Select Party</option>
                            @foreach ($parties as $key => $item)
                                <option value="{{$key}}" @if($key == $data->party_id) selected @endif>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="delivery_id" class="col-sm-2 col-form-label">Delivery Chalan</label>
                    <div class="col-sm-10">
                        <select name="delivery_id" id="delivery_id" class="form-control">
                            <option value=null>Select Delivery Chalan</option>
                            @foreach ($deliveries as $key => $item)
                                <option value="{{$key}}" @if($key == $data->delivery_id) selected @endif>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="bill_no" class="col-sm-2 col-form-label">Bill No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="bill_no" class="form-control" id="bill_no" value="{{$data->bill_no}}" readonly required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="money_rec_no" class="col-sm-2 col-form-label">Money Receive</label>
                    <div class="col-sm-10">
                        <input type="text" name="money_rec_no" class="form-control" id="money_rec_no" value="{{$data->money_rec_no}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="payment_type" class="col-sm-2 col-form-label">Payment Type<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="payment_type" id="payment_type" class="form-control" required>
                            <option value=null>Select Payment Type</option>
                            <option value="1" @if($data->payment_type == 1) selected @endif>Cash</option>
                            <option value="2" @if($data->payment_type == 2) selected @endif>Cheque</option>
                            <option value="3" @if($data->payment_type == 3) selected @endif>LC</option>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="amount" class="col-sm-2 col-form-label">Bill Amount</label>
                    <div class="col-sm-10">
                        <input type="text" name="amount" class="form-control" id="amount" value="{{$data->amount}}">
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