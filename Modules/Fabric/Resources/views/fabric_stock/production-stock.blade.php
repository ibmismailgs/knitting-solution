@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-P-Stock')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Fabric Stock (Production)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fabric Stock (Production)</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" id="printableArea">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Fabric Stock (Production)</h3>
                <input type="button" class="btn btn-info btn-sm float-right" onclick="printDiv('printableArea')" value="Print" />
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  @include('fabric::fabric_stock.production_filter')
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                     <tr>
                          <th>SN</th>
                          <th>Party Name</th>
                          <th>STL No</th>
                          <th>Total Stock</th>
                          <th>Total Roll Stock</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 0; $tatalSum = 0; $tatalRollSum=0;?>
                      @foreach ($prod_stocks as $key => $stock)
                          <tr>
                              <td>{{ ++$i }}</td>
                              <td>{{ $stock->party->name }}</td>
                              <td>{{ $stock->party->stl_no }}</td>
                              <td>{{ $stock->quantity - $stock->delivery_quantity }} KG
                              @php
                                  $tatalSum+=$stock->quantity - $stock->delivery_quantity;
                              @endphp
                              </td>
                              <td>{{ $stock->roll - $stock->delivery_roll_quantity }} Roll
                                @php
                                    $tatalRollSum+=$stock->roll - $stock->delivery_roll_quantity;
                                @endphp
                              </td>
                              <td><a class="btn btn-success" title="View Details" href="{{ route('fabric_stock_production.details',$stock->party_id) }}"><i class="fas fa-eye"></td>
                          </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th></th>
                        <th>Total Stock</th>
                        <th>{{$tatalSum}} KG</th>
                        <th>{{$tatalRollSum}} Roll</th>
                        <th></th>
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
<script>
    $(function () {
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
  });

  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;

    $("#header").show();

    window.print();

    document.body.innerHTML = originalContents;
    $("#header").hide();
  }
</script>
@endsection
