@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Party-List')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0">Total Party : {{ $total_party}}</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Party-List</li>
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

              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Party Name</th>
                        <th width="280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach ($parties as $party)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $party->name }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('order_list',$party->id)}}"><i class="fas fa-eye"></i></a>

                            </td>
                        </tr>
                        @endforeach
                  </tbody>
                   <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Party Name</th>
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
