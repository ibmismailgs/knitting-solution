@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Party-Delivery-Details')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0">Party Delivery Details</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"> Party Delivery Details</li>
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
                <h3 class="card-title"> Party Delivery Details</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table class="table table-bordered table-hover">
                         <tr>
                              <th>Party Name </th>
                            <td>{{ $delivery_details->name }}</td>
                        </tr>
                          <tr>
                              <th>Party Order No </th>
                            <td>{{ $delivery_details->party_order_no }}</td>
                        </tr>
                          <tr>
                              <th>Challan No</th>
                            <td>{{ $delivery_details->chalan }}</td>
                        </tr>
                        <tr>
                            <th>Gate Pass </th>
                        <td>{{ $delivery_details->gate_pass }}</td>
                        </tr>
                        <tr>
                             <th>Truck Number </th>
                         <td>{{ $delivery_details->truck_number }}</td>
                        </tr>
                        <tr>
                             <th>Driver Name</th>
                                <td>{{ $delivery_details->driver }}</td>
                        </tr>
                        <tr>
                             <th>Amount </th>
                            <td>{{$delivery_details->amount}} Tk</td>
                        </tr>
                        <tr>
                            <th>Rate</th>
                            <td>{{$delivery_details->drate}} </td>
                        </tr>
                        <tr>
                            <th>Receive id</th>
                            <td>{{$delivery_details->receive_id}}</td>
                        </tr>
                        <tr>
                            <th>Order No</th>
                            <td>{{$delivery_details->order_no}}</td>
                        </tr>
                        <tr>
                            <th>STL No</th>
                            <td>{{$delivery_details->stl_no}}</td>
                        </tr>
                        <tr>
                            <th>Buyer Name</th>
                            <td>{{$delivery_details->buyer_name}}</td>
                        </tr>
                        <tr>
                            <th>Brand</th>
                            <td>{{$delivery_details->brand}}</td>
                        </tr>
                        <tr>
                            <th>Count</th>
                            <td>{{$delivery_details->count}}</td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td>{{$delivery_details->quantity}} Kg</td>
                        </tr>
                        <tr>
                            <th>Lot</th>
                            <td>{{$delivery_details->lot}}</td>
                        </tr>
                        <tr>
                            <th>Roll</th>
                            <td>{{$delivery_details->droll}} Roll</td>
                        </tr>
                        <tr>
                            <th>Dia Gauza</th>
                            <td>{{$delivery_details->dia_gauza}}</td>
                        </tr>
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

@include('include.datatable-js')
