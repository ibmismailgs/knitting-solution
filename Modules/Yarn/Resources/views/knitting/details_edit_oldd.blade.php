@extends('layouts.admin.dashboard')
@section('title', 'Knitting-details')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Knitting Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Knitting Details</li>
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
                <h3 class="card-title">Update Knitting Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($knitting_details, ['method' => 'PATCH','route' => ['knitting_details.update', $knitting_details->id]]) !!}
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date" class="form-control" value="{{ $knitting_details->date}}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stl_order_no" class="col-sm-2 col-form-label">Stl Order No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="stl_order_no" value="{{ $knitting_details->stl_order_no }}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="party_id" id="party_id" class="form-control" required>
                            <option value=null>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{$party->id}}" @if($party->id == $knitting_details->party_id) selected @endif>{{$party->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_number" class="col-sm-2 col-form-label">Party Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="party_number" value="{{$knitting_details->party_id}}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="receive_yarn" class="col-sm-2 col-form-label">receive_yarn No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="hidden" id="receive_id" value="{{$knitting_details->receive_id}}">
                        <select name="receive_id" id="receive_yarn" class="form-control" required>

                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="available_qty" class="col-sm-2 col-form-label">Available Quantity<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="available_qty" value="{{ getStock($knitting_details->party_id, $knitting_details->receive_id) + $knitting_details->knitting_qty }}" readonly required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="knitting_qty" class="col-sm-2 col-form-label">Knitting Quantity<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="knitting_qty" class="form-control" value="{{ $knitting_details->knitting_qty }}" id="knitting_qty" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="rate" class="col-sm-2 col-form-label">Rate Per Pcs<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="rate" class="form-control" id="rate" value="{{ $knitting_details->rate}}" required>
                    </div>
                  </div>                
                </div>
                <!-- /.card-body -->
                <input type="hidden" name="knitting_id" value="{{$knitting_details->knitting_id}}">
                <input type="hidden" name="stl_order_no" value="{{$knitting_details->stl_order_no}}">
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right" id="submit">Submit</button>
                  <a href="{{ route('knitting.show', $knitting_details->knitting_id) }}" class="btn btn-warning float-right mr-1">Cancel</a>
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
            getPartyYarnReceiveInfo();
            //Assign party no
            var party = $("#party_id").val();
            $("#party_number").val(party);


            $("#party_id").on('change', function() {
                getPartyYarnReceiveInfo();
                //Assign party no
                var party = $("#party_id").val();
                $("#party_number").val(party);
            })

            $("#receive_yarn").on('change', function() {
                getStockInfo();
            })
        })

        function getPartyYarnReceiveInfo() {
          var party = $("#party_id").val();
            var url = "{{ url('yarn/party_wise_yarn_info') }}";
            $.ajax({
                type: "get",
                url: url,
                data: {
                    id: party
                },
                success: function(data) {
                    var html = "<option value="+null+">Select Receive Yarn</option>";
                    $("#receive_yarn").empty();
                    $.each(data.recYarn_name, function(key) {
                      console.log(data.recYarn_name[key].brand);
                        html += "<option value="+data.recYarn_name[key].id+">"+data.recYarn_name[key].chalan+"_"+data.recYarn_name[key].brand+"_"+data.recYarn_name[key].count+"_"+data.recYarn_name[key].lot+"_"+data.recYarn_name[key].quantity+"_Kg</option>";
                    })
                    $("#receive_yarn").append(html);
                    html = "";
                }
            })
        }
        setTimeout(function() 
              {
                var rec_id = $("#receive_id").val();
                $('select').val(rec_id);
              }, 1000);

        function getStockInfo() {
          var party = $("#party_id").val();
          var rec_id = $("#receive_yarn").val();
            var url = "{{ url('yarn/receive_wise_yarn_stock') }}";
            $.ajax({
                type: "get",
                url: url,
                data: {
                    id: party,
                    rec_id: rec_id
                },
                success: function(data) {
                    $("#available_qty").val(data.stock);
                }
            })
        }      
    </script>
@endsection