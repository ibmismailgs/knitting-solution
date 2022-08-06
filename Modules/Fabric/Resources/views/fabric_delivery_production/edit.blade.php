@extends('layouts.admin.dashboard')
@section('title', 'Fabric-P-Delivery-Update')
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
              {!! Form::model($data, ['method' => 'PATCH','route' => ['fabric_delivery.prod.update', $data->id]]) !!}
                @csrf
                <input type="hidden" name="delivery_type" value="2">
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
                            <option value=null>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{$party->id}}" @if($party->id == $data->party_id) selected @endif>{{$party->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="knitting_id" class="col-sm-2 col-form-label">Knitting Program<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                      <input type="hidden" name="knitting_id">
                        <select disabled id="knitting_id" class="select2" multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                          @foreach ($knitting_programs as $knitting)
                              <option value="{{$knitting->id}}" <?php echo (isset($knitting_id) && in_array($knitting->id, $knitting_id) ) ? 'selected="selected"' : "" ?> readonly>
                                {{$knitting->stl_order_no."_(".$knitting->knitting_qty.")"}}
                              </option>
                          @endforeach
                        </select>
                    </div>
                  </div>

                  {{-- <div class="form-group row">
                    <label for="available_qty" class="col-sm-2 col-form-label">Available Quantity<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="available_qty" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stock_out" class="col-sm-2 col-form-label">Delivery Quantity<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="kg" class="form-control" id="stock_out" value="{{$data->kg}}" required>
                    </div>
                  </div> --}}

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


                  {{-- <div class="form-group row">
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
                    <label for="rate" class="col-sm-2 col-form-label">Rate<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="rate" class="form-control" id="rate" value="{{$data->rate}}">
                    </div>
                  </div> --}}


                  <div class="form-group row">
                    <label for="bill" class="col-sm-2 col-form-label">Bill<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="bill" class="form-control" id="bill" value="{{$data->bill}}" readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="driver" class="col-sm-2 col-form-label">Driver<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="driver" value="{{$data->driver}}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stock_out" class="col-sm-2 col-form-label">Truck Number<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text"  name="truck_number" class="form-control" value="{{$data->truck_number}}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Note</label>
                    <div class="col-sm-10">
                        <input type="text" name="note" class="form-control" id="note" value="{{$data->note}}">
                    </div>
                  </div>

                  <div class="sub-title mt-20"><strong>Production Info</strong></div>
                    <div class="form-block">
                        <div class="form-group">
                            <div class="row">
                                <table class="table table-bordered table-responsive" id="recFabTable">
                                  <tr>
                                      <th>STL Order No</th>
                                      <th>Rate</th>
                                      <th>Available Quantity</th>
                                      <th>Available Roll</th>
                                      <th>Roll</th>
                                      <th>Dia/Gauge</th>
                                      <th>Delivery Quantity</th>
                                      <th>Amount</th>
                                  </tr>
                                  @foreach ($knitting_programs as $key=>$knitting)
                                  @php
                                      $stock = $collectProducttion[$key] - $collectDelivery[$key];
                                  @endphp
                                    <tr>
                                      <td>{{ $knitting->stl_order_no }}</td>
                                      <td>{{ $knitting->rate }}</td>
                                      <td>{{ $knitting->knitting_qty }} ({{ $stock+$delivery_details[$key]->quantity }})</td>
                                      <td>{{$totalRollDelivery[$key]}}</td>
                                      <input type="hidden" name="knitting_id[]" value={{ $knitting->knitting_id }}>
                                      <input type="hidden" name="yarn_knitting_details_id[]" value={{ $knitting->id }}>
                                      <input type="hidden" id="old_roll{{$key}}" value="{{$totalRollDelivery[$key]}}">
                                      <input type="hidden" name="party_id" value={{ $knitting->party_id }}>
                                      <th><input type="text" id="stock_roll{{$key}}" oninput="checkRollValidation({{$key}})" name="roll[]" value={{ $delivery_details[$key]->roll }}></th>
                                      <input type="hidden" name="stock_abailable[]" id="stock-{{ $key }}" value={{ $stock+$delivery_details[$key]->quantity }}>
                                      <input type="hidden" name="rate[]" id="rate-{{ $key }}" value="{{ $knitting->rate }}">
                                      <th><input type="text" name="dia_gauza[]" value={{ $delivery_details[$key]->dia_gauza }}></th>
                                      <th><input type="number" step="0.01" name="stock_out[]" value="{{ $delivery_details[$key]->quantity }}" id="quantity-{{ $key }}" oninput="calculateBill({{ $key }})"></th>
                                      <th><input type="number" step="0.01" name="amount[]" value="{{ $delivery_details[$key]->amount }}" id="amount-{{ $key }}"></th>
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
    $("#party_id").on('change', function() {
        var party = $("#party_id").val();
        $("#recFabTable").empty();
        getPartyKnittingInfo(party);
    })

    function getPartyKnittingInfo(prty_id) {
        var party_id = prty_id;
        var url = "{{ url('fabric/party_knitting_info') }}";
        //alert(party_id);
        $.ajax({
            type: "get",
            url: url,
            data: {
                id: party_id
            },
            success: function(data) {
              //console.log(data);
                var html = "<option value="+null+">Select Knitting Program</option>";
                $("#knitting_id").empty();
                $.each(data.knittingInfo, function(id, data) {
                   console.log(name);
                    html += "<option value="+data.id+">"+data.stl_order_no+'_( '+data.knitting_qty+' )'+"</option>";
                })
                $("#knitting_id").append(html);
                html = "";
            }
        })
    }

    $("#knitting_id").on('change', function(){
      var rec_id = $("#knitting_id").val();
      var url = "{{ url('fabric/get-yarn-knitting-details') }}";
          $.ajax({
              type: "get",
              url: url,
              data: {
                  id: rec_id
              },
              success: function(data) {
                console.log(data.productionInfo[0]);
                var party = $("#party_id").val();
                console.log(data.knittingInfo);
                var html = "<tr><th>STL Order No</th><th>Rate</th><th>Available Quantity</th><th>Roll</th><th>Dia/Gauge</th><th>Delivery Quantity</th><th>Amount</th></tr>";
                    $("#recFabTable").empty();
                    $.each(data.knittingInfo, function(key) {
                      var stock = data.productionInfo[key] - data.deliveryInfo[key];
                      html += '<tr>';
                      html += '<input type="hidden" name="knitting_id[]" value='+data.knittingInfo[key].knitting_id+'>';
                      html += '<input type="hidden" name="yarn_knitting_details_id[]" value='+data.knittingInfo[key].id+'>';
                      html += '<input type="hidden" name="party_id" value='+party+'>';
                      html += '<td> '+data.knittingInfo[key].stl_order_no+' </td>';
                      html += '<td> <span>'+data.knittingInfo[key].rate+'</span> <input type="hidden" name="rate[]" id="rate-'+key+'" value="'+data.knittingInfo[key].rate+'"></td> ';
                      html += '<td> <span id="stk_quantity-'+key+'">'+data.knittingInfo[key].knitting_qty+' ( '+ stock + ')'+'</span></td> ';
                      html += '<td> <input type="text" name="roll[]"> </td> ';
                      html += '<td> <input type="text" name="dia_gauza[]"> </td> ';
                      html += '<input type="hidden" name="stock_abailable[]" id="stock-'+key+'" value='+stock+'>';
                      html += '<td> <input type="number" step="0.01" name="stock_out[]" id="quantity-'+key+'" oninput="calculateBill('+key+')"> </td> ';
                      html += '<td> <input type="number" step="0.01" name="amount[]" id="amount-'+key+'"> </td> ';
                      html += '<tr>';
                    })
                    $("#recFabTable").append(html);
                    html = "";

                }
           })
     })
  });
  function calculateBill(key){
      var qty = $('#quantity-' + key).val()*1;
      var rate = $('#rate-' + key).val()*1;

      var amount = $('#amount-' + key).val(qty * rate);
      console.log(amount);
      checkValidation(key);
    }

  function checkValidation(key){
      var stock_qty = $('#stock-' + key).val()*1;
      var del_qty = $('#quantity-' + key).val()*1;
      if(del_qty > stock_qty){
        $('#quantity-' + key).css('background-color', 'red');
        $('#quantity-' + key).val(null);
        $("#submit").prop("disabled",true);
        alert('Delivery quantity can not more than stock quantity');
      }else{
        $('#quantity-' + key).css('background-color', 'green');
        $("#submit").removeAttr('disabled');
      }
}
  function checkRollValidation(key){
      var stock_roll = $('#old_roll' + key).val()*1;
      var del_roll = $('#stock_roll' + key).val()*1;
      if(del_roll > stock_roll){
        $('#stock_roll' + key).css('background-color', 'red');
        $('#stock_roll' + key).val(null);
        $("#submit").prop("disabled",true);
        alert('Delivery roll can not more than stock roll');
      }else{
        $('#stock_roll' + key).css('background-color', 'green');
        $("#submit").removeAttr('disabled');
      }
}

// function checkRollValidation(key){
//             var currentyarn = $('#currentyarn').val();
//             var return_quantity = $('#return_quantity').val();
//             var current_yarn=parseInt(currentyarn);
//             var return_yarn_quantity=parseInt(return_quantity);

//         if(return_yarn_quantity > current_yarn){
//             alert('Whoops! Yarn return quantity can not be more than available yarn current stock');
//         $('#return_quantity').val(null);
//       }
//     }

</script>
<script>
$(document).ready(function() {
    calculateAvailable();
    $('#knitting_id').on('change',function(){
       calculateAvailable();
    });

    $("#stock_out, #rate").on('input', function(){
        calculateAmount();
    })

    function calculateAvailable(){
      var knitting_id = $("#knitting_id").val();
             var url = "{{ url('fabric/get-knitting-details') }}";

        $.ajax({
            type: "get",
            url: url,
            data: {
                id: knitting_id
            },
            success: function(data) {
              var currentQty = $("#stock_out").val();
            $("#available_qty").val(data.available - (- currentQty));
            $("#stl_no").val(data.stl_no);
            $("#buyer_name").val(data.buyer_name);
            $("#rate").val(data.rate);
        }
        });
    }

    function calculateAmount(){
        var qty = $("#stock_out").val()*1;
        var rate = $("#rate").val()*1;
        if(qty > 0){
            $("#kg").val(qty);
            $("#bill").val(qty * rate);
        }else{
            alert("Please enter delivery quantity!");
        }

    }
});

function claculate(key){
    var qty = $('#del_quantity-' + key).val()*1;
    var rate = $('#rate-' + key).val()*1;

    $('#amount-' + key).val(qty * rate);
  }
</script>
@endsection
