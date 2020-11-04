<?php use App\Models\Beacon; ?>
<?php use App\Models\Country; ?>
@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ url('public/css/dataTables.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/buttons.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/dataTables.responsive.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/dataTables.tableTools.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/fixedHeader.dataTables.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/bootstrap-clockpicker.min.css') }}" />
<style media="screen">
th{
  text-transform: capitalize;
}
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>{{$TableName}}</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>Master</a></li>
      <li class="active"><strong>{{$TableName}}s</strong></li>
    </ol>
  </div>
  <div class="col-sm-2">
    <div class="title-action">
      <a href="{{url('Situation')}}" class="btn btn-success">Add {{$TableName}}</a>
    </div>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>{{$TableName}}<small> Tables</small></h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                {{Form::label('beacon_type_id','Beacon Type',['class'=>"text-capitalize"])}}
                {{Form::select('beacon_type_id',[''=>'All']+Beacon::typeOptions(),'',['class'=>'form-control select2_class table_change'])}}
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                {{Form::label('beacon_id','Beacon',['class'=>"text-capitalize"])}}
                {{Form::select('beacon_id',[''=>'All'],'',['class'=>'form-control table_change'])}}
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                {{Form::label('country_id','country',['class'=>"text-capitalize"])}}
                {{Form::select('country_id',[''=>'All']+Country::countryOptions(),'',['class'=>'form-control select2_class table_change'])}}
              </div>
            </div>
            <div class="col-md-5">
              <div class="col-md-6">
                <div class="form-group">
                  {{Form::label('opened_by','opened by *',['class'=>"text-capitalize"])}}
                  {{Form::select('opened_by',[''=>'All'],'',['class'=>'form-control table_change'])}}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{Form::label('closed_by','closed by *',['class'=>"text-capitalize"])}}
                  {{Form::select('closed_by',[''=>'All'],'',['class'=>'form-control table_change'])}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" id='dataTable' width="100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Beacon Type</th>
                  <th>Beacon no</th>
                  <th>country</th>
                  <th>registered</th>
                  <th>opened by</th>
                  <th>closed by</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ url('public/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.jqueryui.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ url('public/js/buttons.jqueryui.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.fixedColumns.min.js')}}"></script>
<script src="{{ url('public/js/buttons.colVis.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.responsive.js')}}"></script>
<script src="{{ url('public/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{ url('public/js/buttons.flash.min.js')}}"></script>
<script src="{{ url('public/js/jszip.min.js')}}"></script>
<script src="{{ url('public/js/pdfmake.min.js')}}"></script>
<script src="{{ url('public/js/vfs_fonts.js')}}"></script>
<script src="{{ url('public/js/buttons.html5.min.js')}}"></script>
<script src="{{ url('public/js/buttons.print.min.js')}}"></script>
<script src="{{ url('public/js/bootstrap-clockpicker.min.js')}}"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>
<script type="text/javascript">
$('#table_add_button').click(function() {
  $('#{{$TableName}}Form')[0].reset();
  $('#{{$TableName}}Form input[name="url"]').val('<?= url($TableName.'/Store') ?>');
});
var dataTable = $('#dataTable').dataTable({
  "processing": true,
  "serverSide": true,
  "fixedHeader": true,
  "lengthMenu": [ [50, 100, 200, 1000], [50, 100, 200, 1000, ] ],
  "ajax": {
    "url": "<?= route($TableName.'Table') ?>",
    "dataType": "json",
    "type": "POST",
    data: function(d) {
      d._token          =  "<?= csrf_token() ?>";
      d.country_id      = $('#country_id').val();
      d.opened_by       = $('#opened_by').val();
      d.closed_by       = $('#closed_by').val();
      d.beacon_type_id  = $('#beacon_type_id').val();
    },
  },
  dom: 'Bfrtip',
  buttons: [
    'colvis',
    {extend: 'excel',footer: true,exportOptions: {columns: ':visible'}},
    'pageLength',
  ],
  "columns": [
    { "data": "id", 'visible': false },
    { "data": "beacon_type_id"},
    { "data": "Beacon"},
    { "data": "Country"},
    { "data": "registered"},
    { "data": "OpenedBy"},
    { "data": "ClosedBy"},
    { "data": "action", 'visible': true },
  ],
});
$('.table_change').change(function(){
  dataTable.fnDraw();
});
</script>
<script type="text/javascript">
$(document).on('click', '.delete', function() {
  var table_id = $(this).attr('table_id');
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      var url_address = '{{$TableName}}/Delete/' + table_id;
      $.get(url_address, function(response) {
        if (response.result != 'success') { Swal.fire( 'Error!', response.result, 'error' ); return false; }
        dataTable.fnDraw();
      }, "json");
    }
  });
});
</script>
<script type="text/javascript">
$("#beacon_id").select2({
  placeholder: "Select Beacon",
  width: '100%',
  ajax: {
    url: '<?= url('Beacon/GetList') ?>',
    dataType: 'json',
    method: 'post',
    delay: 250,
    data: function(data) {
      return {
        _token        : "<?= csrf_token() ?>",
        search_tag    : data.term,
        beacon_type_id: $('#beacon_type_id').val(),
      };
    },
    processResults: function(data, params) {
      params.page = params.page || 1;
      return {
        results: $.map(data.items, function(obj) { return { id: obj.id, text: obj.name }; }),
        pagination: { more: (params.page * 30) < data.total_count }
      };
    },
    cache: true
  },
});
$("#opened_by,#closed_by").select2({
  placeholder: "Select Employee",
  width: '100%',
  ajax: {
    url: '<?= url('Employee/GetList') ?>',
    dataType: 'json',
    method: 'post',
    delay: 250,
    data: function(data) {
      return {
        _token    : "<?= csrf_token() ?>",
        search_tag: data.term,
        type: 'name',
      };
    },
    processResults: function(data, params) {
      params.page = params.page || 1;
      return {
        results: $.map(data.items, function(obj) { return { id: obj.id, text: obj.name }; }),
        pagination: { more: (params.page * 30) < data.total_count }
      };
    },
    cache: true
  },
});
</script>
@endsection
