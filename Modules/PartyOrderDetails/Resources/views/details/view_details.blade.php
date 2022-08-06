@extends('layouts.admin.dashboard')
@include('include.datatable-css')
@section('title', "Party's Order Details")
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Party's Order Details</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Party's Order Details</li>
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
                            <h3 class="card-title">Order Number : <b>{{ $knitting_id->party_order_no }}</b></h3>
                            <a href="{{url('party-order/')}}" class="btn btn-primary float-right">Back</a>
                            <input type="button" class="btn btn-info float-right mr-1" onclick="printDiv('printableArea')" value="Print" />

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#kintting" data-toggle="tab">Kintting Program </a></li>
                                    <li class="nav-item"><a class="nav-link" href="#production" data-toggle="tab">Fabric Production</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#delivery"
                                        data-toggle="tab">Fabric Delivery</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#yarnstock" data-toggle="tab">Yarn Stock</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#fabricstock" data-toggle="tab">Fabrick Stock</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="kintting">
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <th>Date</th>
                                                <td>{{ $knitting_detail->date }}</td>
                                            </tr>
                                            <tr>
                                                <th>STL Order No</th>
                                                <td>{{ $knitting_detail->stl_order_no }}</td>
                                            </tr>
                                            <tr>
                                                <th>Brand</th>
                                                <td>{{ $knitting_detail->brand }}</td>
                                            </tr>
                                            <tr>
                                                <th>Count</th>
                                                <td>{{ $knitting_detail->count }}</td>
                                            </tr>
                                            <tr>
                                                <th>Lot</th>
                                                <td>{{ $knitting_detail->lot }}</td>
                                            </tr>
                                            <tr>
                                                <th>Buyer Name</th>
                                                <td>{{ $knitting_detail->buyer_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Knitting Qty</th>
                                                <td>{{ $knitting_detail->knitting_qty }} Kg</td>
                                            </tr>
                                            <tr>

                                                <tr>
                                                    <th>Mc Dia</th>
                                                    <td>{{ $knitting_detail->mc_dia }}</td>
                                                </tr>
                                                <tr>
                                                    <th>F Dia</th>
                                                    <td>{{ $knitting_detail->f_dia }}</td>
                                                </tr>
                                                <tr>
                                                    <th>F GSM</th>
                                                    <td>{{ $knitting_detail->f_gsm }}</td>
                                                </tr>
                                                <tr>
                                                    <th>SL</th>
                                                    <td>{{ $knitting_detail->sl }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Colour</th>
                                                    <td>{{ $knitting_detail->colour }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Fabric Type</th>
                                                    <td>{{ $knitting_detail->fabric_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Rate</th>
                                                    <td>{{ $knitting_detail->rate }} </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="production">
                                            <!-- The timeline -->
                                            <div class="timeline-inverse">
                                                <table class="table table-bordered table-hover">
                                                    <a href="" data-toggle="modal" data-target="#closedProduction" class="btn btn-primary float-right" style="margin-bottom: 10px;">Close Production </a>
                                                    @if($fabric_stock)
                                                    <tr>
                                                        <th>Party Name</th>
                                                        <td>{{ $fabric_stock->knittingprogram->party->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>STL No</th>
                                                        <td>{{ $fabric_stock->knittingprogram->party->stl_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Party Order No</th>
                                                        <td>{{$fabric_stock->knittingprogram->party_order_no}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Total Stock</th>
                                                        <td>{{$fabric_stock->quantity}} Kg</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Roll</th>
                                                        <td>{{$fabric_stock->roll}} Roll</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Amount</th>
                                                        <td>{{$fabric_stock->amount}} </td>
                                                    </tr>
                                                    @endif

                                                </table>
                                                <table id="example" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Operator Name</th>
                                                            <th>Roll</th>
                                                            <th>Shift</th>
                                                            <th>Quantity</th>
                                                            <th>Rate</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach ($stockdetails as $details)
                                                        <tr>
                                                            <td>{{ ++$i }}</td>
                                                            <td>{{ $details->employee->name }}</td>
                                                            <td>{{ $details->roll }}</td>
                                                            <td>@if ($details->shift == 1)
                                                                Day
                                                                @else
                                                                Night
                                                            @endif </td>
                                                            <td>{{ $details->quantity }} Kg</td>
                                                            <td>{{ $details->rate }} </td>
                                                            <td>{{ $details->amount }} </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Operator Name</th>
                                                            <th>Roll</th>
                                                            <th>Shift</th>
                                                            <th>Quantity</th>
                                                            <th>Rate</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->

                                        <div class="tab-pane" id="delivery">
                                            <div class="timeline-inverse">

                                                <table id="example1" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>SN </th>
                                                            <th>Quantity </th>
                                                            <th>Roll </th>
                                                            <th>Challan </th>
                                                            <th>Gate Paass </th>
                                                            <th>Truck Number </th>
                                                            <th>Driver </th>
                                                            <th width="280px">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <?php $i =0; ?>
                                                    <tbody>
                                                        @foreach ($fabric as $key => $party)
                                                        <tr>
                                                            <td>{{ ++$i }}</td>
                                                            <td>{{ $party->quantity }} Kg</td>
                                                            <td>{{ $party->roll }} Roll</td>
                                                            <td>{{ $party->chalan }}</td>
                                                            <td>{{ $party->gate_pass }}</td>
                                                            <td>{{ $party->truck_number }}</td>
                                                            <td>{{ $party->driver }}</td>
                                                            <td>
                                                                <a class="btn btn-primary" href="{{route('fabricdetails',$party->id)}}"><i class="fas fa-eye"></i></a>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>SN </th>
                                                        <th> Quantity </th>
                                                        <th> Roll </th>
                                                        <th>Challan </th>
                                                        <th>Gate Paass </th>
                                                        <th>Truck Number </th>
                                                        <th>Driver </th>
                                                        <th width="280px">Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                        <div class="tab-pane" id="yarnstock">
                                            <!-- The timeline -->
                                            <div class="timeline-inverse">
                                                <table class="table table-bordered table-hover">

                                                    <tr>
                                                        <th width="50%">Current Yarn Stock</th>
                                                        <td><b>{{$current_yarn_stock}} Kg </b></td>
                                                    </tr>

                                                </table>

                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->

                                        <div class="tab-pane" id="fabricstock">
                                            <!-- The timeline -->

                                            <div class="timeline-inverse">
                                                <table class="table table-bordered table-hover" width="100%">

                                                    @if($currentstocks)
                                                    <tr>
                                                        <th width="50%">Current Fabric Stock</th>
                                                        <td><b>{{ $currentstocks ->quantity - $currentstocks ->delivery_quantity }} Kg </b></td>
                                                    </tr>

                                                    <tr >
                                                        <th width="50%">Current Roll Stock </th>
                                                        <td><b>{{ ($currentstocks->roll) - ($currentstocks->delivery_roll_quantity) }} Roll </b></td>
                                                    </tr>
                                                        @else
                                                        <tr>
                                                        <th width="50%">Current Fabric Stock</th>
                                                        <td><b>0 Kg </b></td>
                                                    </tr>

                                                    <tr >
                                                        <th width="50%">Current Roll Stock </th>
                                                        <td><b>0 Roll </b></td>
                                                    </tr>
                                                    @endif


                                                </table>

                                        </div>
                                        <!-- /.tab-pane -->

                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                            <!-- /.card-body -->

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
 <!-- Modal -->
<form enctype="multipart/form-data" action="{{ route('closeproduction.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="closedProduction" tabindex="-1" role="dialog" aria-labelledby="closedProduction" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content ">
                <div class="modal-header ">
                    <h5 class="modal-title text-center" id="closedProduction" ><b>Close Production</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="returnproduct">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Party Order</label>
                        <input type="hidden" name="knitting_id" id="" value="{{$knitting_id->id }}">
                        <input type="text" class="form-control" value="{{$knitting_id->party_order_no}}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Available Return Quantity</label>
                        <input style="color:black" type="text" id="currentyarn" class="form-control" value="{{$current_yarn_stock}} Kg" readonly>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Return Quantity</label>
                        <input  oninput="validCheck()" id="return_quantity" type="number" name="return_quantity" class="form-control  @error('return_quantity') is-invalid @enderror" id="return_quantity" placeholder="Enter Return Quantity" required>
                        <div class="help-block with-errors"></div>

                        @error('return_quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
        {{-- End Modal --}}

@endsection
{{-- @include('include.datatable-js') --}}
@section('script')
<script>
       function validCheck(){
            var currentyarn = $('#currentyarn').val();
            var return_quantity = $('#return_quantity').val();
            var current_yarn=parseInt(currentyarn);
            var return_yarn_quantity=parseInt(return_quantity);

        if(return_yarn_quantity > current_yarn){
            alert('Whoops! Yarn return quantity can not be more than available yarn current stock');
        $('#return_quantity').val(null);
      }
    }
</script>
<script>
$( document ).ready(function() {
    $("#example").DataTable({
    });

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

</script>
@endsection

