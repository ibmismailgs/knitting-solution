@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', "Party's Order Number")
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">Party's Order Number</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Party's Order Number</li>
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
                <h3 class="card-title">Total Order : {{$total}}</h3>
                 <a href="{{url('party-order/')}}" class="btn btn-primary float-right">Back</a>
                <input type="button" class="btn btn-info float-right mr-1" onclick="printDiv('printableArea')" value="Print" />

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table class="table table-striped table-bordered table-hover">
                  <tr>
                      <th>Party Name</th>
                      <td>{{$party->name}}</td>
                  </tr>
              </table>
              </div>
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Order Number</th>
                        <th width="280px">Action</th>
                    </tr>
                  </thead>
                    <?php $i= 0;?>
                <tbody>
                @foreach ( $order as $value)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{$value->party_order_no}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{route('orderdetails',$value->id)}}"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                  @endforeach
                  </tbody>
                   <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Order Number</th>
                        <th width="280px">Action</th>
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

@include('include.datatable-js')
