@extends('layouts.admin.dashboard')
@section('title', 'Knitting-update')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Knitting Program</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Knitting Program</li>
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
                <h3 class="card-title">Update Knitting Program</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($data, ['method' => 'PATCH','route' => ['knitting.update', $data->id]]) !!}
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date" class="form-control" value="{{ $data->date}}" required>
                    </div>
                  </div>
                  {{-- <div class="form-group row">
                    <label for="party_order_no" class="col-sm-2 col-form-label">Party Order No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="party_order_no" class="form-control" id="party_order_no" value="{{ $data->party_order_no }}" required>
                    </div>
                  </div> --}}
                  <div class="form-group row">
                    <label for="stl_order_no" class="col-sm-2 col-form-label">Stl Order No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="stl_order_no" value="{{ $data->stl_order_no }}" readonly>
                    </div>
                  </div>
                  {{-- <div class="form-group row">
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
                    <label for="party_number" class="col-sm-2 col-form-label">Party Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="party_number" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="receive_yarn" class="col-sm-2 col-form-label">receive_yarn No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="hidden" id="receive_id" value="{{$data->receive_id}}">
                        <select name="receive_id" id="receive_yarn" class="form-control">

                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="available_qty" class="col-sm-2 col-form-label">Available Quantity<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="available_qty" value="{{ getStock($data->party_id, $data->receive_id) + $data->knitting_qty }}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="knitting_qty" class="col-sm-2 col-form-label">Knitting Quantity<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="knitting_qty" class="form-control" value="{{ $data->knitting_qty }}" id="knitting_qty" required>
                    </div>
                  </div> --}}
                  <div class="form-group row">
                    <label for="buyer_name" class="col-sm-2 col-form-label">Buyer Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="buyer_name" class="form-control" id="buyer_name" value="{{ $data->buyer_name }}" required>
                    </div>
                  </div>
                  {{-- <div class="form-group row">
                    <label for="brand" class="col-sm-2 col-form-label">Yarn Brand</label>
                    <div class="col-sm-10">
                        <input type="text" name="brand" class="form-control" id="brand" value="{{ $data->brand }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="count" class="col-sm-2 col-form-label">Yarn Count</label>
                    <div class="col-sm-10">
                        <input type="text" name="count" class="form-control" id="count" value="{{ $data->count }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="lot" class="col-sm-2 col-form-label">Yarn Lot</label>
                    <div class="col-sm-10">
                        <input type="text" name="lot" class="form-control" id="lot" value="{{ $data->lot }}">
                    </div>
                  </div> --}}
                  <div class="form-group row">
                    <label for="mc_dia" class="col-sm-2 col-form-label">M/C Dia<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="mc_dia" class="form-control" id="mc_dia" value="{{ $data->mc_dia }}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="f_dia" class="col-sm-2 col-form-label">F/Dia<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="f_dia" class="form-control" id="f_dia" value="{{ $data->f_dia }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="f_gsm" class="col-sm-2 col-form-label">F/GSM<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="f_gsm" class="form-control" id="f_gsm" value="{{ $data->f_gsm }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="sl" class="col-sm-2 col-form-label">SL<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="sl" class="form-control" id="sl" value="{{ $data->sl }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="colour" class="col-sm-2 col-form-label">Colour</label>
                    <div class="col-sm-10">
                        <input type="text" name="colour" class="form-control" id="colour" value="{{ $data->colour }}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="fabric_type" class="col-sm-2 col-form-label">Fabric Type<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="fabric_type" class="form-control" id="fabric_type" value="{{ $data->fabric_type }}" required>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Note</label>
                    <div class="col-sm-10">
                        <input type="text" name="note" class="form-control" id="note" value="{{ $data->note}}">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right" id="submit">Submit</button>
                  <a href="{{ route('knitting.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
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