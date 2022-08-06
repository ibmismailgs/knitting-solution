@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Yarn-show')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Receive Yarn</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Receive Yarn</li>
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
                <h3 class="card-title">Receive Yarn</h3>
                <a href="{{ route('receive_yarn.index') }}" class="btn btn-primary float-right">Back</a>
                <input type="button" class="btn btn-info float-right mr-1" onclick="printDiv('printableArea')" value="Print" />
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table class="table table-bordered table-hover">
                  <tr>
                      <th>Date</th>
                      <td>{{ $data->receive->date }}</td>
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
                      <th>Gate pass</th>
                      <td>{{ $data->gate_pass }}</td>
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
                <h3 class="card-title">Received Yarn Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Yran Brand</th>
                        <th>Yran Count</th>
                        <th>Yran Lot</th>
                        <th>Roll / Bag</th>
                        <th>Receiving Quantity</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($receiveYrans as $item)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{$item->brand}}</td>
                          <td>{{$item->count}}</td>
                          <td>{{$item->lot}}</td>
                          <td>{{$item->roll}}</td>
                          <td>{{$item->quantity}}</td>
                          <td>
                               @if ($user_role->name =='super-admin')
                            <a class="btn btn-primary" href="{{ route('receive_yarn.edit',$item->id) }}"><i class="fas fa-edit"></i></a>

                            {!! Form::open(['method' => 'DELETE','route' => ['receive_yarn.destroy', $item->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
                                <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                            {!! Form::close() !!}
                             @endif
                        </td>
                        </tr>
                    @endforeach
                  </tbody>

                </table>
              </div>
              <!-- /.card-body -->

            </div>


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
