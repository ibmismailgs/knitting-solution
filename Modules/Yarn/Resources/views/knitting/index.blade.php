@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Knitting')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Knitting Program</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Knitting Program list</li>
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
                <h3 class="card-title">Knitting Program list</h3>
                <a href="{{ route('knitting.create') }}" class="btn btn-primary float-right">Create</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Party Order No</th>
                        <th>Party Name</th>
                        <th width="180px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($knittingData as $data)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->party_order_no }}</td>
                            <td>{{ $data->party->name }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('knitting.show',$data->id) }}"><i class="fas fa-eye"></i></a>
                                {{-- <a class="btn btn-primary" href="{{ route('knitting.edit',$data->id) }}"><i class="fas fa-edit"></i></a> --}}

                                @if ($user_role->name =='super-admin')
                                 {!! Form::open(['method' => 'DELETE','route' => ['knitting.destroy', $data->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}
                                <a class="btn btn-primary" href="{{ route('knitting.add_more',$data->id) }}"><i class="fas fa-plus"></i></a>
                                 @endif
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
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
