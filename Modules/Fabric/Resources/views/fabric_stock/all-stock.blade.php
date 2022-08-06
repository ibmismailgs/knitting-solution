@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-Stock')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Fabric Stock (Receive)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fabric Stock (Receive)</li>
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
                <h3 class="card-title">Fabric Stock (Receive)</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  @include('fabric::fabric_stock.filter')
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th>Party Name</th>
                          <th>STL no</th>
                          <th>Stock amount</th>
                          <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 0; $totalQty = 0; ?>
                      @foreach ($stocks as $key => $stock)
                          <tr>
                              <td>{{ ++$i }}</td>
                              <td>{{ $stock->party->name }}</td>
                              <td>{{ $stock->party->stl_no }}</td>
                              <td>{{ $stock->stock_in - $stock->stock_out }} Kg</td>
                              <?php $totalQty += ($stock->stock_in - $stock->stock_out); ?>
                              <td><a class="btn btn-success" title="View Details" href="{{ route('fabric_stock.details',$stock->party_id) }}"><i class="fas fa-eye"></td>
                          </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3"><b class="float-right">Total</b></td>
                        <td><b>{{ $totalQty }} Kg</b></td>
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
