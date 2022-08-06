@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-Daily-Report')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dayily Production Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">Dayily Production Report
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dayily Production Report</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="col-md-12">
                    <div class="portlet light bordered row">
                        <div class="col-md-1 caption font-green">
                            <span class="caption-subject text-lg-center">Filter</span>
                        </div>
                        <div class="col-md-11">
                            {{-- {{ Form::model($_REQUEST, ['method' => 'get',route('daily.production_report'), 'form-horizontal', 'role' => 'form']) }}
                            <div class="col-md-3">
                                {!! Form::date('date', old('date', $date), ['class' => 'form-control', 'placeholder' => 'Enter date']) !!}
                            </div>
                            <a href="{{ url('fabric/monthly_production_report') }}" class="btn btn-danger ,btn-sm"><i
                                    class="fa fa-times"></i> Refresh</a>
                            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i>
                                Search</button>
                            {{ Form::close() }} --}}
                            <input type="date" name="date_filter" id="date_filter">
                        </div>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Party Name</th>
                        <th>Operator Name</th>
                        <th>M/C No</th>
                        <th>M/C Dia</th>
                        <th>Order Quantity</th>
                        <th>Shift</th>
                        <th>Roll</th>
                        <th>Total Production</th>
                        <th>Balance</th>
                        <th>Rate/Kg</th>
                        <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->


          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
@section('script')
<script>
$(document).ready(function() {
  //Getting Knitting Details According to Party
  $('#date_filter').on('change',function(){
        var date_filter = $("#date_filter").val();
            var url = "{{ url('fabric/daily_production_report') }}";
        if(date_filter){
          // $('#example1').remove();
        $.ajax({
            type: "get",
            url: url,
            data: {
                date: date_filter
            },
            success: function(response) {
              console.log(response);
              if(response.length > 0){
                $("#example1 tbody").empty();
                var totalProduction=0;
                var totalAmount=0;
                var x = 1;
                  $.each( response, function( key, value ) {
                    var total_production=parseInt(value.total_production);
                    var total_amount=parseInt(value.amount);
                    totalProduction += total_production
                    totalAmount += total_amount
                    var row = '<tr><td> ' + x++ +
                    ' </td> <td> ' + value.party_name +
                    ' </td> <td>' + value.operator_name +
                    '</td> <td>' + value.mc_no +
                    '</td><td>' + value.mc_dia +
                    '</td><td>' + value.order_quantity +
                    '</td><td>' + value.shift +
                    '</td><td>' + value.roll +
                    '</td><td>' + value.total_production +
                    '</td><td>' + value.balance +
                    '</td><td>' + value.rate +
                    '</td><td>' + value.amount +
                    '</td> </tr>'
                          $("#example1 tbody").append(row);
                });
                var row_foot =  '</td><td>' +
                    '</td><td>'+
                    '</td><td>'+
                    '</td><td>'+
                    '</td><td>'+
                    '</td><td>'+
                    '</td><td>'+
                    '</td><td style="font-weight:bold">'+ 'Total Production :' +
                    '</td><td style="font-weight:bold">' + totalProduction +
                    '</td><td>'+
                    '</td><td style="font-weight:bold">'+ 'Total Amount :' +
                    '</td><td style="font-weight:bold">' + totalAmount +
                    '</td> </tr>'
                    $("#example1 tfoot").append(row_foot);
              }else{
                alert('Sorry! No Data Found!!!')
                $("#example1 tbody").empty();
              }

            }
          });
        }

    });
});

</script>
@endsection
@include('include.datatable-js')
