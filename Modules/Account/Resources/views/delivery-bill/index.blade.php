@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Delivery-Bill')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Delivery Bill</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Delivery Bill</li>
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
                <h3 class="card-title">Delivery Bill list</h3>
                <a href="{{ route('delivery-bill.create') }}" class="btn btn-primary float-right">Create</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Bill Number</th>
                        <th>Party Name</th>
                        <th width="180px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($delivery_bills as $key=>$bill)
                      <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $bill->date }}</td>
                        <td>{{ $bill->bill_number }}</td>
                        <td>{{ $bill->name }}</td>
                        <td>
                            <a class="btn btn-success" href="{{ route('delivery-bill.show',$bill->id) }}"><i class="fas fa-eye"></i></a>
                             @if ($user_role->name =='super-admin')
                          <a class="btn btn-primary" href="{{ route('delivery-bill.edit',$bill->id) }}"><i class="fas fa-edit"></i></a>

                          {!! Form::open(['method' => 'DELETE','style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
                              {{-- {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!} --}}
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
