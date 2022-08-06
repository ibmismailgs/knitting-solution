@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-Production-Show')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Production</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Production list</li>
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
                <h3 class="card-title">Production list</h3>
                <a href="{{ route('production.index') }}" class="btn btn-primary float-right">Back</a>
                <input type="button" class="btn btn-info float-right mr-1" onclick="printDiv('printableArea')" value="Print" />
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                 <table class="table table-bordered table-hover">
                  <tr>
                      <th>Date</th>
                      <td>{{ $production->date }}</td>
                  </tr>
                  <tr>
                      <th>Party Name</th>
                      <td>{{ $production->party->name }}</td>
                  </tr>
                  <tr>
                      <th>Party Order No.</th>
                      <td>{{ $production->knittingprogram->party_order_no }}</td>
                  </tr>
                  <tr>
                      <th>Knitting Program</th>
                      <td>{{ $production->knittingprogramDetails->stl_order_no }}</td>
                  </tr>
                  <tr>
                    <th>M/C Dia</th>
                    <td>{{ $production->mc_dia }}</td>
                  </tr>
                  <tr>
                    <th>M/C No</th>
                    <td>{{ $production->mc_no }}</td>
                  </tr>
                  <tr>
                    <th>Order Quantity</th>
                    <td>{{ $production->order_qty }}</td>
                  </tr>
                   <tr>
                      <th>Total Production</th>
                      <td>{{ $total_production->quantity}} Kg</td>
                  </tr>
                   <tr>
                      <th>Total Roll</th>
                      <td>{{ $total_production->roll }} Roll</td>
                  </tr>
                  <tr>
                      <th>Note</th>
                      <td>{{ $production->note }}</td>
                  </tr>
              </table>
            <table  class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Operator Name</th>
                <th>Roll</th>
                <th>Produced Quantity</th>
                <th>Shift</th>
                <th>Rate/Kg</th>
                <th>Amount</th>
              </tr>
            </thead>
            <br>
            <?php $i=1;?>
            <tbody>
              @foreach ($productiondetails as $details)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $details->employee->name }}</td>
                <td>{{ $details->roll }}</td>
                <td>{{ $details->quantity }}</td>
                <td>
                  @if ($details->shift == 1)
                  Day
                  @else
                  Night
                  @endif
                </td>
                <td>{{ $details->rate }}</td>
                <td>{{ $details->amount }}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
                <tr>
                <th>No</th>
                <th>Operator Name</th>
                <th>Roll</th>
                <th>Produced Quantity</th>
                <th>Shift</th>
                <th>Rate/Kg</th>
                <th>Amount</th>
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
