@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-Weekly-Report')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Weekly Production Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Weekly Production Report</li>
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
                    <div class="col-md-12">
                        <div class="portlet light bordered row">
                            <div class="col-md-11">
                               <form enctype="multipart/form-data" action="{{ route('weekly.production_report') }}" method="POST" >
                            @csrf
                            <div class="form-group row">
                                <label for="inputPassword">From Date : </label>
                                <div class="col-sm-3">
                                <input type="date" class="form-control" value="{{ $start_date }}" id="start_date" name="start_date" placeholder="Enter first date" required>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <label for="inputPassword" >To Date : </label>
                                <div class="col-sm-3">
                                <input type="date" class="form-control" id="end_date" name="end_date"  value="{{ $end_date }}" placeholder="Enter end date" required>
                                </div>&nbsp;&nbsp;&nbsp;
                                <button type="submit" id="search" class="btn btn-info float-left search"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </form>
                            </div>
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
                        <th>Date</th>
                        <th>Total Production</th>
                        <th>Total Roll</th>
                        <th>Total Amount</th>
                    </tr>
                  </thead>
                  @php
                      $sn = 0;
                  @endphp
                  <tbody>
                    @foreach ($dates as $item)
                    <tr class="show">
                        <td>{{ ++$sn }}</td>
                        <td >{{ $item }}</td>
                        <td>{{ getDailyTotalProduction($item) }}</td>
                        <td>{{ getDailyRoll($item) }}</td>
                        <td>{{ getDailyAmount($item) }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                       <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Total Production</th>
                        <th>Total Roll</th>
                        <th>Total Amount</th>
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
