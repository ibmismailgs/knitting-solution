@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Knitting-show')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Knitting Program</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Knitting Program list</li>
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
                <h3 class="card-title">Knitting Program list</h3>
                <a href="{{ route('knitting.index') }}" class="btn btn-primary float-right">Back</a>
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
                      <th>Party Order No</th>
                      <td>{{ $data->party_order_no }}</td>
                  </tr>
                  <tr>
                      <th>STL No</th>
                      <td>{{ $data->party->stl_no }}</td>
                  </tr>
                  <tr>
                      <th>Party Name</th>
                      <td>{{ $data->party->name }}</td>
                  </tr>
                  <tr>
                      <th>Total Knitting Quantity</th>
                      <td>{{ getTotalKnittingQty($data->id) }}</td>
                  </tr>
              </table>
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->


            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Knitting Program Details</h3>
                <a class="btn btn-primary btn-sm float-right" href="{{ route('knitting.add_more',$data->id) }}"><i class="fas fa-plus"></i></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-responsive">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>STL No</th>
                        <th>Buyer Name</th>
                        <th>Challan</th>
                        <th>Yarn Brand</th>
                        <th>Yarn Lot</th>
                        <th>Yarn Count</th>
                        <th>M/C Dia</th>
                        <th>F Dia</th>
                        <th>F GSM</th>
                        <th>SL</th>
                        <th>Colour</th>
                        <th>Fabric Type</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($knitting_details as $data)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->stl_order_no}}</td>
                            <td>{{ $data->buyer_name}}</td>
                            <td>{{ getReceiveYarnInfo($data->receive_id)['chalan'] }}</td>
                            <td>{{ $data->brand}}</td>
                            <td>{{ $data->lot}}</td>
                            <td>{{ $data->count}}</td>
                            <td>{{ $data->mc_dia}}</td>
                            <td>{{ $data->f_dia}}</td>
                            <td>{{ $data->f_gsm}}</td>
                            <td>{{ $data->sl}}</td>
                            <td>{{ $data->colour}}</td>
                            <td>{{ $data->fabric_type}}</td>

                            <td>{{ $data->knitting_qty }}</td>
                            <td>{{ $data->rate }}</td>
                            <td>{{( $data->rate) * ($data->knitting_qty) }}</td>
                            <td>
                                 @if ($user_role->name =='super-admin')
                              <a class="btn btn-primary" href="{{ route('knitting_details.edit',$data->id) }}"><i class="fas fa-edit"></i></a>

                                {!! Form::open(['method' => 'DELETE','route' => ['knitting_details.destroy', $data->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}
                                 @endif
                            </td>
                        </tr>
                    @endforeach
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
