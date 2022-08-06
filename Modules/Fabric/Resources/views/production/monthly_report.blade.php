@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-Production-Monthly-Report')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0">{{$page_title}}</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{$page_title}}</li>
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
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="portlet light bordered row">
                            <div class="col-md-1 caption font-green">
                                <span class="caption-subject text-lg-center">Filter</span>
                            </div>
                            <div class="col-md-11">
                        <form enctype="multipart/form-data" action="{{ route('monthly.production_report') }}" method="POST" >
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <select id="" name="month" class="form-control">
                                    (@isset($months)
                                      <option value="{{ $months }}" selected>{{ $months }} </option>
                                     @endisset)
                                        <option value="">Select Month</option>
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="Auguest">Auguest</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                  <select class="form-control"  name="year" id="yearpicker" required>
                                      (@isset($years)
                                      <option value="{{ $years }}" selected>{{ $years }}</option>
                                      @endisset)
                                      <option value="">Select Year</option>
                                  </select>
                                </div>

                                <div class="col-sm-3">
                                <button type="submit" id="search" class="btn btn-info float-left search"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                  <thead>
                   <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Total Production</th>
                        <th>Total Roll</th>
                        <th>Total Amount</th>
                    </tr>
                  </thead>
                  @php
                      $sn = 0;
                  @endphp
                  <tbody>
                    @foreach ($dates as $item)
                    <tr class="show">
                        <td>{{ ++$sn }}</td>
                        <td >{{ $item }}</td>
                        <td>{{ getDailyTotalProduction($item) }}</td>
                        <td>{{ getDailyRoll($item) }}</td>
                        <td>{{ getDailyAmount($item) }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                       <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Total Production</th>
                        <th>Total Roll</th>
                        <th>Total Amount</th>
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
@section('script')
<script type="text/javascript">
$( document ).ready(function() {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    // year
    let startYear = 1950;
    let endYear = new Date().getFullYear();
    for (i = endYear; i > startYear; i--)
    {
      $('#yearpicker').append($('<option></option>').val(i).html(i));
    }
});
</script>
@endsection

