@extends('layouts.admin.dashboard')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Due Bill</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Due Bill</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Due Bill</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('bill-due.update') }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-row">
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="name" class="">Date</label>
                            <input type="date" name="date" class="form-control" id="date" placeholder="Enter date" value="{{ old('date') }}"  required>
                        </div>   
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="name" class="">Party Name</label>
                            <select name="party_id" id="party_id" class="form-control">
                                <option value=null>Select Party</option>
                                @foreach ($parties as $key => $item)
                                    <option value="{{$key}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>   
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="name" class="">Amount</label>
                            <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter amount" value="{{ old('amount') }}" required>
                        </div>   
                    </div>
                  </div>               
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary center">Submit</button>
                  <a href="{{ route('bill.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
        </div>

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
@section('script')
<script>
    $(document).ready(function() {
      $("#delivery_id, #party_id").on('change', function(){
        var del_id = $("#delivery_id").val();
        var prty_id = $("#party_id").val();
        var url = "{{ url('account/get-bill-amount') }}";
        $.ajax({
              type: "get",
              url: url,
              data: {
                delivery_id: del_id,
                party_id: prty_id
              },
              success: function(data) {
                $("#payable_amount").val('Total Bill: '+data.totalBill+',   Paid: '+data.paidAmount+',   Payable: '+data.payable);
              }
          })
      })
    })
</script>
@endsection