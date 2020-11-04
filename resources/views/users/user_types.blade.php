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
    <h2>UserTypes</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>Master</a></li>
      <li class="active"><strong>UserTypes</strong></li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>UserType<small> Tables</small></h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
          {!! Form::open(['id'=>'UserTypeForm']) !!}
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                {{Form::label('name','name')}}
                {{Form::text('name','',['class'=>'form-control','autofocus'])}}
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
            <input type="hidden" id='table_edit_id' name="">
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
@endsection
@section('script')
<script src="{{ asset('public/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.jqueryui.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('public/js/buttons.jqueryui.min.js')}}"></script>
<script src="{{ asset('public/js/vfs_fonts.js')}}"></script>
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
      "url":"<?= route('UserTypeTable') ?>",
      "dataType":"json",
      "type":"POST",
      data:function(d){
        d._token  = "<?= csrf_token() ?>";
        d.table_id= $('#table_edit_id').val();
      },
    },
    dom: 'Bfrtip',
    buttons: [
    'colvis',
    'pageLength',
    ],
    "columns":[
    {"data":"id",'visible':false},
    {"data":"name",'width':'80%'},
    {"data":"action",'visible':false},
    ],
  } );
</script>
<script type="text/javascript">
$('#UserTypeForm').keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which); if (keycode == '13') {$('#save').click(); return false; }
});
  $('#save').click(function(){
    var data=$('#UserTypeForm').serialize();
    var url_address='<?= route('UserType_store_ajax') ?>';
    $.post( url_address,data, function( response ) {
      if(response.result!='success')
      {
        alert(response.result);
        return false;
      }
      $('#UserTypeForm')[0].reset();
      dataTable.fnDraw();
    }, "json");
  });
</script>
<script type="text/javascript">
  $(document).on('click','.delete',function(){
    if(!confirm("Are you sure?")) { return false; }
    var table_id=$(this).attr('table_id');
    $.ajax({
      url: 'UserType/delete/'+table_id,
      type: 'get',
      data: {_token: "<?= csrf_token() ?>", id:table_id},
      dataType: 'JSON',
      success: function (response) {
        if(response.result!='success') { alert(response.result); return false; }
        dataTable.fnDraw();
      }
    });
  });
  $(document).on('click','.edit',function(){
    var table_id=$(this).attr('table_id');
    $('#table_edit_id').val(table_id);
    dataTable.fnDraw();
  });
  $(document).on('click','.ok_UserType',function(){
    var table_id=$(this).attr('table_id');
    $.ajax({
      url: 'UserType/Update/'+table_id,
      type: 'post',
      data: {
        _token: "<?= csrf_token() ?>",
        name:$('#edit_UserType_name').val(),
      },
      dataType: 'JSON',
      success: function (response) {
        if(response.result!='success') { alert(response.result); return false; }
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
