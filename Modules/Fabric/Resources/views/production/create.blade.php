@extends('layouts.admin.dashboard')
@section('title', 'Fabric-Production-Create')
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
              <form enctype="multipart/form-data" action="{{ route('production.store') }}" method="POST">
                @csrf
                <div class="card-body" id="productions">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date" value="{{old('date')}}" class="form-control @error('date') is-invalid @enderror" id="date" required>
                        @error('date')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="party_id" id="party_id" class="form-control  @error('party_id') is-invalid @enderror" required>
                            <option value = null>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{ $party->id }}" {{ old('party_id') == $party->id ? "selected" :""}}>{{ $party->name }}</option>
                            @endforeach
                        </select>
                         @error('party_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_order_no" class="col-sm-2 col-form-label">Party Order<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="party_order_no" id="party_order_no" class="form-control  @error('party_order_no') is-invalid @enderror" required>
                            <option value=null>Select Order</option>
                        </select>
                         @error('party_order_no')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="knitting_details_id" class="col-sm-2 col-form-label">Knitting Program<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="knitting_details_id" id="knitting_details_id" class="form-control  @error('knitting_details_id') is-invalid @enderror" required>
                            <option value=null>Select Knitting Program</option>
                        </select>
                         @error('knitting_details_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="mc_dia" class="col-sm-2 col-form-label">M/C Dia</label>
                    <div class="col-sm-10">
                        <input type="text" name="mc_dia" class="form-control  @error('mc_dia') is-invalid @enderror" id="mc_dia" placeholder="Enter m/cno" readonly>
                         @error('mc_dia')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="mc_no" class="col-sm-2 col-form-label">M/C No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="mc_no" value="{{old('mc_no')}}" class="form-control  @error('mc_no') is-invalid @enderror" id="mc_no" placeholder="Enter m/cno" required>
                         @error('mc_no')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="order_qty" class="col-sm-2 col-form-label">Order Quantity<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="order_qty" class="form-control  @error('order_qty') is-invalid @enderror" id="order_qty" placeholder="Enter Order Quantity" readonly>
                         @error('order_qty')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Note</label>
                    <div class="col-sm-10">
                        <input type="text" name="note" value="{{old('note')}}" class="form-control  @error('note') is-invalid @enderror" id="note" placeholder="Enter note">
                         @error('note')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                <div style="border: 1px green solid; padding:8px; border-radius: 8px;margin-bottom:8px">
                <div class="form-group row">
                <label for="operator_name" class="col-sm-2 col-form-label">Operator Name<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <select name="operator_name[]" id="operator_name" class="form-control  @error('operator_name') is-invalid @enderror" required>
                    <option value=null>Select Operator</option>
                    @foreach ($operators as $operator)
                    <option value="{{$operator->id}}" {{in_array($operator->id, old("operator_name") ?: []) ? "selected" : ""}}>{{$operator->name}}</option>
                    @endforeach
                    </select>
                     @error('operator_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
                </div>
                <div class="form-group row">
                <label for="shift" class="col-sm-2 col-form-label">Shift<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <select name="shift[]" id="shift" class="form-control  @error('shift') is-invalid @enderror" required>
                    <option value="">Select</option>
                    <option value="1" {{in_array(1, old("shift") ?: []) ? "selected" : ""}}>Day</option>
                    <option value="2" {{in_array(2, old("shift") ?: []) ? "selected" : ""}}>Night</option>
                    </select>
                     @error('shift')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
                </div>

                <div class="form-group row">
                <label for="produced_qnty" class="col-sm-2 col-form-label">Production(Done)</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control  @error('produced_qnty') is-invalid @enderror" id="produced_qnty" readonly>
                     @error('produced_qnty')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
                </div>
                <div class="form-group row">
                <label for="roll" class="col-sm-2 col-form-label">Roll<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="roll[]" value="{{old('roll.'.'0')}}" class="form-control  @error('roll') is-invalid @enderror" id="roll" placeholder="Enter Roll" required>
                     @error('roll')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
                </div>
                <div class="form-group row">
                <label for="Quantity" class="col-sm-2 col-form-label">Quantity in KG<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="quantity[]"  value="{{old('quantity.'.'0')}}" oninput="getId(1)" class="form-control  @error('quantity') is-invalid @enderror" id="quantity1" placeholder="Enter Quantity"  required>
                     @error('quantity')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
                </div>
                <div class="form-group row">
                <label for="balance" class="col-sm-2 col-form-label">Balance</label>
                <div class="col-sm-10">
                    <input type="number" name="balance[]" class="form-control  @error('balance') is-invalid @enderror" id="balance1" readonly>
                     @error('balance')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
                </div>

                <div class="form-group row">
                <label for="rate" class="col-sm-2 col-form-label">Rate<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" step="0.01" name="rate[]" class="form-control  @error('rate') is-invalid @enderror" id="rate" placeholder="Enter rate" readonly>
                     @error('rate')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
                </div>
                <div class="form-group row">
                <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                <div class="col-sm-10">
                    <input type="text" name="amount[]" class="form-control  @error('amount') is-invalid @enderror" id="amount" readonly>
                     @error('amount')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
                </div>
                </div>
                </div>

                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="button" class="btn btn-success float-left addmore" id="add"> + Add Production</button>
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
  //Getting Knitting Order Details According to Party
  $('#party_id').on('change',function(){
        var party_id = $("#party_id").val();
             var url = "{{ url('fabric/get-knitting-program') }}";
        if(party_id){
          $('#party_order_no').find('option').not(':first').remove();
        $.ajax({
            type: "get",
            url: url,
            data: {
                id: party_id
            },
            success: function(response) {
              var len = 0;
                    $.each( response, function( key, value ) {
                        var option = "<option value='"+value.key+"'>"+value.value+"</option>";
                        $("#party_order_no").append(option);
                    });
        }
        });
        }

    });


  //Getting Knitting Details According to Party
  $('#party_order_no').on('change',function(){
        // var party_id = $("#party_id").val();
        var knitting_program_id = $("#party_order_no").val();
             var url = "{{ url('fabric/get-knitting-program_details') }}";

        if(knitting_program_id){
          $('#knitting_details_id').find('option').not(':first').remove();
        $.ajax({
            type: "get",
            url: url,
            data: {
                id: knitting_program_id
            },
            success: function(response) {
              console.log(response);
              var len = 0;
                    $.each( response, function( key, value ) {
                        var option = "<option value='"+value.key+"'>"+value.value+"</option>";
                        $("#knitting_details_id").append(option);
                    });
        }
        });
        }
    });

  //Getting Knitting Program
    $('#knitting_details_id').on('change',function(){
        var knitting_details_id = $("#knitting_details_id").val();
             var url = "{{ url('fabric/get-knitting-production-amount') }}";
             console.log(knitting_details_id);
        if(knitting_details_id){
          // $('#knitting_details_id').find('option').not(':first').remove();
        $.ajax({
            type: "get",
            url: url,
            data: {
                id: knitting_details_id
            },
            success: function(data) {
              console.log(data.knitting_quantity);
              console.log(data);
              if (data.available_for_production == 0) {
                alert('Whoops! Unavailable Quantity For Production')
              } else {
                $("#produced_qnty").val(data.prodDone);
                $("#mc_dia").val(data.yarnKnittingDetails.mc_dia);
                $("#order_qty").val(data.totalKnitQty);
                $("#rate").val(data.yarnKnittingDetails.rate);
              }
        }
        });
        }
    });

    $("#quantity1, #rate").on('input', function(){
        calculateAmount();
    })

    $("#knitting_id,#quantity1, #roll, #order_qty",).on('input', function(){
        // calculateKg();
        calculateBalance();
    })

    function calculateAmount(){
        var quantity = $("#quantity1").val()*1;
        var rate = $("#rate").val()*1;

        $("#amount").val(quantity * rate);
    }

    function calculateKg(){
      var roll = $("#roll").val()*1;
      var qty = $("#quantity1").val()*1;

      $("#kg").val(roll * qty);
    }

    function calculateBalance(){
      var order_qty =$("#order_qty").val();
      var produced_qnty=$("#produced_qnty").val();
      var quantity = $("#quantity1").val();
      if(produced_qnty > 0){
        var total=produced_qnty - (-quantity);
        $("#balance1").val(order_qty - total);
      }else{
        $("#balance1").val(order_qty - quantity);
      }
    }
});

</script>


<!-- add more cproductions -->
<script type="text/javascript">
    var i = 1;
    var max = 10;

$("#add").click(function() {
    order_qty = $("#order_qty").val();
    old_balance = $("#balance1").val();
    productionQuantity = $('#produced_qnty').val();
    rate = $('#rate').val();

  if(i < max){
    i++;
    $("#productions").append('<div style="border: 1px green solid; padding:8px; border-radius: 8px;margin-bottom:8px" id="addrow">\
    <div class="form-group row">\
    <label for="operator_name" class="col-sm-2 col-form-label">Operator Name<span class="text-danger">*</span>\
    </label>\
    <div class="col-sm-10">\
    <select name="operator_name[]" id="operator_name'+i+'" class="form-control operator_name  @error('operator_name') is-invalid @enderror" required>\
    <option value=null>Select Operator</option>\
    @foreach ($operators as $operator)\
    <option value="{{$operator->id}}" {{in_array($operator->id, old("operator_name") ?: []) ? "selected" : ""}}>{{$operator->name}}</option>\
    @endforeach\
    </select>@error('operator_name')<div class="alert alert-danger">{{ $message }}</div> @enderror\
    </div>\
    </div>\
    <div class="form-group row">\
    <label for="shift" class="col-sm-2 col-form-label">Shift<span class="text-danger">*</span><span class="text-danger">*</span></label>\
    <div class="col-sm-10">\
    <select name="shift[]" id="shift'+i+'" class="form-control  @error('shift') is-invalid @enderror" required>\
    <option value="">Select</option>\
    <option value="1" {{in_array(1, old("shift") ?: []) ? "selected" : ""}}>Day</option>\
                    <option value="2" {{in_array(2, old("shift") ?: []) ? "selected" : ""}}>Night</option>\
    </select> @error('shift')<div class="alert alert-danger">{{ $message }}</div>@enderror\
    </div>\
    </div>\
    <div class="form-group row">\
    <label for="produced_qnty" class="col-sm-2 col-form-label">Production(Done)</label>\
    <div class="col-sm-10">\
    <input type="text" value="'+productionQuantity+'" class="form-control produced_qnty" id="produced_qnty'+i+'" readonly>\
    </div>\
    </div>\
    <div class="form-group row">\
    <label for="roll" class="col-sm-2 col-form-label">Roll<span class="text-danger">*</span></label>\
    <div class="col-sm-10">\
    <input type="number" name="roll[]" value="{{ old('roll.+i+') }}" class="form-control  @error('roll') is-invalid @enderror" id="roll'+i+'" placeholder="Enter Roll" required> @error('roll')<div class="alert alert-danger">{{ $message }}</div>@enderror\
    </div>\
    </div>\
    <div class="form-group row">\
    <label for="Quantity" class="col-sm-2 col-form-label">Quantity in KG<span class="text-danger">*</span></label>\
    <div class="col-sm-10">\
    <input type="number" name="quantity[]" class="form-control quantity  @error('quantity') is-invalid @enderror" oninput="getId('+i+')" id="quantity'+i+'" placeholder="Enter quantity" required>@error('quantity')<div class="alert alert-danger">{{ $message }}</div>@enderror\
    </div>\
    </div>\
    <div class="form-group row">\
    <label for="balance" class="col-sm-2 col-form-label">Balance</label>\
    <div class="col-sm-10">\
    <input type="number" name="balance[]" class="form-control balance  @error('balance') is-invalid @enderror" id="balance'+i+'" readonly>@error('balance')<div class="alert alert-danger">{{ $message }}</div>@enderror\
    </div>\
    </div>\
    <div class="form-group row">\
    <label for="rate" class="col-sm-2 col-form-label">Rate<span class="text-danger">*</span></label>\
    <div class="col-sm-10">\
    <input type="number" step="0.01" value="'+rate+'" name="rate[]" class="form-control rate  @error('rate') is-invalid @enderror" id="rate'+i+'" placeholder="Enter rate" readonly >\
    </div>\
    </div>\
    <div class="form-group row"><label for="amount" class="col-sm-2 col-form-label">Amount</label>\
    <div class="col-9"><input type="text" name="amount[]" class="form-control amount  @error('amount') is-invalid @enderror" id="amount'+i+'" readonly>\
    </div><div class="col-1"> <button type="button" name="remove" id="'+ i +'" class="btn btn-danger btn_remove">-</button></div></div>\
    </div>');

    }else{
        alert('you have reached a limit of 10');
    }

    });

    $(document).on('click', '.btn_remove', function() {
        $(this).parents('#addrow').remove();
        i--;
    });

     $(".addmore").click(function(){
        $(this).html("+ Add More");
    });

    $(document).on('input', '.quantity , .rate', function() {
        var quantity = $(this).closest('#addrow').find('.quantity').val();
        var rate = $(this).closest('#addrow').find('.rate').val();
        var amount = parseFloat(quantity) * parseFloat(rate);
        $(this).closest('#addrow').find('.amount').val(amount);

    });

</script>

<script>
   function getId(value){
//  blance calculation
        if(value == 1){
          var cur_quantity = $('#quantity'+value).val();
          var cur_balance = $('#balance'+value).val();
          var balance = parseFloat(cur_balance) - parseFloat(cur_quantity);
          $('#balance'+value).val(balance);
        }
        else{
          var prev_balance = $('#balance'+(value-1)).val();
          var quantity = $('#quantity'+value).val();

          var balance = parseFloat(prev_balance) - parseFloat(quantity);
          $('#balance'+value).val(balance);
          }
                for(var j = value; j <= i; j++){
            var prev_balance = $('#balance'+j).val();
            //console.log(prev_balance);
            var quantity = $('#quantity'+(j+1)).val();

            var balance = parseFloat(prev_balance) - parseFloat(quantity);
            $('#balance'+(j+1)).val(balance);
          }
    }
</script>
@endsection
