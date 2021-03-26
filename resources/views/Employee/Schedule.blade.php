@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ url('public/css/dataTables.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/buttons.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/dataTables.responsive.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/dataTables.tableTools.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/fixedHeader.dataTables.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/select.dataTables.min.css') }}" />
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
      <button class="btn btn-success" data-toggle="modal" id='table_add_button' data-target="#{{$TableName}}Modal">Add {{$TableName}}</button>
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
                {{Form::label('from_date','From Date')}}
                {{Form::date('from_date',date('Y-m-d'),['class'=>'form-control table_change'])}}
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                {{Form::label('to_date','To Date')}}
                {{Form::date('to_date',date('Y-m-d'),['class'=>'form-control table_change'])}}
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                {{Form::label('from_time','From Time')}}
                {{Form::time('from_time',date('00:01'),['class'=>'form-control table_change'])}}
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                {{Form::label('to_time','To Time')}}
                {{Form::time('to_time',date('23:59'),['class'=>'form-control table_change'])}}
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {{Form::label('employee_id','Employee')}}
                {{Form::select('employee_id',[''=>'Please Select'],[],['class'=>'form-control table_change'])}}
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
                  <th>Employee</th>
                  <th>date</th>
                  <th>time</th>
                  <th>remarks</th>
                  <th>action</th>
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
@component('component.'.$TableName.'Model',['TableName'=>$TableName]) @endcomponent
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
<script src="{{ url('public/js/dataTables.select.min.js')}}"></script>
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
dataTable = $('#dataTable').DataTable({
  "processing": true,
  "serverSide": true,
  "fixedHeader": true,
  "lengthMenu": [ [50, 100, 200, 1000], [50, 100, 200, 1000, ] ],
  "ajax": {
    "url": "<?= route($TableName.'Table') ?>",
    "dataType": "json",
    "type": "POST",
    data: function(d) {
      d._token        = "<?= csrf_token() ?>";
      d.employee_id = $('#employee_id').val();
      d.from_date     = $('#from_date').val();
      d.to_date       = $('#to_date').val();
      d.from_time     = $('#from_time').val();
      d.to_time       = $('#to_time').val();
    },
  },
  dom: 'Bfrtip',
  select: true,
  buttons: [
    'colvis',
    {extend: 'excel',footer: true,exportOptions: {columns: ':visible'}},
    {
      text: 'Print Selected',
      action: function ( e, dt, node, config ) {
        var selectedRows=dataTable.rows('.selected').data();
        var selectedId=[];
        selectedRows.each((item, i) => { selectedId.push(item.id); });
        if(!selectedId.length){ Swal.fire( 'Error!', 'Please Select Any Row To Print it', 'error' ); return false }
        var url_address = '{{url($TableName."/Print")}}/'+selectedId;
        window.open(url_address, '_blank');
      }
    },
    'pageLength',
  ],
  select: {
    style:    'os',
    selector: 'td:first-child'
  },
  "columns": [
    { "data": "id", 'visible': true,'className':"select-checkbox" },
    { "data": "Employee"},
    { "data": "date"},
    { "data": "time"},
    { "data": "remarks",'width':"50%" },
    { "data": "action", 'visible': true,'width':"10%" },
  ],
});
$('.table_change').change(function(){
  dataTable.draw();
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
        dataTable.draw();
      }, "json");
    }
  });
});
$(document).on('click', '.edit', function() {
  var table_id = $(this).attr('table_id');
  url_address = '{{$TableName}}/Get/' + table_id;
  $.get(url_address, function(response) {
    $('#{{$TableName}}Form input[name="url"]').val('<?= url($TableName.'/Update') ?>' + '/' + table_id);
    $('#{{$TableName}}Form input[name="date"]').val(response.date);
    $('#{{$TableName}}Form input[name="entry_time"]').val(response.entry_time);
    $('#{{$TableName}}Form input[name="exit_time"]').val(response.exit_time);
    $('#modal_employee_id').empty().append('<option selected value="'+response.employee_id+'">'+response.employee.name+'</option>');
    $('#remarks').val(response.remarks);
    $('#{{$TableName}}Modal').modal('show');
  }, "json");
});
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
        type      : 'name',
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
