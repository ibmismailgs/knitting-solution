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
                    <h1>Update Production</h1>
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
                            <h3 class="card-title">Update Production</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::model($production, ['method' => 'PATCH','route' => ['production.update', $production->id]]) !!}
                        @csrf

                        <div class="card-body" id="productions">
                            <div class="form-group row">
                                <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{$production->date}}">
                                    @error('date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <select name="party_id" id="party_id" class="form-control @error('party_id') is-invalid @enderror" required>
                                        <option value = null>Select Party</option>
                                        @foreach ($parties as $party)
                                        <option value="{{$party->id}}" @if ($production->party_id == $party->id) selected @endif>{{$party->name}}</option>
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
                                        <option value = null>Select Party Order</option>
                                        @foreach ($knitting_programs as $knitting_program)
                                        <option value="{{$knitting_program->id}}" @if ($production->knitting_id == $knitting_program->id) selected @endif>{{$knitting_program->party_order_no}}</option>
                                        @endforeach
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
                                        <option value = null>Select Knitting Program</option>
                                        @foreach ($knitting_details as $knitting_detail)
                                        <option value="{{$knitting_detail->id}}" @if ($production->yarn_knitting_details_id == $knitting_detail->id) selected @endif>{{$knitting_detail->stl_order_no}}</option>
                                        @endforeach
                                    </select>
                                    @error('knitting_details_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mc_dia" class="col-sm-2 col-form-label">M/C Dia</label>
                                <div class="col-sm-10">
                                    <input type="text" name="mc_dia" class="form-control @error('mc_dia') is-invalid @enderror" id="mc_dia" placeholder="Enter m/cno" value="{{$production->mc_dia}}"  readonly>
                                    @error('mc_dia')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mc_no" class="col-sm-2 col-form-label">M/C No<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="mc_no" class="form-control  @error('mc_no') is-invalid @enderror" id="mc_no" placeholder="Enter m/cno" value="{{$production->mc_no}}" required>
                                    @error('mc_no')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="order_qty" class="col-sm-2 col-form-label">Order Quantity<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="order_qty" class="form-control  @error('order_qty') is-invalid @enderror" id="order_qty" value="{{$production->order_qty}}" placeholder="Enter Order Quantity" required readonly>
                                    @error('order_qty')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="note" class="col-sm-2 col-form-label">Note</label>
                                <div class="col-sm-10">
                                    <input type="text" name="note" class="form-control  @error('note') is-invalid @enderror" id="note" placeholder="Enter note"  value="{{$production->note}}">
                                    @error('note')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @foreach ($productiondetails as $key => $details)

                            <div id="del{{$key}}"  class="row_removed" style="border: 1px green solid; padding:8px; border-radius: 8px;margin-bottom:8px">
                                <div class="form-group row">
                                    <label for="operator_name" class="col-sm-2 col-form-label">Operator Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <select name="operator_name[]" id="operator_name" class="form-control @error('operator_name') is-invalid @enderror" required>
                                            <option value = null>Select Operator</option>
                                            @foreach ($operators as $operator)
                                            <option value="{{$operator->id}}" @if ($details->employee_id == $operator->id) selected @endif>{{$operator->name}}</option>
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
                                        <select name="shift[]" id="shift" class="form-control @error('shift') is-invalid @enderror" required>
                                            <option value="1" @if($details->shift == 1) selected @endif>Day</option>
                                            <option value="2" @if($details->shift == 2) selected @endif>Night</option>
                                        </select>
                                        @error('shift')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="produced_qnty" class="col-sm-2 col-form-label">Production(Done)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control produced_qnty" id="produced_qnty" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="roll" class="col-sm-2 col-form-label">Roll<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $details->roll }}" name="roll[]" class="form-control @error('roll') is-invalid @enderror" id="roll" placeholder="Enter Roll" required>
                                        @error('roll')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Quantity" class="col-sm-2 col-form-label">Quantity in KG <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="number"  oninput="amountCal({{$key+1}})" value="{{ $details->quantity }}" name="quantity[]" class="form-control quantity  @error('quantity') is-invalid @enderror" id="quantity{{$key+1}}" required>

                                        @error('quantity')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="balance" class="col-sm-2 col-form-label">Balance</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="balance[]" class="form-control balance row_count total_row" id="db_balance" hidden>

                                        <input type="number" name="balance[]" class="form-control  balance" id="balance{{$key+1}}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="rate" class="col-sm-2 col-form-label">Rate<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="number"  step="0.01" name="rate[]" class="form-control rate" id="rate" placeholder="Enter rate" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                    <div class="col-9">
                                        <input type="text" value="{{ $details->amount }}" name="amount[]" class="form-control amount" id="amount{{$key}}" readonly>
                                    </div>

                                    @if($key == 0 )
                                    @else
                                    <div class="col-1">
                                        <button type="button" id="deleted{{$key}}" name="remove" class="btn btn-danger btn_removed">-</button>
                                    </div>
                                    @endif

                                </div>

                            </div>
                            @endforeach
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-success float-left addmore" id="add"> + Add Production</button>
                            <button type="submit" class="btn btn-primary float-right">Update</button>
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
        $('#knitting_details_id').find('option').not(':first').remove();
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
            $(".produced_qnty").val(data.prodDone);
            $("#mc_dia").val(data.yarnKnittingDetails.mc_dia);
            $("#order_qty").val(data.totalKnitQty);
            $(".rate").val(data.yarnKnittingDetails.rate);
            $(".balance").val(data.available_for_production);
        }
    }
});
}

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
            $(".rate").val(data.yarnKnittingDetails.rate);
            $(".balance").val(data.available_for_production);
        }
    }
});
}
});

});
</script>

<script>
     var row_counts = $('.row_count').length;
    $('.total_row').val(row_counts);

    function amountCal(value){
    var quantity = $('#quantity'+value).val();
    var rate = $('#rate').val();
    var amount = parseFloat(rate) * parseFloat(quantity);

    $('#amount'+value).val(amount);

    //  blance calculation
    if(value == 1){
        var quantity = $('#quantity'+value).val();
        var db_balance = $('#db_balance').val();
        var balance = parseFloat(db_balance) - parseFloat(quantity);
        $('#balance'+value).val(balance);
    }
    else{
        var prev_balance = $('#balance'+(value-1)).val();
        var quantity = $('#quantity'+value).val();
        var balance = parseFloat(prev_balance) - parseFloat(quantity);
        $('#balance'+value).val(balance);

    }
    for(var j = value; j <= totalrowcont; j++){
            var prev_balance = $('#balance'+j).val();
            var quantity = $('#quantity'+(j+1)).val();
            var balance = parseFloat(prev_balance) - parseFloat(quantity);
            $('#balance'+(j+1)).val(balance);
          }
    }
</script>

<!-- add more productions -->
<script type="text/javascript">
    var i = 1;
    var max = 10;
    var totalrowcont = $('.total_row').val();
    $("#add").click(function() {
        var order_qty = $("#order_qty").val();
        var productionQuantity = $('#produced_qnty').val();
        var rate = $('#rate').val();
        var balance_db = $('#balance'+totalrowcont).val();

        if(i < max){
            i++;
            totalrowcont++;
            $("#productions").append('<div style="border: 1px green solid; padding:8px; border-radius: 8px;margin-bottom:8px" id="addrow">\
                <div class="form-group row">\
                <label for="operator_name" class="col-sm-2 col-form-label">Operator Name<span class="text-danger">*</span>\
                </label>\
                <div class="col-sm-10">\
                <select name="operator_name[]" id="operator_name" class="form-control operator_name @error('date') is-invalid @enderror" required>\
                <option value=null>Select Operator</option>\
                @foreach ($operators as $operator)\
                <option value="{{$operator->id}}">{{$operator->name}}</option>\
                @endforeach\
                </select>@error('date')<div class="alert alert-danger">{{ $message }}</div> @enderror\
                </div>\
                </div>\
                <div class="form-group row">\
                <label for="shift" class="col-sm-2 col-form-label">Shift<span class="text-danger">*</span></label>\
                <div class="col-sm-10">\
                <select name="shift[]" id="shift" class="form-control @error('shift') is-invalid @enderror" required>\
                <option value="">Select</option>\
                <option value="1">Day</option>\
                <option value="2">Night</option>\
                </select>@error('shift')<div class="alert alert-danger">{{ $message }}</div>@enderror\
                </div>\
                </div>\
                <div class="form-group row">\
                <label for="produced_qnty" class="col-sm-2 col-form-label">Production(Done)</label>\
                <div class="col-sm-10">\
                <input type="text" value="'+productionQuantity+'" class="form-control produced_qnty" id="produced_qnty" readonly>\
                </div>\
                </div>\
                <div class="form-group row">\
                <label for="roll" class="col-sm-2 col-form-label">Roll<span class="text-danger">*</span></label>\
                <div class="col-sm-10">\
                <input type="text" name="roll[]" class="form-control  @error('roll') is-invalid @enderror" id="roll" placeholder="Enter Roll" required> @error('roll')<div class="alert alert-danger">{{ $message }}</div>@enderror\
                </div>\
                </div>\
                <div class="form-group row">\
                <label for="Quantity" class="col-sm-2 col-form-label">Quantity in KG<span class="text-danger">*</span></label>\
                <div class="col-sm-10">\
                <input type="number" name="quantity[]" class="form-control quantity  @error('quantity') is-invalid @enderror" oninput="balanceCal('+totalrowcont+')" id="quantity'+totalrowcont+'" required>@error('quantity')<div class="alert alert-danger">{{ $message }}</div>@enderror\
                </div>\
                </div>\
                <div class="form-group row">\
                <label for="balance" class="col-sm-2 col-form-label">Balance</label>\
                <div class="col-sm-10">\
                <input type="number" name="balance[]" value="'+balance_db+'" class="form-control balance" id="balance'+totalrowcont+'" readonly>\
                </div>\
                </div>\
                <div class="form-group row">\
                <label for="rate" class="col-sm-2 col-form-label">Rate<span class="text-danger">*</span></label>\
                <div class="col-sm-10">\
                <input type="number" step="0.01" value="'+rate+'" name="rate[]" class="form-control rate num_row" id="rate" placeholder="Enter rate" readonly >\
                </div>\
                </div>\
                <div class="form-group row"><label for="amount" class="col-sm-2 col-form-label">Amount</label>\
                <div class="col-9"><input type="text" name="amount[]" class="form-control amount" id="amount'+i+'" readonly>\
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

    $(document).on('click', '.btn_removed', function() {
        var data = confirm("Are you sure want to delete. ");

        if (data == true) {
            $(this).parents('.row_removed').remove();
        }
        else {
            return false;
        }
    });

    $(document).on('input', '.quantity , .rate', function() {
        var quantity = $(this).closest('#addrow').find('.quantity').val();
        var rate = $(this).closest('#addrow').find('.rate').val();
        var amount = parseFloat(quantity) * parseFloat(rate);
        $(this).closest('#addrow').find('.amount').val(amount);

    });

    </script>

    <script>
     function balanceCal(value){
        var prev_balance = $('#balance'+(value-1)).val();
        var quantity = $('#quantity'+value).val();

        var balance = parseFloat(prev_balance) - parseFloat(quantity);
            $('#balance'+value).val(balance);
        }

    </script>

@endsection
