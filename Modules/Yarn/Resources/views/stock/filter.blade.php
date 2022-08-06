<div class="container-fluid">
    {{Form::model($_REQUEST,['method'=>'get','form-horizontal','role'=>'form'])}}
    <div class="row mb-2">
      <div class="col-sm-1">
        Filter
      </div><!-- /.col -->
      <div class="col-sm-11">
        {!! Form::select('party_id', $parties, null, ['class' => 'form-control col-sm-5 select2 d-md-inline-flex', 'placeholder' => 'Select Party Name']) !!}
        <a href="{{url('yarn/yarn_stock')}}" class="btn btn-danger btn-xl"><i class="fa fa-times"></i> Clear</a>
        <button class="btn btn-success btn-xl" type="submit"><i class="fa fa-search"></i> Filter</button>
      </div><!-- /.col -->
    </div><!-- /.row -->
    {{Form::close()}}
</div>
