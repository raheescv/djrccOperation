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
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" id='dataTable' width="100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
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
@component('component.'.$TableName.'Model',['TableName'=>$TableName]) @endcomponent
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
      d._token = "<?= csrf_token() ?>";
    },
  },
  dom: 'Bfrtip',
  buttons: [
    'colvis',
    'pageLength',
  ],
  "columns": [
    { "data": "DT_RowIndex", 'visible': false },
    { "data": "name", "width":"80%"},
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
$(document).on('click', '.edit', function() {
  var table_id = $(this).attr('table_id');
  url_address = '{{$TableName}}/Get/' + table_id;
  $.get(url_address, function(response) {
    $('#{{$TableName}}Form input[name="url"]').val('<?= url($TableName.'/Update') ?>' + '/' + table_id);
    $('#{{$TableName}}Form input[name="name"]').val(response.name);
    $('#{{$TableName}}Modal').modal('show');
  }, "json");
});
</script>
@endsection
