@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('public/css/dataTables.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/buttons.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.responsive.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.tableTools.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/fixedHeader.dataTables.min.css') }}" />
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Reminder</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>Forms</a></li>
      <li class="active"><strong>Reminder</strong></li>
  </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Remarks<small> Tables</small></h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
          {!! Form::open(['id'=>'ReminderForm']) !!}
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                {{Form::label('date','Date')}}
                {{Form::date('date',date('Y-m-d',strtotime('+2 day')),['class'=>'form-control'])}}
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                {{Form::label('subject','Subject')}}
                {{Form::text('subject','',['class'=>'form-control','autofocus'])}}
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group"><br>
                {{Form::button('save',['id'=>'save','class'=>'btn btn-success btn-fw'])}}
              </div>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped table-condensed" id='dataTable' width="100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Day</th>
                  <th>Subject</th>
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
<script src="{{ asset('public/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.jqueryui.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('public/js/buttons.jqueryui.min.js')}}"></script>
<script src="{{ asset('public/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('public/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('public/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('public/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.fixedColumns.min.js')}}"></script>
<script src="{{ asset('public/js/buttons.colVis.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.responsive.js')}}"></script>
<script src="{{ asset('public/js/dataTables.tableTools.min.js')}}"></script>
<script type="text/javascript">
  var dataTable=$('#dataTable').dataTable( {
    "processing": true,
    "serverSide": true,
    "fixedHeader": true,
    "lengthMenu": [[ 50, 100, 200,1000], [ 50, 100, 200,1000, ]],
    "ajax": {
      "url":"<?= route('reminder_data_ajax') ?>",
      "dataType":"json",
      "type":"POST",
      data:function(d){
        d._token= "<?= csrf_token() ?>";
      },
    },
    dom: 'Bfrtip',
    buttons: [
    'colvis',
    {extend: 'copyHtml5'  ,footer: true,exportOptions: {columns: ':visible'}},
    {extend: 'excelHtml5' ,footer: true,exportOptions: {columns: ':visible'}},
    {extend: 'csvHtml5'   ,footer: true,exportOptions: {columns: ':visible'}},
    {extend: 'pdfHtml5'   ,footer: true,exportOptions: {columns: ':visible'}},
    'pageLength',
    ],
    "createdRow": function( row, data, dataIndex ) {
      if ( data['day'] >0 )
      {
        $(row).addClass('table-success');
      }
      if ( data['day'] < 0 )
      {
        $(row).addClass('table-danger');
      }
      if ( data['day'] == 0 )
      {
        $(row).addClass('table-info');
      }
    },
    "columns":[
    {"data":"id",'visible':false},
    {"data":"date"},
    {"data":"day"},
    {"data":"subject",'width':'70%'},
    {"data":"action",'visible':false},
    ],
  } );
</script>
<script type="text/javascript">
$('#ReminderForm').keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which); if (keycode == '13') {$('#save').click(); return false; }
});
  $('#save').click(function(){
    var data=$('#ReminderForm').serialize();
    var url_address='<?= route('reminder_store_ajax') ?>';
    $.post( url_address,data, function( response ) {
      if(response.result!='success')
      {
        alert(response.result);
        return false;
      }
      $('#ReminderForm')[0].reset();
      dataTable.fnDraw();
      $('#subject').focus();
    }, "json");
  });
</script>
<script type="text/javascript">
  $(document).on('click','.delete',function(){
    if(!confirm("Are you sure?")) { return false; }
    var table_id=$(this).closest('td span').attr('table_id');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url: 'reminders/delete/'+table_id,
      type: 'get',
      data: {_token: CSRF_TOKEN, id:table_id},
      dataType: 'JSON',
      success: function (data) {
        dataTable.fnDraw();
      }
    });
  });
</script>
@endsection
