@extends('layouts.admin.dashboard')
@section('title', 'Fabric-Receive-Create')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Receive Fabric</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Receive Fabric</li>
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
                <h3 class="card-title">Create Receive Fabric</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('fabric_receive.store') }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date" class="form-control" id="date" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="party_id" class="col-sm-2 col-form-label">Party Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="party_id" id="party_id" class="form-control" required>
                            <option value=null>Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{$party->id}}">{{$party->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="chalan" class="col-sm-2 col-form-label">Chalan No<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="chalan" class="form-control" id="chalan" placeholder="Enter chalan no" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="gate_pass" class="col-sm-2 col-form-label">Gate pass</label>
                    <div class="col-sm-10">
                        <input type="text" name="gate_pass" class="form-control" id="gate_pass" placeholder="Enter Gate pass">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="order_no" class="col-sm-2 col-form-label">Order No</label>
                    <div class="col-sm-10">
                        <input type="text" name="order_no" class="form-control" id="order_no" placeholder="Enter Order no">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stl_no" class="col-sm-2 col-form-label">STL No</label>
                    <div class="col-sm-10">
                        <input type="text" name="stl_no" class="form-control" id="stl_no" placeholder="Enter stl no" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="buyer_name" class="col-sm-2 col-form-label">Buyer Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="buyer_name" class="form-control" id="buyer_name" placeholder="Enter Buyer name">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Note</label>
                    <div class="col-sm-10">
                        <input type="text" name="note" class="form-control" id="note" placeholder="Enter note">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-1">
                      <button id="add_more" class="btn btn-info mt-4"><i class="fa fa-plus" title="Add More Product"></i></button>
                    </div>
                    <div class="col-md-11">
                      <div class="form-row">
                        <div class="col-md-6">
                          <div class="position-relative form-group">
                            <label for="lot" class="">Yarn lot</label>
                            <input name="lot[]" id="lot" placeholder="Yarn lot" type="text" class="form-control" value="{{ old('lot') }}" required>
                          </div>
                      </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                              <label for="count" class="">Yarn count</label>
                              <input type="text" name="count[]" id="count" placeholder="Yarn count" class="form-control" value="{{ old('count') }}" required>
                            </div>
                        </div>
                      </div>
                  
                      <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                              <label for="roll" class="">Roll</label>
                              <input name="roll[]" id="roll" placeholder="Enter roll" type="text" class="form-control" value="{{ old('roll') }}" required>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                              <label for="quantity" class="">Quantity(Kg)</label>
                              <input name="quantity[]" id="quantity" placeholder="Quantity(Kg)" type="number" step="0.01" class="form-control amount" value="{{ old('quantity') }}" required>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="more_field">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                  <a href="{{ route('fabric_receive.index') }}" class="btn btn-warning float-right mr-1">Cancel</a>
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
		var max_fields      = 15;
		var wrapper         = $("#more_field");
		var add_button      = $("#add_more");

		var x = 1;
		$(add_button).click(function(e){
			e.preventDefault();
			if(x < max_fields){
				x++;
				var html ='<div class="row">';
				html += '<div class="col-md-1">';
				html += '<a href="#" class="remove_field">';
				html += '<button style="margin-top: 30px;" class="btn btn-warning"><i class="fa fa-minus" title="Remove Item"></i></button>';
				html += '</a></div><div class="col-md-11">';
				html += '<div class="form-row"><div class="col-md-6"><div class="position-relative form-group">';
				html += '<label for="lot" class="">Yarn lot</label>';
				html += '<input name="lot[]" id="lot" placeholder="Yarn lot" type="text" class="form-control" value="{{ old('lot') }}">';
				html += '</div></div><div class="col-md-6"><div class="position-relative form-group">';
				html += '<label for="count" class="">Yarn count</label>';
				html += '<input type="text" name="count[]" id="count" placeholder="Yarn count" class="form-control" value="{{ old('count') }}">';
				html += '</div></div></div>';
				html += '<div class="form-row"><div class="col-md-6"><div class="position-relative form-group">';
				html += '<label for="roll" class="">Roll</label>';
				html += '<input name="roll[]" id="roll" placeholder="Enter roll" type="text" class="form-control" value="{{ old('roll') }}">';
				html += '</div></div><div class="col-md-6"><div class="position-relative form-group">';
				html += '<label for="quantity" class="">Quantity(Kg)</label>';
				html += '<input name="quantity[]" id="quantity" placeholder="Quantity(Kg)" type="number" class="form-control amount" value="{{ old('quantity') }}">';
				html += '</div></div></div></div></div>';

        $(wrapper).append(html);

				$('#quant').attr('id', "quantity"+x);
	            $('#rater').attr('id', "rate"+x);
	            $('#amounter').attr('id', "amount"+x);

	            var quantityd = $("#quantity"+x);
	            var rated = $("#rate"+x);

	            rated.on("change keyup", (function(){
	                var rat1 = $(this).attr("id").slice(4);

	                var total = isNaN(parseFloat(rated.val()* quantityd.val())) ? 0 :(rated.val()* quantityd.val());
	                console.log(total);
	                $("#amount"+rat1).val((total).toFixed(2));
	                totalCalculation();
	            }));

	            quantityd.on("change keyup",(function(){
	                var rat2 = $(this).attr("id").slice(8);
	                var total = isNaN(parseInt(rated.val()* quantityd.val())) ? 0 :(rated.val()* quantityd.val())
	                $("#amount"+rat2).val((total).toFixed(2));
	                totalCalculation();
	            }));
			}
		});

		$(wrapper).on("click",".remove_field", function(e){
			e.preventDefault();
			$(this).parent().parent('div').remove();
			x--;
			totalCalculation();
		})

    $("#party_id").on('change', function(){
      var party_id = $("#party_id").val();
      var url = "{{ url('fabric/get-party-stl-no') }}";
          $.ajax({
              type: "GET",
              url: url,
              data: {
                  id: party_id
              },
              success: function(data) {
                $("#stl_no").val(data.stl_no);
              }
           })
     })
	});
</script>
@endsection