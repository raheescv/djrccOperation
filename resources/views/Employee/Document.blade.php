@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ url('public/css/dataTables.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/buttons.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/dataTables.responsive.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/dataTables.tableTools.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/fixedHeader.dataTables.min.css') }}" />
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
          {!! Form::open(['id'=>$TableName.'Form','url'=>$TableName.'/Store']) !!}
          {{ Form::hidden('url',url($TableName.'/Store')) }}
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                {{Form::label('employee_id','Employee *')}}
                {{Form::select('employee_id',[''=>'Please Select'],[],['class'=>'form-control table_change','required'])}}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('document_type_id','Document Type *')}}
                {{Form::select('document_type_id',[''=>'Please Select'],[],['class'=>'form-control table_change','required'])}}
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                {{Form::label('date_of_issue','Date Of Issue *')}}
                {{Form::date('date_of_issue',date('Y-m-d'),['class'=>'form-control','id'=>'date_of_issue'])}}
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                {{Form::label('date_of_expiry','Date Of Expiry *')}}
                {{Form::date('date_of_expiry',date('Y-m-d'),['class'=>'form-control','id'=>'date_of_expiry'])}}
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group"><br>
                {{Form::button('save',['id'=>$TableName.'_save','class'=>'btn btn-success btn-fw'])}}
              </div>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <input type="hidden" id='table_edit_id' name="">
            <table class="table table-bordered table-hover table-striped" id='dataTable' width="100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Employee</th>
                  <th>DocumentType</th>
                  <th>Date Of Issue</th>
                  <th>Duration</th>
                  <th>Date Of Expiry</th>
                  <th>Remaining</th>
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
@component('component.'.'Employee'.'Model',['TableName'=>'Employee']) @endcomponent
@component('component.'.'DocumentType'.'Model',['TableName'=>'DocumentType']) @endcomponent
@endsection
@section('script')
<script src="{{ url('public/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.jqueryui.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ url('public/js/buttons.jqueryui.min.js')}}"></script>
<script src="{{ url('public/js/vfs_fonts.js')}}"></script>
<script src="{{ url('public/js/dataTables.fixedColumns.min.js')}}"></script>
<script src="{{ url('public/js/buttons.colVis.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.responsive.js')}}"></script>
<script src="{{ url('public/js/dataTables.tableTools.min.js')}}"></script>
<script type="text/javascript">
$("#employee_id").select2({
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
$("#document_type_id").select2({
  placeholder: "Select DocumentType",
  width: '100%',
  ajax: {
    url: '<?= url('DocumentType/GetList') ?>',
    dataType: 'json',
    method: 'post',
    delay: 250,
    data: function(data) {
      return {
        _token    : "<?= csrf_token() ?>",
        search_tag: data.term,
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
$('#employee_id').on("select2:select", function(e) {
  if($(this).val()=='Add') { $('#employee_id').val('').change(); $('#EmployeeModal').modal('toggle'); return false; }
  $('#document_type_id').select2('open');
});
$('#document_type_id').on("select2:select", function(e) {
  if($(this).val()=='Add') { $('#document_type_id').val('').change(); $('#DocumentTypeModal').modal('toggle'); return false; }
  $('#date_of_issue').select();
});
</script>
<script type="text/javascript">
var dataTable = $('#dataTable').dataTable({
  "processing": true,
  "serverSide": true,
  "fixedHeader": true,
  "order": [[ 5, "asc" ]],
  "lengthMenu": [ [50, 100, 200, 1000], [50, 100, 200, 1000, ] ],
  "ajax": {
    "url": "<?= route($TableName.'Table') ?>",
    "dataType": "json",
    "type": "POST",
    data: function(d) {
      d._token           = "<?= csrf_token() ?>";
      d.table_id         = $('#table_edit_id').val();
      d.employee_id      = $('#employee_id').val();
      d.document_type_id = $('#document_type_id').val();
    },
  },
  dom: 'Bfrtip',
  buttons: [
    'colvis',
    'pageLength',
  ],
  "columns": [
    { "data": "DT_RowIndex", 'visible': false },
    { "data": "Employee", },
    { "data": "DocumentType", },
    { "data": "date_of_issue", },
    { "data": "Duration", 'visible': false },
    { "data": "date_of_expiry", },
    { "data": "Remaining", },
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
$('#{{$TableName}}Form').keypress(function(event) {
  var keycode = (event.keyCode ? event.keyCode : event.which);
  if (keycode == '13') {$('#{{$TableName}}_save').click(); return false; }
});
$('#{{$TableName}}_save').click(function() {
  if(!$('#{{$TableName}}Form').valid()) return false;
  var data = $('#{{$TableName}}Form').serialize();
  var url_address = $('#{{$TableName}}Form input[name="url"]').val();
  $.post(url_address, data, function(response) {
    if (response.result != 'success') { Swal.fire( 'Error!', response.result, 'error' ); return false; }
    // $('#{{$TableName}}Form')[0].reset();
    dataTable.fnDraw();
  }, "json");
});
$('#{{$TableName}}Form').validate({
  rules: {
    employee_id:{ required: true, },
    document_type_id:{ required: true, },
    date_of_issue:{ required: true, },
    date_of_expiry:{ required: true, },
  },
  messages: {
    employee_id:{ required: "Required", },
    document_type_id:{ required: "Required", },
    date_of_issue:{ required: "Required", },
    date_of_expiry:{ required: "Required", },
  },
  errorPlacement: function(error,element) {
    error.insertAfter(element);
  }
});
$(document).on('click','.edit',function(){
  var table_id=$(this).attr('table_id');
  $('#table_edit_id').val(table_id);
  dataTable.fnDraw();
});
$(document).on('click','.ok_Document',function(){
  var table_id=$(this).attr('table_id');
  $.ajax({
    url: 'Document/Update/'+table_id,
    type: 'post',
    data: {
      _token: "<?= csrf_token() ?>",
      date_of_issue:$('#edit_Document_date_of_issue').val(),
      date_of_expiry:$('#edit_Document_date_of_expiry').val(),
    },
    dataType: 'JSON',
    success: function (response) {
      if (response.result != 'success') { Swal.fire( 'Error!', response.result, 'error' ); return false; }
      $('#table_edit_id').val(0);
      dataTable.fnDraw();
    },
    error: function (data) {
      console.log(data);
    },
  });
});
</script>
@endsection
