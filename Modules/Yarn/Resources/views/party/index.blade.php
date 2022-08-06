@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Party')
@section('content')
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Total Party: {{$total_party}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Party list</li>
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
                <h3 class="card-title">Party list</h3>
                <a href="{{ route('party.create') }}" class="btn btn-primary float-right">Create</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Phone</th>
                        <th>Contact Person</th>
                        <th>STL no</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th width="280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($parties as $key => $party)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $party->name }}</td>
                            <td>{{ $party->designation }}</td>
                            <td>{{ $party->phone }}</td>
                            <td>{{ $party->contact_person }}</td>
                            <td>{{ $party->stl_no }}</td>
                            <td>{{ $party->email }}</td>
                            <td>{{ $party->address }}</td>
                            <td> 
                                <a class="btn btn-primary" href="{{ route('party.edit',$party->id) }}"><i class="fas fa-edit"></i></a>
                            
                                {!! Form::open(['method' => 'DELETE','route' => ['party.destroy', $party->id],'style'=>'display:inline', 'onclick' => 'return confirm("Are you sure you want to delete this item?");']) !!}
                                    {{-- {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!} --}}
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Phone</th>
                    <th>Contact Person</th>
                    <th>STL no</th>
                    <th>Email</th>
                    <th>Address</th>
                        <th width="280px">Action</th>
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