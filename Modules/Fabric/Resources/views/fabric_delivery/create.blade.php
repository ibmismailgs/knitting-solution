@extends('layouts.admin.dashboard')
@section('title', 'Fabric-Delivery-Create')
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
              <form action="{{ route('fabric_delivery.store') }}" method="POST">
                @csrf
                <input type="hidden" name="delivery_type" value="1">
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
                        <select name="party_id" id="party_id" class="form-control" required="required">
                            <option>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{$party->id}}">{{$party->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="chalan" class="col-sm-2 col-form-label">Chalan No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="chalan" class="form-control" id="chalan" value="RFD-{{$feb_delivery}}" required readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="gate_pass" class="col-sm-2 col-form-label">Gate pass<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="gate_pass" class="form-control" id="gate_pass" value="RFD-{{$feb_delivery}}" required readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="order_no" class="col-sm-2 col-form-label">Order No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="order_no" class="form-control" id="order_no" value="RFD-{{$feb_delivery}}" required readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stl_no" class="col-sm-2 col-form-label">STL No</label>
                    <div class="col-sm-10">
                        <input type="text" name="stl_no" class="form-control" id="stl_no" placeholder="Enter stl no" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="buyer_name" class="col-sm-2 col-form-label">Buyer Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="buyer_name" class="form-control" id="buyer_name" placeholder="Enter Buyer name" required>
                    </div>
                  </div>

                  {{-- <div class="form-group row">
                    <label for="bill" class="col-sm-2 col-form-label">Bill<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="bill" class="form-control" id="bill" placeholder="Enter bill" readonly>
                    </div>
                  </div> --}}
                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Note</label>
                    <div class="col-sm-10">
                        <input type="text" name="note" class="form-control" id="note" placeholder="Enter note">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="receive_id" class="col-sm-2 col-form-label">Fabric Receive<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="receive_id" id="receive_id" class="select2" multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                            {{-- <option value=null>Select Fabric Receive</option>
                            @foreach ($fab_receives as $receive)
                                <option value="{{$receive->id}}">{{$receive->name}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                  </div>
                  <div class="sub-title mt-20"><strong>Receiving Fabric Info</strong></div>
                    <div class="form-block">
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
    $("#kg, #rate").on('input', function(){
        calculateAmount();
    })
    $("#party_id").on('change', function() {
        var party = $("#party_id").val();
        $("#recFabTable").empty();
        getPartyInfo(party);
    })


function getPartyInfo(prty_id) {
        var party_id = prty_id;
        var url = "{{ url('fabric/party_info') }}";
        //alert(party_id);
        $.ajax({
            type: "get",
            url: url,
            data: {
                id: party_id
            },
            success: function(data) {
              console.log(data);
                var html = "<option value="+null+">Select Chalan</option>";
                $("#receive_id").empty();
                $.each(data.fab_receives, function(id, name) {
                    html += "<option value="+id+">"+name+"</option>";
                })
                $("#receive_id").append(html);
                html = "";
            }
        })
    }

    function calculateAmount(){
        var kg = $("#kg").val()*1;
        var rate = $("#rate").val()*1;

        $("#bill").val(kg * rate);
    }

    $("#receive_id").on('change', function(){
      var rec_id = $("#receive_id").val();
      var url = "{{ url('fabric/get-fab-rec-details') }}";
          $.ajax({
              type: "get",
              url: url,
              data: {
                  id: rec_id
              },
              success: function(data) {
                console.log(data.recFabric);
                if(data.recFabric == ''){
                    $("#recFabTable").empty();
                }
                if(data.recFabric == ''){
                    $("#recFabTable").empty();
                    alert('No Receiving Febric available');
                }else{
                  var html = "<tr><th>Lot</th><th>Count</th><th>Roll</th><th>Receiving Quantity (Kg)</th><th>Stock Quantity (Kg)</th><th>Delivery Quantity (Kg)</th><th>Roll</th><th>Rate</th><th>Amount</th></tr>";
                    $("#recFabTable").empty();
                    $.each(data.recFabric, function(key) {
                      console.log(data.recFabric[key]);
                      html += '<tr>';
                      html += '<input type="hidden" name="rec_fab_id[]" value='+data.recFabric[key].fab_rec_id+'>';
                      html += '<input type="hidden" name="fab_rec_details_id[]" value='+data.recFabric[key].id+'>';
                      html += '<td> '+data.recFabric[key].lot+' </td>';
                      html += '<td> '+data.recFabric[key].count+' </td> ';
                      html += '<td> '+data.recFabric[key].roll+' </td> ';
                      // html += '<td> '+data.recFabric[key].quantity+' </td> ';
                      html += '<td> <span>'+data.recFabric[key].quantity+'</span> <input type="hidden" id="rec_quantity-'+key+'" value="'+data.recFabric[key].quantity+'"></td> ';
                      html += '<td> <span id="stk_quantity-'+key+'">'+data.recFabric[key].stock+'</span></td> ';
                      html += '<td> <input type="number" step="0.01" name="stock_out[]" id="quantity-'+key+'" oninput="calculateBill('+key+')"> </td> ';
                      html += '<td> <input type="number" step="0.1" name="roll[]" id="roll-'+key+'"> </td> ';
                      html += '<td> <input type="number" name="rate[]" id="rate-'+key+'" oninput="calculateBill('+key+')"> </td> ';
                      html += '<td> <input type="text" id="amount-'+key+'" readonly> </td> ';
                      html += '<tr>';
                    })
                    $("#recFabTable").append(html);
                    html = "";
                }
                }
           })
     })
 });

 $("#party_id").on('change', function(){
      var party_id = $("#party_id").val();
      var url = "{{ url('fabric/get-party-stl-no') }}";
          $.ajax({
              type: "GET",
              url: url,
              data: {
                  id: party_id
              },
              success: function(data) {
                $("#stl_no").val(data.stl_no);
              }
           })
     })

function calculateBill(key){
  var qty = $('#quantity-' + key).val()*1;
  var rate = $('#rate-' + key).val()*1;

  $('#amount-' + key).val(qty * rate);
  checkValidation(key);
}

function checkValidation(key){
    var rec_qty = parseFloat($('#stk_quantity-' + key).text()*1);
    var del_qty = $('#quantity-' + key).val()*1;
    if(del_qty > rec_qty){
      $('#quantity-' + key).css('background-color', 'red');
      $("#submit").prop("disabled",true);
      alert('Delivery quantity can not more than receiving quantity');
    }else{
      $('#quantity-' + key).css('background-color', 'green');
      $("#submit").removeAttr('disabled');
    }
}
</script>
@endsection
