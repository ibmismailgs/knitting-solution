@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Yarn-Return-show')
@section('content')
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Return Yarn</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Return Yarn</li>
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
                <h3 class="card-title">Return Yarn</h3>
                <a href="{{ route('return_yarn.index') }}" class="btn btn-primary float-right mr-1">Back</a>
                <a href="{{ route('return_yarn.delivery_challan',$ret_yarn_first->ret_chalan) }}" class="btn btn-danger float-right mr-1">Delivery Challan</a>
                <a href="{{ route('return_yarn.gate_pass',$ret_yarn_first->ret_chalan) }}" class="btn btn-warning float-right mr-1">Gate Pass</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table class="" width="40%">
                  <tr class="col-md-12">
                      <th>Date</th>
                      <td>{{$ret_yarn_first->date}}</td>
                  </tr>

                  <tr>
                      <th>Return Chalan No</th>
                      <td>{{$ret_yarn_first->ret_chalan}}</td>
                  </tr>
                  <tr>
                      <th>Return Gate pass</th>
                      <td>{{$ret_yarn_first->ret_gate_pass}}</td>
                  </tr>

                  <tr>
                      <th>Party Name</th>
                      <td>{{$ret_yarn_first->party->name}}</td>
                  </tr>
                  {{-- <tr>
                      <th>Chalan</th>
                      <td></td>
                  </tr>
                  <tr>
                      <th>Quantity</th>
                      <td></td>
                  </tr> --}}
              </table>

              <table class="table table-bordered stripe" id="recYarnTable" style="margin-top:20px;">
                <thead>
                  <tr>
                    <th>Gate pass</th>
                    <th>Yarn Brand</th>
                    <th>Yarn count</th>
                    <th>Yarn lot</th>
                    <th>Return Quantity</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($return_yarns as $key=>$yearn) 
                    <tr>
                        <td>{{ $yearn->receiveYarn->gate_pass }}</td>
                        <td>{{ $yearn->receiveYarn->brand }}</td>
                        <td>{{ $yearn->receiveYarn->count }}</td>
                        <td>{{ $yearn->receiveYarn->lot }}</td>
                        <td>{{ $yearn->quantity }}</td>
                    </tr> 
                    @endforeach 
                </tbody>                             
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
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    $("#header").show();

    window.print();
    document.body.innerHTML = originalContents;
    $("#header").hide();
  }
</script>
@endsection
@include('include.datatable-js')