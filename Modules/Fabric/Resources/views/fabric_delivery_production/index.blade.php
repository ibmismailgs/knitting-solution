@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-P-Delivery')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Fabric Delivery</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fabric Delivery list</li>
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
                <h3 class="card-title">Fabric Delivery list</h3>
                <a href="{{ route('fabric_delivery.prod.create') }}" class="btn btn-primary float-right">Create</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Party Name</th>
                        <th>Order No</th>
                        <th>STL No</th>
                        <th>Delivery Quantity</th>
                        <th>Delivery Roll</th>
                        <th>Bill</th>
                        <th width="180px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->order_no }}</td>
                            <td>{{ $data->stl_no }}</td>
                            <td>{{ $data->quantity }}</td>
                            <td>{{ $data->roll }}</td>
                            <td>{{ $data->bill }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('fabric_delivery.prod.show',$data->id) }}"><i class="fas fa-eye"></i></a>
                                 @if ($user_role->name =='super-admin')
                                <a class="btn btn-primary" href="{{ route('fabric_delivery.prod.edit',$data->id) }}"><i class="fas fa-edit"></i></a>

                                {!! Form::open(['method' => 'DELETE','route' => ['fabric_delivery.prod.delete', $data->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
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
                        <th>Order No</th>
                        <th>STL No</th>
                        <th>Delivery Quantity</th>
                        <th>Delivery Roll</th>
                        <th>Bill</th>
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
