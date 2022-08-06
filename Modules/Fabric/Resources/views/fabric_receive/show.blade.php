@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-Receive-Show')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Fabric Receive</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fabric Receive list</li>
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
                <h3 class="card-title">Fabric Receive list</h3>
                <a href="{{ route('fabric_receive.index') }}" class="btn btn-primary float-right">Back</a>
                <input type="button" class="btn btn-info float-right mr-1" onclick="printDiv('printableArea')" value="Print" />
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
                    <td>{{ $data->chalan_no }}</td>
                  </tr>
                  <tr>
                    <th>Gate Pass</th>
                    <td>{{ $data->gate_pass_no }}</td>
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
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->


            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Fabric Receive Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Count</th>
                        <th>Lot</th>
                        <th>Roll</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($fab_rec_details as $fab_rec)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $fab_rec->count }}</td>
                            <td>{{ $fab_rec->lot }}</td>
                            <td>{{ $fab_rec->roll }}</td>
                            <td>{{ $fab_rec->quantity }}</td>
                            <td>
                                 @if ($user_role->name =='super-admin')
                              @if (count($fab_rec_details) == 1)
                                <button type="submit" title="This is last data" class="btn btn-warning"><i class="far fa-trash-alt"></i></button>
                              @else
                              {!! Form::open(['method' => 'DELETE','route' => ['fab_rec_details.destroy', $fab_rec->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                              {!! Form::close() !!}
                              @endif
                              @endif
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Count</th>
                        <th>Lot</th>
                        <th>Roll</th>
                        <th>Quantity</th>
                        <th>Action</th>
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
