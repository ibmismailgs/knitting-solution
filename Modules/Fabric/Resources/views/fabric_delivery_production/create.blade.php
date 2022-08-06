@extends('layouts.admin.dashboard')
@section('title', 'Fabric-P-Delivery-Create')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Fabric Delivery</h1>
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
                <h3 class="card-title">Create Fabric Delivery</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('fabric_delivery.prod.store') }}" method="POST">
                @csrf
                <input type="hidden" name="delivery_type" value="2">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date" class="form-control" id="date" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="party_id" id="party_id" class="form-control" required>
                            <option value=null>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{$party->id}}">{{$party->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="knitting" class="col-sm-2 col-form-label">Knitting Program<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="knitting_id" id="knitting_id" class="select2" multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                            {{-- <option value=null>Select Knitting Program</option>
                            @foreach ($knitting_programs as $knitting)
                                <option value="{{$knitting->id}}">{{$knitting->stl_order_no."_(".$knitting->knitting_qty.")"}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="chalan" class="col-sm-2 col-form-label">Chalan No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="chalan" class="form-control" id="chalan" value="PFD-{{$feb_delivery+1}}" required readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="gate_pass" class="col-sm-2 col-form-label">Gate pass</label>
                    <div class="col-sm-10">
                        <input type="text" name="gate_pass" class="form-control" id="gate_pass" value="PFD-{{$feb_delivery+1}}" required readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="order_no" class="col-sm-2 col-form-label">Order No</label>
                    <div class="col-sm-10">
                        <input type="text" name="order_no" class="form-control" id="order_no" value="PFD-{{$feb_delivery+1}}" required readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="driver" class="col-sm-2 col-form-label">Driver<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="driver" placeholder="Enter driver name" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stock_out" class="col-sm-2 col-form-label">Truck Number<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text"  name="truck_number" class="form-control" placeholder="Enter truck number" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Note</label>
                    <div class="col-sm-10">
                        <input type="text" name="note" class="form-control" id="note" placeholder="Enter note">
                    </div>
                  </div>

                  <div class="sub-title mt-20"><strong>Production Info</strong></div>

                        <div class="form-group">
                            <div class="row">
                                <table class="table table-bordered stripe table-responsive" id="recFabTable">

                                </table>
                            </div>
                        </div>

                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right" id="submit">Submit</button>
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
              console.log(data);
                var html = "<option value="+null+">Select Knitting Program</option>";
                $("#knitting_id").empty();
                $.each(data.knittingInfo, function(id, data) {
                   //alert(data);
                   html += "<option value="+data.id+">"+data.stl_order_no+'_( '+data.knitting_qty+' )'+"</option>";
                })
                $("#knitting_id").append(html);
                html = "";
            }
        })
    }

    $("#knitting_id").on('change', function(){
      var rec_id = $("#knitting_id").val();
      //alert(rec_id);
      var url = "{{ url('fabric/get-yarn-knitting-details') }}";
          $.ajax({
              type: "get",
              url: url,
              data: {
                  id: rec_id
              },
              success: function(data) {
                //console.log(data.productionInfo[0]);
                var party = $("#party_id").val();
                //console.log(data.knittingInfo);
                var html = "<tr><th>STL Order No</th><th>Rate</th><th>Available Quantity</th><th>Available Roll</th><th>Roll</th><th>Dia/Gauge</th><th>Delivery Quantity</th><th>Amount</th></tr>";
                    $("#recFabTable").empty();
                    $.each(data.knittingInfo, function(key) {
                      var stock = data.productionInfo[key] - data.deliveryInfo[key];
                      var roll = data.producedRollInfo[key] - data.deliverdRollInfo[key];
                      html += '<tr>';
                      html += '<input type="hidden" name="knitting_id[]" value='+data.knittingInfo[key].knitting_id+'>';
                      html += '<input type="hidden" name="yarn_knitting_details_id[]" value='+data.knittingInfo[key].id+'>';
                      html += '<input type="hidden" name="party_id" value='+party+'>';
                      html += '<td> '+data.knittingInfo[key].stl_order_no+' </td>';
                      html += '<td> <span>'+data.knittingInfo[key].rate+'</span> <input type="hidden" name="rate[]" id="rate-'+key+'" value="'+data.knittingInfo[key].rate+'"></td> ';
                      html += '<td> <span id="stk_quantity-'+key+'">'+data.knittingInfo[key].knitting_qty+' ( '+ stock + ')'+'</span></td> ';

                      html += '<td> <span id="stk_roll-'+key+'">'+roll+'</span></td> ';

                      html += '<input type="hidden" name="roll_available[]" id="roll_available-'+key+'" value='+roll+'>';

                      html += '<td> <input type="text" oninput="checkRollValidation('+key+')" id="roll-'+key+'" name="roll[]"> </td> ';

                      html += '<td> <input type="text" name="dia_gauza[]" value="'+data.knittingInfo[key].mc_dia+'" readonly> </td> ';

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
</script>

<script>
      function checkRollValidation(key){
      var roll_available = $('#roll_available-' + key).val()*1;
      var del_roll = $('#roll-' + key).val()*1;
      if(del_roll > roll_available){
        $('#roll-' + key).css('background-color', 'red');
        $('#roll-' + key).val(null);
        $("#submit").prop("disabled",true);
        alert('Delivery roll can not more than available roll');
      }else{
        $('#roll-' + key).css('background-color', 'green');
        $("#submit").removeAttr('disabled');
      }
}
</script>
@endsection
