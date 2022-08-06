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
            <h1 class="m-0">Bill</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Bill list</li>
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
                <h3 class="card-title">Bill list</h3>
                <a href="{{ route('bill.create') }}" class="btn btn-success float-right ml-2" title="Create Bill">Receive Bill</a>
                <a href="{{ route('bill-due.create') }}" class="btn btn-primary float-right" title="Create Due Bill">Create Due</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Party Name</th>
                        <th>Bill No</th>
                        <th>Money Receive</th>
                        <th>Payment</th>
                        <th>Amount</th>
                        <th width="180px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; $total=0; ?>
                    @foreach ($bills as $key => $bill)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $bill->date }}</td>
                            <td>{{ $bill->party->name }}</td>
                            <td>{{ $bill->bill_no }}</td>
                            <td>{{ $bill->money_rec_no }}</td>
                            <td>{{ getPaymentType($bill->payment_type) }}</td>
                            <td>{{ $bill->received_amount }}
                            @php
                                $total += $bill->received_amount;
                            @endphp
                            </td>
                            <td>
                                 @if ($user_role->name =='super-admin')
                                 <a class="btn btn-primary" href="{{ route('bill.edit',$bill->id) }}"><i class="fas fa-edit"></i></a>

                                {!! Form::open(['method' => 'DELETE','route' => ['bill.destroy', $bill->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
                                    {{-- {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!} --}}
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th colspan="6"></th>
                    <th>Total BDT: {{number_format($total,2)}}/=</th>
                    <th></th>
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
