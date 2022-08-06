@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Bill-Ledger')
@section('content')
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Bill Ledger</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Bill Ledger</li>
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
                <h3 class="card-title">Bill Ledger</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @include('account::bill.filter_bill_ledger')
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Party Name</th>
                        <th>Party No</th>
                        <th>Receivable</th>
                        <th>Received</th>
                        <th>Due</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; $total_receivable=0;$total_received=0; ?>
                    @foreach ($bills as $key => $bill)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $bill->party->name }}</td>
                            <td>{{ $bill->party_id }}</td>
                            <td>
                              {{ $bill->amount }}
                              @php
                                 $total_receivable+=$bill->amount;
                              @endphp
                            </td>
                            <td>
                              {{ $bill->received_amount }}
                            @php
                                $total_received+=$bill->received_amount;
                            @endphp
                            </td>
                            <td>{{$bill->amount - $bill->received_amount}}</td>
                            <td><a class="btn btn-success" title="View Details" href="{{ route('bill.ledger.details',$bill->party_id) }}"><i class="fas fa-eye"></i></a></td>
                        </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="3"></th>
                      <th>Total: {{$total_receivable}}</th>
                      <th>Total: {{$total_received}}</th>
                      <th>Total: </th>
                      <th></th>
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