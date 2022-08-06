@extends('layouts.admin.dashboard')
@section('title', 'Fabric-Delivery-Update')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Fabric Delivery</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fabric Delivery</li>
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
                <h3 class="card-title">Update Fabric Delivery</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($data, ['method' => 'PATCH','route' => ['fabric_delivery.update', $data->id]]) !!}
                @csrf
                <input type="hidden" name="delivery_type" value="1">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date" class="form-control" id="date" value="{{$data->date}}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="party_id" id="party_id" class="form-control" required>
                            {{-- <option value=null>Select Party</option> --}}
                            <option value="{{$data->party_id}}">{{$data->party->name}}</option>
                            {{-- @foreach ($parties as $party)
                                <option value="{{$party->id}}" @if($party->id == $data->party_id) selected @endif>{{$party->name}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="chalan" class="col-sm-2 col-form-label">Chalan No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="chalan" class="form-control" id="chalan" value="{{$data->chalan}}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="gate_pass" class="col-sm-2 col-form-label">Gate pass</label>
                    <div class="col-sm-10">
                        <input type="text" name="gate_pass" class="form-control" id="gate_pass" value="{{$data->gate_pass}}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="order_no" class="col-sm-2 col-form-label">Order No</label>
                    <div class="col-sm-10">
                        <input type="text" name="order_no" class="form-control" id="order_no" value="{{$data->order_no}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stl_no" class="col-sm-2 col-form-label">STL No</label>
                    <div class="col-sm-10">
                        <input type="text" name="stl_no" class="form-control" id="stl_no" value="{{$data->stl_no}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="buyer_name" class="col-sm-2 col-form-label">Buyer Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="buyer_name" class="form-control" id="buyer_name" value="{{$data->buyer_name}}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="kg" class="col-sm-2 col-form-label">KG</label>
                    <div class="col-sm-10">
                        <input type="text" name="kg" class="form-control" id="kg" value="{{$data->kg}}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="bill" class="col-sm-2 col-form-label">Bill<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="bill" class="form-control" id="bill" value="{{$data->bill}}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Note</label>
                    <div class="col-sm-10">
                        <input type="text" name="note" class="form-control" id="note" value="{{$data->note}}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="receive_id" class="col-sm-2 col-form-label">Fabric Receive<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="receive_id" id="receive_id" class="form-control" disabled>
                            <option value=null>Select Fabric Receive</option>
                            @foreach ($fab_receives as $receive)
                                <option value="{{$receive->id}}" @if ($data->receive_id == $receive->id) selected @endif>{{$receive->name}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="receive_id" value="{{$data->receive_id}}">
                    </div>
                  </div>
                  <div class="sub-title mt-20"><strong>Receiving Fabric Info</strong></div>
                    <div class="form-block">
                        <div class="form-group">
                            <div class="row">
                                <table class="table table-bordered stripe table-responsive" id="recFabTable">
                                  <tr>
                                    <th>Lot</th>
                                    <th>Count</th>
                                    <th>Roll</th>
                                    <th>Receiving Quantity (Kg)</th>
                                    <th>Stock Quantity (Kg)</th>
                                    <th>Delivery Quantity (Kg)</th>
                                    <th>Roll</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                  </tr>
                                    @foreach ($fab_receive_details as $key => $details)
                                    @php
                                        $stock = DB::table('fabric_receive_details')->where('id',$details->fab_rec_details_id)->first();
                                    @endphp
                                    <tr>
                                      <th>{{ $details->lot }}</th>
                                      <th>{{ $details->count }}</th>
                                      <th>{{ $details->roll }}</th>
                                      <th>{{ $details->receive_quantity }}</th>
                                      <input type="hidden" name="previous_stock[]" value="{{$details->delivery_quantity}}">
                                      <input type="hidden" id="max-input-qty-{{ $key }}" value="{{$stock->stock + $details->delivery_quantity}}">
                                      <th><span>{{ $stock->stock }}</span> (<span>{{ $details->delivery_quantity }}</span>)</th>
                                      <th><input type="number" step="0.01" name="stock_out[]" value="{{ $details->delivery_quantity }}" id="del_quantity-{{ $key }}" onkeyup="claculate({{ $key }})"></th>
                                      <th><input type="number" name="roll[]" value="{{$details->delivery_roll}}"></th>
                                      <th><input type="text" name="rate[]" value="{{ $details->rate }}" id="rate-{{ $key }}" onkeyup="claculate({{ $key }})"></th>
                                      <th><input type="text" value="{{ $details->amount }}" id="amount-{{ $key }}" readonly></th>
                                      <input type="hidden" name="rec_fab_id[]" value="{{$details->rec_fab_id}}">
                                      <input type="hidden" name="fab_rec_details_id[]" value="{{$details->fab_rec_details_id}}">
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                  <a href="{{ route('fabric_delivery.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
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

  // getReceiveInfo();

  $("#receive_id").on('change', function(){
    getReceiveInfo()
  })

  function getReceiveInfo(){
    var rec_id = $("#receive_id").val();
      var url = "{{ url('fabric/get-fab-rec-details') }}";
          $.ajax({
              type: "get",
              url: url,
              data: {
                  id: rec_id
              },
              success: function(data) {
                var html = "<tr><th>Lot</th><th>Count</th><th>Roll</th><th>Quantity (Kg)</th><th>Delivery Quantity</th><th>Rate</th></tr>";
                    $("#recFabTable").empty();
                    $.each(data.recFabric, function(key) {
                      console.log(data.recFabric[key]);
                      html += '<tr>';
                      html += '<input type="hidden" name="rec_fab_id[]" value='+data.recFabric[key].fab_rec_id+'>';
                      html += '<td> '+data.recFabric[key].lot+' </td>';
                      html += '<td> '+data.recFabric[key].count+' </td> ';
                      html += '<td> '+data.recFabric[key].roll+' </td> ';
                      html += '<td> '+data.recFabric[key].quantity+' </td> ';
                      html += '<td> <input type="number" name="stock_out[]" id="quantity-'+key+'" oninput="calculateBill('+key+')"> </td> ';
                      html += '<td> <input type="number" name="rate[]" id="rate-'+key+'" oninput="calculateBill('+key+')"> </td> ';
                      html += '<tr>';
                    })
                    $("#recFabTable").append(html);
                    html = "";
                }
           })
  }
});

function claculate(key){
    var qty = $('#del_quantity-' + key).val()*1;
    var rate = $('#rate-' + key).val()*1;

    $('#amount-' + key).val(qty * rate);
    checkValidation(key);
  }

  function checkValidation(key){
    var rec_qty = parseFloat($('#max-input-qty-' + key).val()*1);
    var del_qty = $('#del_quantity-' + key).val()*1;

    if(del_qty > rec_qty){
      $('#del_quantity-' + key).css('background-color', 'red');
      $("#submit").prop("disabled",true);
      alert('Delivery quantity can not more than receiving quantity');
    }else{
      $('#del_quantity-' + key).css('background-color', 'green');
      $("#submit").removeAttr('disabled');
    }
}
</script>
@endsection
