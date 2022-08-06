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
            <h1>Update Return Yarn</h1>
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
                <h3 class="card-title">Update Return Yarn</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {!! Form::model($ret_yarn, ['method' => 'PATCH','route' => ['return_yarn.update', $ret_yarn->id]]) !!}
                @csrf
                <input type="hidden" id="rec_id" value="{{$ret_yarn->receive_id}}">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date" value="{{ $ret_yarn->date }}" class="form-control" id="date" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="ret_chalan" class="col-sm-2 col-form-label">Return Chalan No</label>
                    <div class="col-sm-10" id="ret_chalan">
                        <input type="text" name="ret_chalan" class="form-control" value="{{ $ret_yarn->ret_chalan}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="ret_gate_pass" class="col-sm-2 col-form-label">Return Gate pass</label>
                    <div class="col-sm-10" id="ret_gate_pass">
                        <input type="text" name="ret_gate_pass" class="form-control" value="{{ $ret_yarn->ret_gate_pass}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="party_id" id="party_id" class="form-control" required>
                            <option value=null>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{$party->id}}" @if($party->id == $ret_yarn->party_id) selected @endif>{{$party->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="chalan" class="col-sm-2 col-form-label">Chalan No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="chalan" id="chalan" class="form-control">

                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="gate_pass" class="col-sm-2 col-form-label">Gate pass</label>
                    <div class="col-sm-10" id="gate_pass">
                        <input type="text" class="form-control" placeholder="Enter Gate pass" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="brand" class="col-sm-2 col-form-label">Yarn Brand</label>
                    <div class="col-sm-10" id="brand">
                        <input type="text" class="form-control"  placeholder="Enter brand" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="count" class="col-sm-2 col-form-label">Yarn count</label>
                    <div class="col-sm-10" id="count">
                        <input type="text" class="form-control"  placeholder="Enter yarn count" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="lot" class="col-sm-2 col-form-label">Yarn lot</label>
                    <div class="col-sm-10" id="lot">
                        <input type="text" class="form-control"  placeholder="Enter lot" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="quantity" class="col-sm-2 col-form-label">Receiving quantity</label>
                    <div class="col-sm-10">
                        <input type="text" id="quantity" step="0.01" class="form-control" placeholder="Enter quantity" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="ret_qty" class="col-sm-2 col-form-label">Return Quantity</label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="quantity" id="ret_qty" value="{{ $ret_yarn->quantity }}" class="form-control" placeholder="Enter Return Quantity">
                        <input type="hidden" name="validation" id="validation">
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
            // Get Party and chalan
            getChalanInfo();

            $("#party_id").on('change', function() {
                getPartyInfo();
            })

            $("#chalan").on('change', function() {
                getRecYarnInfo();
            })

            $("#ret_qty").on('keyup change', function(){
              checkValidation();
            })
        })

        function getPartyInfo(prty_id) {
            var party = $("#party_id").val();
            var url = "{{ url('yarn/party_info') }}";
            $.ajax({
                type: "get",
                url: url,
                data: {
                    id: party
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

        function getChalanInfo() {
            var party = $("#party_id").val();
            var rec_id = $("#rec_id").val();

            var url = "{{ url('yarn/party_info/edit') }}";
            $.ajax({
                type: "get",
                url: url,
                data: {
                    id: party,
                    rec_id: rec_id,
                },
                success: function(data) {
                    var html = "<option value="+null+">Select Chalan</option>";
                    $("#chalan").empty();
                    $.each(data.recYarn, function(id, title) {
                        html += "<option value="+id+" selected>"+title+"</option>";
                    })
                    $("#chalan").append(html);
                    html = "";
                }
            })

            setTimeout(function() 
              {
                getRecYarnInfo();
              }, 3000);
            
        }

        function getRecYarnInfo() {
            var rec_yarn_id = $("#chalan").val();
            var rec_yarn = rec_yarn_id;
            var url = "{{ url('yarn/rec_yarn_info/edit') }}";
            $.ajax({
                type: "get",
                url: url,
                data: {
                    id: rec_yarn
                },
                success: function(data) {
                  $('#gate_pass').empty();
                  $("#gate_pass").append('<input class="form-control" type="text" value="'+data.gate_pass+'" disabled>');

                  $('#brand').empty();
                  $("#brand").append('<input class="form-control" type="text" value="'+data.brand+'" disabled>');

                  $('#count').empty();
                  $("#count").append('<input class="form-control" type="text" value="'+data.count+'" disabled>');

                  $('#lot').empty();
                  $("#lot").append('<input class="form-control" type="text" value="'+data.lot+'" disabled>');

                  $('#quantity').empty();
                  $('#quantity').val(data.quantity);
                  // $("#quantity").append('<input class="form-control" type="text" value="'+data.quantity+'" disabled>');
                }
            })

            setTimeout(function() 
              {
                // Check Validation
                checkValidation();
              }, 1000);
        }

        function checkValidation(){
          var rec_qty = $("#quantity").val()*1;
          var ret_qty = $("#ret_qty").val()*1;
          
          if(ret_qty > rec_qty){
            $("#ret_qty").attr('style', 'border-color:red');
            $("#ret_qty").css('color:red');
            $("#validation").val('0');
            $("#submit").prop('disabled', true);
          }else{
            $("#ret_qty").attr('style', 'border-color:green');
            $("#ret_qty").css('color:green');
            $("#validation").val('1');
            $("#submit").prop('disabled', false);
          }
        }
    </script>
@endsection