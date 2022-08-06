@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', 'Received-Fabric-Stock-Ledger')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Fabric Stock Details (Receive)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fabric Stock Details (Receive)</li>
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
                <h3 class="card-title">Stock Details of <b>{{ getPartyInfo($party_id)['name']}}</b> (STL NO - <b>{{ getPartyInfo($party_id)['stl_no'] }}</b> )</h3>
                <a href="{{ route('fabric_stock.get') }}" class="btn btn-primary btn-sm float-right">Back</a>
                <input type="button" class="btn btn-info btn-sm float-right mr-1" onclick="printDiv('printableArea')" value="Print" />
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th>Date</th>
                          <th>Fabric Received</th>
                          <th>Fabric Delivered</th>
                          <th>Stock</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 0; $currentBalance = 0; ?>
                      @foreach ($stocks as $key => $stock)
                          <tr>
                              <td>{{ ++$i }}</td>
                              <td>{{ $stock->receiveFabric->date }}</td>
                              <td>
                                  @if (isset($stock->stock_in) && $stock->receive_id > 0 && $stock->delivery_id == null)
                                    {{ $stock->stock_in }}
                                    <?php $currentBalance += $stock->stock_in; ?>
                                  @endif
                              </td>
                              <td>
                                    @if (isset($stock->stock_out) && $stock->delivery_id > 0)
                                        {{ $stock->stock_out }}
                                        <?php $currentBalance -= $stock->stock_out; ?>
                                    @endif
                              </td>
                              <td>{{ $currentBalance }}</td>
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
@section('script')
<script>
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
@include('include.datatable-js')
