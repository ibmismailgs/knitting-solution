@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Yarn')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Receive Yarn</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Receive Yarn list</li>
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
                <h3 class="card-title">Receive Yarn list</h3>
                <a href="{{ route('receive_yarn.create') }}" class="btn btn-primary float-right">Create</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Party Name</th>
                        <th>Chalan</th>
                        <th>Gate pass</th>
                        <th width="280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($rec_yarn as $key => $yarn)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $yarn->receive->date }}</td>
                            <td>{{ $yarn->party->name }}</td>
                            <td>{{ $yarn->chalan }}</td>
                            <td>{{ $yarn->gate_pass }}</td>
                            <td>
                                <a class="btn btn-success" href="{{ route('receive_yarn.show',$yarn->id) }}"><i class="fas fa-eye"></i></a>
                                @if ($user_role->name =='super-admin')

                                <a class="btn btn-primary" href="{{ route('receive_yarn.edit',$yarn->id) }}"><i class="fas fa-edit"></i></a>

                                {!! Form::open(['method' => 'DELETE','route' => ['receive_yarn.destroy', $yarn->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
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
