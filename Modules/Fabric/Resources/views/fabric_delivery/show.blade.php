@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-Delivery_view')
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
                <h3 class="card-title">Fabric Delivery list</h3>
                <a href="{{ route('fabric_receive.index') }}" class="btn btn-primary float-right">Back</a>
                <a href="{{ route('fabric_receive.delivery_challan',$data->id) }}" class="btn btn-danger btn-md float-right mr-1">Delivery Challan</a>
                <a href="{{ route('fabric_receive.gate_pass',$data->id) }}" class="btn btn-warning btn-md float-right mr-1">Gate Pass</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table class="table table-bordered table-hover">
                  <tr>
                      <th>Date</th>
                      <td>{{ $data->date }}</td>
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
                      <td>{{ $data->order_no }}</td>
                  </tr>
                  <tr>
                      <th>Stl No</th>
                      <td>{{ $data->stl_no }}</td>
                  </tr>
                  <tr>
                      <th>Buyer Name</th>
                      <td>{{ $data->buyer_name }}</td>
                  </tr>
                  <tr>
                      <th>Note</th>
                      <td>{{ $data->note }}</td>
                  </tr>
              </table>
              <table class="table table-bordered table-hover" style="margin-top:20px;">
                   <thead>
                       <tr>
                          <th>Lot</th>
                          <th>Count</th>
                          <th>Roll</th>
                          <th>Quantity</th>
                          <th>Rate</th>
                          <th>Amount</th>
                       </tr>
                   </thead>
                   <tbody>
                     @php
                         $total_quantity = 0; $total_amount = 0;
                     @endphp
                      @foreach ($details as $key=>$item)
                          <tr>
                              <td>{{$item->lot}}</td>
                              <td>{{$item->count}}</td>
                              <td>{{$item->roll}}</td>
                              <td>{{$item->quantity}}</td>
                              <td>{{$item->rate}}</td>
                              <td>{{$item->amount}}</td>
                              @php
                                  $total_quantity += $item->quantity;
                                  $total_amount += $item->amount;
                              @endphp
                          </tr>
                      @endforeach
                   </tbody>
                   <tfoot>
                        <tr>
                          <td>Total Amount</td>
                          <td></td>
                          <td></td>
                          <td>{{$total_quantity}}</td>
                          <td></td>
                          <td>{{$total_amount}}</td>
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
