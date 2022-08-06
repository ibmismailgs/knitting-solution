@extends('layouts.admin.dashboard')
@section('title', 'Yarn-Return-Create')
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
                <h3 class="card-title">Create Return Yarn</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('return_yarn.store') }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date" class="form-control" id="date" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="ret_chalan" class="col-sm-2 col-form-label">Return Chalan No</label>
                    <div class="col-sm-10" id="ret_chalan">
                        <input type="text" name="ret_chalan" class="form-control" value="RY-{{$return_count+1}}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="ret_gate_pass" class="col-sm-2 col-form-label">Return Gate pass</label>
                    <div class="col-sm-10" id="ret_gate_pass">
                        <input type="text" name="ret_gate_pass" class="form-control" value="RYG-{{$return_count+1}}" readonly>
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
                    <label for="chalan" class="col-sm-2 col-form-label">Chalan No<span class="text-danger">*</span></label>
                    <div class="col-sm-10 select2-purple">
                        <select name="chalan" id="chalan" class="select2" multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;">

                        </select>
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

                    <div class="sub-title mt-20"><strong>Receiving Yarn Info</strong></div>
                    <div class="form-block">
                        <div class="form-group">
                            <div class="row">
                                <table class="table table-bordered stripe" id="recYarnTable">

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
        $('document').ready(function() {
            $("#party_id").on('change', function() {
                var party = $("#party_id").val();
                $("#recYarnTable").empty();
                getPartyInfo(party);
            })

            $("#chalan").on('change', function() {
                var rec_yarn_id = $("#chalan").val();
                // getRecYarnInfo(rec_yarn_id);
                console.log(rec_yarn_id);
                getRecYarnInfo(rec_yarn_id);
            })
        })

        function getPartyInfo(prty_id) {
            var party_id = prty_id;
            var url = "{{ url('yarn/party_info') }}";
            $.ajax({
                type: "get",
                url: url,
                data: {
                    id: party_id
                },
                success: function(data) {
                    var html = "<option value="+null+">Select Chalan</option>";
                    $("#chalan").empty();
                    $.each(data.recYarn, function(id, title) {
                        html += "<option value="+id+">"+title+"</option>";
                    })
                    $("#chalan").append(html);
                    html = "";
                }
            })
        }


        function getRecYarnInfo(rec_yarn_id) {
            var rec_yarn = rec_yarn_id;
            var url = "{{ url('yarn/rec_yarn_info') }}";
            $.ajax({
                type: "get",
                url: url,
                data: {
                    id: rec_yarn
                },
                success: function(data) {
                   console.log(data);
                    var html = "<tr><th>Gate pass</th><th>Brand</th><th>Yarn count</th><th>Yarn lot</th><th>Receiving quantity</th><th>Receiving Roll</th><th>Current Stock</th><th>Return Roll</th><th>Return Quantity</th></tr>";
                    // var html = "<tr><th>Gate pass</th><th>Brand</th><th>Yarn count</th><th>Yarn lot</th><th>Receiving quantity</th><th>Return Quantity</th></tr>";
                    $("#recYarnTable").empty();
                    $.each(data.recYarn, function(key) {
                      var stock = data.recYarn[key];
                      //console.log(data.recYarn[key]);
                      html += '<tr>';
                      html += '<input type="hidden" name="rec_yarn_id[]" value='+data.recYarn[key].id+'>';
                      html += '<td> '+data.recYarn[key].gate_pass+' </td>';
                      html += '<td> '+data.recYarn[key].yarn_brand+' </td> ';
                      html += '<td> '+data.recYarn[key].yarn_count+' </td> ';
                      html += '<td> '+data.recYarn[key].yarn_lot+' </td> ';
                      html += '<td> <span>'+data.recYarn[key].yarn_receiving+'</span> <input type="hidden" id="quantity-'+key+'" value="'+data.recYarn[key].yarn_receiving+'"></td> ';

                      html += '<td> <span>'+data.recYarn[key].yarn_receiving_roll+'</span> <input type="hidden" id="roll_in-'+key+'" value="'+data.recYarn[key].yarn_receiving_roll+'"></td> ';

                      html += '<td> <span>'+data.recYarn[key].current_yarn_stock+'</span> <input type="hidden" id="stock_in-'+key+'" value="'+data.recYarn[key].current_yarn_stock+'"></td> ';

                    //   html += '<td> <span>'+data.recYarn[key].current_yarn_stock_roll+'</span> <input type="hidden" id="stock-quantity-'+key+'" value="'+data.recYarn[key].current_yarn_stock_roll+'"></td> ';

                      html += '<td> <input type="number" step="0.10" name="roll[]" id="roll-'+key+'" oninput="checkRollValidation('+key+')"> </td> ';
                      html += '<td> <input type="number" step="0.01" name="stock_out[]" id="stock_out-'+key+'" oninput="checkValidation('+key+')"> </td> ';
                      html += '<tr>';

                    })
                    $("#recYarnTable").append(html);
                    html = "";
                }
            })
        }

       function checkValidation(key)
        {
          var qty = $('#stock_in-' + key).val();
          var stock_out = $('#stock_out-' + key).val();

           var current_yarn=parseInt(qty);
           var return_yarn_quantity=parseInt(stock_out);

          if(return_yarn_quantity > current_yarn){
            $('#stock_out-' + key).css('background-color', 'red');
            $('#stock_out-' + key).val('null');
            $("#submit").prop("disabled",true);
          }else{
            $('#stock_out-' + key).css('background-color', 'green');
            $("#submit").removeAttr('disabled');
          }
        }

       function checkRollValidation(key)
        {
          var roll_qty = $('#roll_in-' + key).val();
          var stock_out = $('#roll-' + key).val();

           var current_yarn=parseInt(roll_qty);
           var return_yarn_quantity=parseInt(stock_out);

          if(return_yarn_quantity > current_yarn){
            $('#roll-' + key).css('background-color', 'red');
            $('#roll-' + key).val('null');
            $("#submit").prop("disabled",true);
          }else{
            $('#roll-' + key).css('background-color', 'green');
            $("#submit").removeAttr('disabled');
          }
        }
    </script>
@endsection
