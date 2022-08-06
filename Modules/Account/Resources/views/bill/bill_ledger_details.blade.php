@extends('layouts.admin.dashboard')
@include('include.datatable-css')

@section('content')
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Bill Ledger Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Bill Ledger Details</li>
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
                <h3 class="card-title">Bill Ledger Details of <b>{{ getPartyInfo($party_id)['name']}}</b> (STL NO - <b>{{ getPartyInfo($party_id)['stl_no'] }}</b> )</h3>
                <a href="{{ route('yarn_stock.index') }}" class="btn btn-primary btn-sm float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Bill Received</th>
                        <th>Bill Due</th>
                        <th>Current Due Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; $finalBalance = 0; ?>
                    @foreach ($bills as $key => $bill)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $bill->date }}</td>
                            <td>
                                @if(isset($bill->received_amount) && $bill->received_amount > 0)
                                    {{ $bill->received_amount }} BDT
                                    <?php $finalBalance -= $bill->received_amount; ?>
                                @endif
                            </td>
                            <td>
                                @if(isset($bill->amount) && $bill->amount > 0)
                                    {{ $bill->amount }} BDT
                                    <?php $finalBalance += $bill->amount; ?>
                                @endif
                            </td>

                            <td>
                                {{ $finalBalance }} BDT
                            </td>
                            
                        </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Bill Receivable</th>
                    <th>Bill Received</th>
                    <th>Current Balance</th>
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