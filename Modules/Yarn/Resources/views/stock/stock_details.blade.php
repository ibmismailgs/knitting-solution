@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Yarn-Stock-Ledger')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Yarn Stock Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Yarn Stock Details</li>
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
                <h3 class="card-title">Yarn Stock Details of <b>{{ getPartyInfo($party_id)['name']}}</b> (STL NO - <b>{{ getPartyInfo($party_id)['stl_no'] }}</b> )</h3>
                <a href="{{ route('yarn_stock.index') }}" class="btn btn-primary btn-sm float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Yarn Received</th>
                        <th>Yarn Returned</th>
                        <th>Knitting Program</th>
                        <th>Stock amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; $finalBalance = 0; ?>
                    @foreach ($datas as $key => $stock)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ date('d/m/Y', strtotime($stock->created_at)) }}</td>
                            <td>
                                @if(isset($stock->stock_in) && $stock->stock_in > 0)
                                    {{ $stock->stock_in }} Kg
                                    <?php $finalBalance += $stock->stock_in; ?>
                                @endif
                            </td>
                            <td>
                                @if(isset($stock->stock_out) && $stock->knitting_id == null && $stock->return_id > 0)
                                    {{ $stock->stock_out }} Kg
                                    <?php $finalBalance -= $stock->stock_out; ?>
                                @endif
                            </td>
                            <td>
                                @if(isset($stock->stock_out) && $stock->knitting_id > 0 && $stock->return_id == null)
                                    {{ $stock->stock_out }} Kg
                                    <?php $finalBalance -= $stock->stock_out; ?>
                                @endif
                            </td>
                            <td>
                                {{ $finalBalance }} Kg
                            </td>

                        </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Receive Yarn</th>
                    <th>Return Yarn</th>
                    <th>Knitting Program</th>
                    <th>Stock amount</th>
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
