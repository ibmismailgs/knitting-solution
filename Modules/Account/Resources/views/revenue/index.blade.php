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
            <h1 class="m-0">Revenue</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Revenue list</li>
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
                <h3 class="card-title">Revenue list</h3>
                <a href="{{ route('revenue.create') }}" class="btn btn-primary float-right">Create</a>
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
                        <th>Source/Reason</th>
                        <th>Cash Type</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th width="180px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($revenues as $key => $revenue)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $revenue->date }}</td>
                            <td>{{ $revenue->party->name }}</td>
                            @if (isset($revenue->bill_id))
                              <td>{{ $revenue->bill->bill_no }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>{{ $revenue->reason }}</td>
                            <td>{{ getPaymentType($revenue->type) }}</td>
                            <td>{{ $revenue->amount }}</td>
                            <td>{{ $revenue->note }}</td>
                            <td>
                                 @if ($user_role->name =='super-admin')
                                <a class="btn btn-primary" href="{{ route('revenue.edit',$revenue->id) }}"><i class="fas fa-edit"></i></a>

                                {!! Form::open(['method' => 'DELETE','route' => ['revenue.destroy', $revenue->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
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
                    <th>No</th>
                    <th>Date</th>
                    <th>Party Name</th>
                    <th>Bill No</th>
                    <th>Source/Reason</th>
                    <th>Cash Type</th>
                    <th>Amount</th>
                    <th>Note</th>
                    <th width="180px">Action</th>
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
