@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Employee')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Employee</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee list</li>
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
                <h3 class="card-title">Employee list</h3>
                <a href="{{ route('employee.create') }}" class="btn btn-primary float-right">Create</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>DOB</th>
                        <th>Father</th>
                        <th>Mother</th>
                        <th>NID</th>
                        <th>Present Address</th>
                        <th>Joining Date</th>
                        <th width="200px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($employees as $key => $employee)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->dob }}</td>
                            <td>{{ $employee->f_name }}</td>
                            <td>{{ $employee->m_name }}</td>
                            <td>{{ $employee->nid }}</td>
                            <td>{{ $employee->present_address }}</td>
                            <td>{{ $employee->join_date }}</td>
                            <td>
                                <a class="btn btn-success" href="{{ route('employee.show',$employee->id) }}"><i class="fas fa-eye"></i></a>
                               @if($user_role->name =="super-admin")
                                <a class="btn btn-primary" href="{{ route('employee.edit',$employee->id) }}"><i class="fas fa-edit"></i></a>
                                {!! Form::open(['method' => 'DELETE','route' => ['employee.destroy', $employee->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
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
                        <th>Name</th>
                        <th>Phone</th>
                        <th>DOB</th>
                        <th>Father</th>
                        <th>Mother</th>
                        <th>NID</th>
                        <th>Present Address</th>
                        <th>Joining Date</th>
                        <th width="200px">Action</th>
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
