@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Fabric-Stock-Ledger')
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
              <div class="card-header" >
                <h3 class="card-title">Fabric Stock (Production)</h3>
                <input type="button" class="btn btn-info btn-sm float-right" onclick="printDiv('printableArea')" value="Print" />
              </div>
              <!-- /.card-header -->
              <?php $i = 0; $totalproduced = 0; $totaldelivery = 0; $currentStock = 0; $totalrollproduced=0; $totalrolldelivery=0; $currentrollStock=0; ?>
              <div class="card-body">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>SL</th>
                        <th>Total Production</th>
                        <th>Total Roll Production</th>
                        <th>Total Delivered</th>
                        <th>Total Roll Delivered</th>
                        <th>Current Stock</th>
                        <th>Current Roll Stock</th>
                          {{-- <th>SL</th>
                          <th colspan="2" scope="colgroup" class="p-0 text-center" style=""><p class="my-1">Produced</p>
                            <table style="width:100%">
                              <th style="width:50%">Quantity</th>
                              <th style="width:50%">Roll</th>
                            </table>
                          </th>
                          <th colspan="2" scope="colgroup" class="p-0 text-center" style="vertical-align:middle"><p class="my-1">Delivered</p>
                            <table style="width:100%">
                              <th style="width:50%">Quantity</th>
                              <th style="width:50%">Roll</th>
                            </table>
                          </th>
                          <th colspan="2" scope="colgroup" class="p-0 text-center" style="vertical-align:middle"><p class="my-1">Current Stock</p>
                            <table style="width:100%">
                              <th style="width:50%">Quantity</th>
                              <th style="width:50%">Roll</th>
                            </table>
                          </th> --}}
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($productions as $key => $production)
                          <tr>
                              <td>{{ ++$i }}</td>

                              @if ($production->quantity)
                                <td>{{ $production->quantity }}
                                  @php
                                      $totalproduced+=$production->quantity;
                                      $currentStock+=$production->quantity;
                                  @endphp
                                </td>
                                <td>{{ $production->roll }}
                                  @php
                                      $totalrollproduced+=$production->roll;
                                      $currentrollStock+=$production->roll;
                                  @endphp
                                </td>
                              @else
                              <td>0</td>
                              <td>0</td>
                              @endif

                              @if ($production->delivery_quantity)
                                <td>{{ $production->delivery_quantity }}
                                  @php
                                      $totaldelivery+=$production->delivery_quantity;
                                      $currentStock-=$production->delivery_quantity;
                                  @endphp
                                </td>
                                <td>{{ $production->delivery_roll_quantity ? $production->delivery_roll_quantity : 0 }}
                                  @php
                                      $totalrolldelivery+=$production->delivery_roll_quantity;
                                      $currentrollStock-=$production->delivery_roll_quantity;
                                  @endphp
                                </td>
                              @else
                                <td>0</td>
                                <td>0</td>
                              @endif
                              <td>{{$currentStock ? $currentStock : 0}}</td>
                              <td>{{$currentrollStock ? $currentrollStock : 0}}</td>
                          </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="1" class="text-right">Total Calculation</th>
                        <th>Total Production : {{$totalproduced}} KG</th>
                        <th>Total Roll Production: {{$totalrollproduced}} Roll</th>
                        <th>Total Delivered: {{$totaldelivery}} KG</th>
                        <th>Total Roll Delivered: {{$totalrolldelivery}} Roll</th>
                        <th>Current Stock: {{$totalproduced - $totaldelivery}}</th>
                        <th>Current Roll Stock: {{$totalrollproduced - $totalrolldelivery}}</th>
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

