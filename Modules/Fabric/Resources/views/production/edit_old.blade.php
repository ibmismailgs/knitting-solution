@extends('layouts.admin.dashboard')
@section('title', 'Fabric-Production-Update')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Production</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Production</li>
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
                <h3 class="card-title">Create Production</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($production, ['method' => 'PATCH','route' => ['production.update', $production->id]]) !!}
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date" class="form-control" id="date" value="{{$production->date}}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="operator_name" class="col-sm-2 col-form-label">Operator Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="operator_name" id="operator_name" class="form-control" required>
                          <option value=null>Select Operator</option>
                          @foreach ($operators as $operator)
                              <option value="{{$operator->id}}" @if ($production->operator_name == $operator->id) selected @endif>{{$operator->name}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="knitting_id" class="col-sm-2 col-form-label">Knitting Program<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="knitting_id" id="knitting_id" class="form-control" required>
                            <option value=null>Select Knitting Program</option>
                            @foreach ($knitting_programs as $program)
                                <option value="{{$program->id}}" @if($program->id == $production->knitting_id) selected @endif>{{$program->stl_order_no."_(".$program->knitting_qty.")"}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="party_id" id="party_id" class="form-control" required>
                            <option value=null>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{$party->id}}" @if($party->id == $production->party_id) selected @endif>{{$party->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="mc_dia" class="col-sm-2 col-form-label">M/C Dia</label>
                    <div class="col-sm-10">
                        <input type="text" name="mc_dia" class="form-control" id="mc_dia" value="{{$production->mc_dia}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="mc_no" class="col-sm-2 col-form-label">M/C No</label>
                    <div class="col-sm-10">
                        <input type="text" name="mc_no" class="form-control" id="mc_no" value="{{$production->mc_no}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="order_qty" class="col-sm-2 col-form-label">Order Quantity<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="order_qty" class="form-control" id="order_qty" value="{{$production->order_qty}}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="shift" class="col-sm-2 col-form-label">Shift</label>
                    <div class="col-sm-10">
                      <select name="shift" id="shift" class="form-control">
                        <option value="1" @if($production->shift == 1) selected @endif>Day</option>
                        <option value="2" @if($production->shift == 2) selected @endif>Night</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="roll" class="col-sm-2 col-form-label">Roll</label>
                    <div class="col-sm-10">
                        <input type="text" name="roll" class="form-control" id="roll" value="{{$production->roll}}">
                    </div>
                  </div>
                  {{-- <div class="form-group row">
                    <label for="kg" class="col-sm-2 col-form-label">KG</label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="kg" class="form-control" id="kg" value="{{$production->kg}}">
                    </div>
                  </div> --}}
                  <div class="form-group row">
                    <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="quantity" class="form-control" id="quantity" value="{{$production->quantity}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="kg" class="col-sm-2 col-form-label">KG</label>
                    <div class="col-sm-10">
                        <input type="number" name="kg" class="form-control" id="kg" value="{{$production->kg}}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="balance" class="col-sm-2 col-form-label">Balance</label>
                    <div class="col-sm-10">
                        <input type="number" name="balance" class="form-control" id="balance" readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="rate" class="col-sm-2 col-form-label">Rate<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="rate" class="form-control" id="rate" value="{{$production->rate}}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                    <div class="col-sm-10">
                        <input type="text" name="amount" class="form-control" id="amount" value="{{$production->amount}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Note</label>
                    <div class="col-sm-10">
                        <input type="text" name="note" class="form-control" id="note" value="{{$production->note}}">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                  <a href="{{ route('production.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
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
$(document).ready(function() {
  calculateBalance();
	$("#kg, #rate").on('input', function(){
      calculateAmount();
  })
  
  $("#quantity, #roll, #order_qty").on('input', function(){
      calculateKg();
      calculateBalance();
  })

    function calculateAmount(){
        var kg = $("#kg").val()*1;
        var rate = $("#rate").val()*1;

        $("#amount").val(kg * rate);
    }

    function calculateKg(){
      var roll = $("#roll").val()*1;
      var qty = $("#quantity").val()*1;

      $("#kg").val(roll * qty);
    }
    
    function calculateBalance(){
      var kg = $("#kg").val()*1;
      var order_qty = $("#order_qty").val()*1;

      $("#balance").val(order_qty - kg);
    }
});
</script>
@endsection