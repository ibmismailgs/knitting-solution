@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-Production')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Production</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Production list</li>
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
                <h3 class="card-title">Production list</h3>
                <a href="{{ route('production.create') }}" class="btn btn-primary float-right">Create</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Party Name</th>
                        <th>Party Order No.</th>
                        <th>Knitting Program</th>
                        <th>M/C No</th>
                        <th>M/C Dia</th>
                        <th>Order Quantity</th>
                        <th width="180px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($productions as $key => $production)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $production->party->name }}</td>
                            <td>{{ $production->knittingprogram->party_order_no }}</td>
                            <td>{{ $production->knittingprogramDetails->stl_order_no }}</td>
                            <td>{{ $production->mc_no }}</td>
                            <td>{{ $production->mc_dia }}</td>
                            <td>{{ $production->order_qty }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('production.show',$production->id) }}"><i class="fas fa-eye"></i></a>

                                 @if ($user_role->name =='super-admin')
                                <a class="btn btn-primary" href="{{ route('production.edit',$production->id) }}"><i class="fas fa-edit"></i></a>

                                {!! Form::open(['method' => 'DELETE','route' => ['production.destroy', $production->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                        <th>No</th>
                        <th>Party Name</th>
                        <th>Party Order No.</th>
                        <th>Knitting Program</th>
                        <th>M/C No</th>
                        <th>M/C Dia</th>
                        <th>Order Quantity</th>
                        <th width="180px">Action</th>
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
