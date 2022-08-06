@extends('layouts.admin.dashboard')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Expense</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Expense</li>
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
                <h3 class="card-title">Update Expense</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($data, ['method' => 'PATCH','route' => ['delivery-bill.update', $data->id]]) !!}
                @csrf
                <div class="form-row">
                  <div class="col-md-4">
                    <div class="position-relative form-group">
                      <label for="date" class="">Bill Date</label>
                      <input type="date" name="date" class="form-control" id="date" placeholder="Enter Bill Date" value="{{ old('date',optional($data)->date) }}"  required>
                    </div> 
                  </div>
                  <div class="col-md-4">
                    <div class="position-relative form-group">
                        <label for="bill_number" class="">Bill Number</label>
                        <input type="text" name="bill_number" id="bill_number" class="form-control" placeholder="Enter Company Phone" value="{{ old('bill_number',optional($data)->bill_number) }}" required>
                    </div>   
                  </div>
                  <div class="col-md-4">
                    <div class="position-relative form-group">
                      <label for="party_id" class="">Party Name</label>
                      <select name="party_id" id="party_id" class="form-control" required>
                        <option value=null>Select Party</option>
                        @foreach ($parties as $party)
                            <option value="{{$party->id}}" {{ ($party->id == $data->party_id)?'selected':'' }} >{{$party->name}}</option>
                        @endforeach
                    </select>
                    </div> 
                  </div>
                  <div class="col-md-12">
                    <div class="position-relative form-group">
                      <label for="challan_id" class="">Challan No</label>
                      <select name="challan_id" id="challan_id" class="select2" multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                          @foreach ($collectChallan as $key=>$challan)
                             <option value="{{ $challan->id }}" selected>{{ $challan->chalan }}</option>
                          @endforeach
                      </select>
                    </div> 
                  </div>

                  <div class="form-block">
                    <div class="form-group">
                        <div class="row" id="recYarnTable">
                          <table class="table table-bordered stripe" width="100%">
                              <tr>
                                  <th>Order Number</th>
                                  <th>Febric Type</th>
                                  <th>Quantity In KG</th>
                                  <th>Rate</th>
                                  <th>Amount</th>
                                  <th>Note</th>
                              </tr>
                              @foreach ($fab_delivery_details as $key=>$bill)
                              <tr>
                                  <td>{{ $collectPartyorder[$key]->party_order_no }}</td>
                                  <td>{{ $collectFabtype[$key]->fabric_type }}</td>
                                  <td>{{ $bill->quantity }}<input type="hidden" name="fab_delivery_id[]" value="{{ $bill->fab_delivery_id  }}"></td>
                                  <td>{{ $bill->rate }}</td>
                                  <td>{{ $bill->amount }}</td>
                                  <td><input type="text" name="note[]" value="{{ $bill->note  }}"></td>
                              </tr>
                              @endforeach
                          </table>
                        </div>
                    </div>
                </div>

                </div>



                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                  <a href="{{ route('expense.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
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
            getPartyChallanInfo();
            //Assign party no
            var party = $("#party_id").val();
            $("#party_number").val(party);
            $("#recYarnTable").empty();
        })

        $("#challan_id").on('change', function() {
            var challan = $("#challan_id").val();
            getBillInfo(challan);
        })
    })

    function getPartyChallanInfo() {
      var party = $("#party_id").val();
        var url = "{{ url('account/get-challan') }}";
        $.ajax({
            type: "get",
            url: url,
            data: {
                id: party
            },
            success: function(data) {
                var html = "<option value="+null+">Select Challan</option>";
                $("#challan_id").empty();
                $.each(data.fabricDelivery, function(key) {
                  // console.log(data.fabricDelivery[key].brand);
                    html += "<option value="+data.fabricDelivery[key].id+">"+data.fabricDelivery[key].chalan+"</option>";
                })
                $("#challan_id").append(html);
                html = "";
            }
        })
    }

    function getBillInfo(challan) {
      var party = $("#party_id").val();
      var challan = challan;
        var url = "{{ url('account/get-challan-details') }}";
        $.ajax({
            type: "post",
            url: url,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id: party,
                challan: challan
            },
            success: function(data) {
                $("#recYarnTable").html(data.html);
                console.log(data);
                // $("#order_number").val(data.party_order_no);
                // $("#fabric_type").val(data.fabric_type);
                // $("#quantity").val(data.quantity);
                // $("#rate").val(data.rate);
                // $("#amount").val(data.amount);
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