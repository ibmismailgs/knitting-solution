@extends('layouts.admin.dashboard')
@include('include.datatable-css')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Fabric Delivery</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fabric Delivery Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" id="printableArea">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Fabric Delivery Production Details</h3>
                <a href="{{ route('fabric_delivery.prod.index') }}" class="btn btn-primary float-right">Back</a>
                <a href="{{ route('fabric_delivery.prod.bill',$data->id) }}" class="btn btn-info btn-md float-right mr-1">Delivery Bill</a>
                <a href="{{ route('fabric_delivery.prod.challan',$data->id) }}" class="btn btn-danger btn-md float-right mr-1">Delivery Challan</a>
                <a href="{{ route('fabric_delivery.prod.gatePass',$data->id) }}" class="btn btn-warning btn-md float-right mr-1">Gate Pass</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table class="table table-bordered table-hover">
                  <tr>
                      <th>Date</th>
                      <td>{{$data->date}}</td>
                  </tr>
                  <tr>
                    <th>Party Name</th>
                    <td>{{ $data->party->name }}</td>
                  </tr>
                  <tr>
                    <th>Chalan</th>
                    <td>{{ $data->chalan }}</td>
                  </tr>
                  <tr>
                    <th>Gate Pass</th>
                    <td>{{ $data->gate_pass }}</td>
                  </tr>
                  <tr>
                      <th>Order No</th>
                      <td>{{$data->order_no}}</td>
                  </tr>
                  <tr>
                    <th>Total Value</th>
                    <td>{{$data->bill}}</td>
                </tr>
                  <tr>
                      <th>Note</th>
                      <td>{{$data->note}}</td>
                  </tr>
              </table>
              <table class="table table-bordered table-hover" style="margin-top:20px;">
                   <thead>
                       <tr>
                            <th>STL Order No</th>
                            <th>Rate</th>
                            <th>Roll</th>
                            <th>Dia_Gauza</th>
                            <th>Delivery Quantity</th>
                            <th>Amount</th>
                       </tr>
                   </thead>
                   <tbody>
                       @php
                           $total_qty = 0; $total_amount = 0; $total_roll = 0;
                       @endphp
                      @foreach ($delivery_details as $key=>$detail)
                          <tr>
                              <td>{{ $detail->stl_order_no }}</td>
                              <td>{{ $detail->rate }}</td>
                              <td>{{ $detail->roll }}</td>
                              <td>{{$detail->dia_gauza}}</td>
                              <td>{{ $detail->quantity }}</td>
                              <td>{{ $detail->amount }}</td>
                              @php
                                  $total_qty += $detail->quantity;
                                  $total_amount += $detail->amount;
                                  $total_roll += $detail->roll;
                              @endphp
                          </tr>
                      @endforeach
                   </tbody>
                   <tfoot>
                        <tr>
                          <td>Total Amount</td>
                          <td></td>
                          <td><b>{{$total_roll}}</b></td>
                          <td></td>
                          <td><b>{{ $total_qty }}</b></td>
                          <td><b>{{ $total_amount }}</b></td>
                        </tr>
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

</script>
@endsection
@include('include.datatable-js')
