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
                        <input type="date" name="date" class="form-control" id="date" value="{{$knitting_details->date}}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="party_id" id="party_id" class="form-control" required aria-readonly="true">
                            <option value=null>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{$party->id}}"
                                  @if($knitting_details->party_id == $party->id )
                                    selected
                                  @endif
                                  >{{$party->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_order_no" class="col-sm-2 col-form-label">Party Order No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="party_order_no" class="form-control" id="party_order_no" value="{{$knitting_details->knittingProgram->party_order_no}}" required readonly>
                    </div>
                  </div>
                  {{-- STL Order Number --}}
                  {{-- <div class="form-group row">
                    <label for="stl_order_no" class="col-sm-2 col-form-label">Stl Order No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="stl_order_no" class="form-control" id="stl_order_no" value="{{ $stlNo }}" readonly required>
                    </div>
                  </div> --}}

                  <div class="form-group row">
                    <label for="party_number" class="col-sm-2 col-form-label">Party Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="party_number" value="{{$knitting_details->party_id}}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="receive_yarn" class="col-sm-2 col-form-label">Receive Yarn No<span class="text-danger">*</span></label>
                    <div class="col-sm-2">
                      <input type="text" name="previous_receive_id" id="" class="form-control" value="{{$knitting_details->receiveYarn->chalan}}#{{$knitting_details->receiveYarn->quantity}}KG" readonly>
                    </div>
                    <div class="col-sm-8">
                        <select name="receive_id" id="receive_yarn" class="form-control" required>

                        </select>
                    </div>
                  </div>
                </div>
                {{-- Add more Knitting Program --}}
                <hr>
                <div class="row p-2">
                  {{-- <div class="col-md-1">
                    <button id="add_more" class="btn btn-info mt-4"><i class="fa fa-plus" title="Add More Product"></i></button>
                  </div> --}}

                  <div class="col-md-12">
                        <div class="form-row">
                          <div class="col-md-3">
                            <div class="position-relative form-group">
                              <label for="stl_order_no" class="">Stl Order No</label>
                              <input type="text" name="stl_order_no" class="form-control" id="stl_order_no" value="{{ $knitting_details->stl_order_no }}" readonly required>
                            </div>
                          </div>
                          <div class="col-md-3">
                              <div class="position-relative form-group">
                                <label for="available_qty" class="">Available Quantity</label>
                                <input type="text" name="available_qty" class="form-control" id="available_qty" value="{{ old('available_qty',optional($knitting_details)->available_qty) }}" readonly>
                              </div>
                          </div>
                          <div class="col-md-3">
                            <div class="position-relative form-group">
                              <label for="fabric_type" class="">Knitting Quantity</label>
                              <input type="number" step="0.01" name="knitting_qty" class="form-control" oninput="checkValidation()" id="knitting_qty" value="{{ old('knitting_qty',optional($knitting_details)->knitting_qty) }}" required>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="position-relative form-group">
                              <label for="rate" class="">Buyer Name</label>
                              <input type="text" name="buyer_name" class="form-control" id="buyer_name" placeholder="Enter Buyer name" value="{{ old('buyer_name',optional($knitting_details)->buyer_name) }}" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="col-md-4">
                              <div class="position-relative form-group">
                                <label for="brand" class="">Yarn Brand</label>
                                <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand',optional($knitting_details)->brand) }}" required readonly>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="position-relative form-group">
                                <label for="count" class="">Yarn count</label>
                                <input type="text" name="count" id="count" placeholder="Yarn count" class="form-control" value="{{ old('count',optional($knitting_details)->count) }}" required readonly>
                              </div>
                          </div>
                          <div class="col-md-4">
                            <div class="position-relative form-group">
                              <label for="lot" class="">Yarn lot</label>
                              <input type="text" name="lot" id="lot" placeholder="Yarn lot" class="form-control" value="{{ old('lot',optional($knitting_details)->lot) }}" required readonly>
                            </div>
                        </div>
                        </div>
                    
                        <div class="form-row">
                          <div class="col-md-4">
                            <div class="position-relative form-group">
                              <label for="m/c_dia" class="">M/C Dia</label>
                              <input name="mc_dia" id="mc_dia" placeholder="M/C Dia" type="text" class="form-control" value="{{ old('mc_dia',optional($knitting_details)->mc_dia) }}" required>
                            </div>
                          </div>
                          <div class="col-md-4">
                              <div class="position-relative form-group">
                                <label for="f_dia" class="">F Dia</label>
                                <input name="f_dia" id="f_dia" placeholder="Finished Dia" type="text" class="form-control amount" value="{{ old('f_dia',optional($knitting_details)->f_dia) }}" required>
                              </div>
                          </div>
                          <div class="col-md-4">
                            <div class="position-relative form-group">
                              <label for="f_gsm" class="">F GSM</label>
                              <input name="f_gsm" id="f_gsm" placeholder="F GSM" type="text" class="form-control" value="{{ old('f_gsm',optional($knitting_details)->f_gsm) }}" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="col-md-3">
                            <div class="position-relative form-group">
                              <label for="sl" class="">SL</label>
                              <input name="sl" id="sl" placeholder="Stitch Length" type="text" class="form-control" value="{{ old('sl',optional($knitting_details)->sl) }}" required>
                            </div>
                          </div>
                          <div class="col-md-3">
                              <div class="position-relative form-group">
                                <label for="colour" class="">Colour</label>
                                <input name="colour" id="colour" pColourlaceholder="Colour" type="text" class="form-control amount" value="{{ old('colour',optional($knitting_details)->colour) }}" required>
                              </div>
                          </div>
                          <div class="col-md-3">
                            <div class="position-relative form-group">
                              <label for="fabric_type" class="">Fabric Type</label>
                              <input name="fabric_type" id="fabric_type" placeholder="Fabric Type" type="text" class="form-control" value="{{ old('fabric_type',optional($knitting_details)->fabric_type) }}" required>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="position-relative form-group">
                              <label for="rate" class="">Rate Per Pcs</label>
                              <input name="rate" id="rate" placeholder="Rate Per Pcs" type="text" class="form-control" value="{{ old('rate',optional($knitting_details)->rate) }}" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="col-md-12">
                            <div class="position-relative form-group">
                              <label for="note" class="">Note</label>
                              <input type="text" name="note" class="form-control" id="note" placeholder="Enter Note" value="{{ old('note',optional($knitting_details)->note) }}">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="more_field">
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
                    //Yarn info
                    $("#brand").val(data.brand);
                    $("#count").val(data.count);
                    $("#lot").val(data.lot);
                }
            })
        }
        
        function checkValidation(){
            var avl_qty = $('#available_qty').val()*1;
            var knit_qty = $('#knitting_qty').val()*1;
            
            if(knit_qty > avl_qty){
              $('#knitting_qty').css('border-color', 'red');
              $("#submit").prop("disabled",true);
            }else{
              $('#knitting_qty').css('border-color', 'green');
              $("#submit").removeAttr('disabled');
            }
        }
    </script>
@endsection