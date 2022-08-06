@extends('layouts.admin.dashboard')
@section('title', 'Yarn-Return-update')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Return Yarn</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Return Yarn</li>
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
                <h3 class="card-title">Edit Return Yarn</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('return_yarn.storeYearn') }}" method="POST">
                {{-- {!! Form::model($ret_yarn_first, ['method' => 'PATCH','route' => ['return_yarn.update', $ret_yarn_first->ret_chalan]]) !!} --}}
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="hidden" name="ret_chalan" value="{{$ret_yarn_first->ret_chalan}}">
                        <input type="date" name="date" class="form-control" id="date" value="{{$ret_yarn_first->date}}" required readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="ret_chalan" class="col-sm-2 col-form-label">Return Chalan No</label>
                    <div class="col-sm-10" id="ret_chalan">
                        <input type="text" name="ret_chalan" class="form-control" value="{{$ret_yarn_first->ret_chalan}}" placeholder="Enter chalan no" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="ret_gate_pass" class="col-sm-2 col-form-label">Return Gate pass</label>
                    <div class="col-sm-10" id="ret_gate_pass">
                        <input type="text" name="ret_gate_pass" class="form-control" value="{{$ret_yarn_first->ret_gate_pass}}" placeholder="Enter Gate pass" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="hidden" name="party_id" value="{{$ret_yarn_first->party->id}}">
                        <input type="text" class="form-control" value="{{$ret_yarn_first->party->name}}" placeholder="Enter Gate pass" readonly>
                        {{-- <select name="party_id" id="party_id" class="form-control" required readonly>
                            <option value=null>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{$party->id}}" {{($party->id == $return_yarns[0]->party_id) ? 'selected':''}}>{{$party->name}}</option>
                            @endforeach
                        </select> --}}
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="driver" class="col-sm-2 col-form-label">Driver<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="driver" value="{{$ret_yarn_first->driver}}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="stock_out" class="col-sm-2 col-form-label">Truck Number<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text"  name="truck_number" class="form-control" value="{{$ret_yarn_first->truck_number}}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="chalan" class="col-sm-2 col-form-label">Chalan No<span class="text-danger">*</span></label>
                    <div class="col-sm-10 select2-purple">
                        <select name="chalan" id="chalan" class="select2" multiple="multiple"  data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;" disabled>
                            @foreach ($challan as $item)
                                 <option value="{{ $item }}" selected>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>

                    <div class="sub-title mt-20"><strong>Receiving Yarn Info</strong></div>
                    <div class="form-block">
                        <div class="form-group">
                            <div class="row">
                                <table class="table table-bordered stripe" id="recYarnTable">
                                    <tr>
                                        <th>Gate pass</th>
                                        <th>Brand</th>
                                        <th>Yarn count</th>
                                        <th>Yarn lot</th>
                                        <th>Receiving quantity</th>
                                        <th>Receiving roll</th>
                                        <th>Stock quantity</th>
                                        <th>Roll</th>
                                        <th>Return Quantity</th>
                                    </tr>
                                    @foreach($return_yarns as $key=>$yearn)
                                    <tr>
                                        <td>{{ $yearn->receiveYarn->gate_pass }}</td>
                                        <td>{{ $yearn->receiveYarn->brand }}</td>
                                        <td>{{ $yearn->receiveYarn->count }}</td>
                                        <td>{{ $yearn->receiveYarn->lot }}</td>
                                        <td>{{ $yearn->receiveYarn->quantity }}</td>
                                        <td>{{ $yearn->receiveYarn->roll }}</td>
                                        <td>{{ $total_stock[$key] }} </td>
                                        <td>
                                            <input type="hidden" id="old_roll{{$key}}"  name="roll[]" value={{ $yearn->receiveYarn->roll }}>
                                            <input type="number" id="roll-{{$key}}" oninput="RollValidation({{$key}})" step="0.10" name="roll[]" value={{ $yearn->roll }}> </td>
                                        <td>
                                             <input type="hidden" id="max-quantity-{{$key}}" value="{{  $total_stock[$key] }}">
                                            <input type="hidden" name="rec_yarn_id[]" value="{{$yearn->receive_id}}">
                                            <input type="hidden" id="quantity-{{$key}}" name="previous_stock_out[]" value="{{$yearn->quantity}}">
                                            <input type="number" step="0.01" name="stock_out[]" value="{{$yearn->quantity}}" id="stock_out-{{$key}}" oninput="checkValidation({{$key}})">
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right" id="submit">Submit</button>
                  <a href="{{ route('return_yarn.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
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
        function checkValidation(key)
        {
          var qty = $('#max-quantity-' + key).val()*1;
          var stock_out = $('#stock_out-' + key).val()*1;
          if(stock_out > qty){
            $('#stock_out-' + key).css('background-color', 'red');
            $("#submit").prop("disabled",true);
          }else{
            $('#stock_out-' + key).css('background-color', 'green');
            $("#submit").removeAttr('disabled');
          }
        }
    </script>

    <script>
        function RollValidation(key)
        {
          var pre_roll = $('#old_roll' + key).val()*1;
          var roll = $('#roll-' + key).val()*1;
          if(roll > pre_roll){
            $('#roll-' + key).css('background-color', 'red');
            $("#submit").prop("disabled",true);
          }else{
            $('#roll-' + key).css('background-color', 'green');
            $("#submit").removeAttr('disabled');
          }
        }
    </script>
@endsection
