@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('public/css/dataTables.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/buttons.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.responsive.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.tableTools.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/fixedHeader.dataTables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/switchery.css') }}" />
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Users</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>Forms</a></li>
      <li class="active"><strong>Users</strong></li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>User<small> Table</small></h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                {{Form::label('user_type_id','User Type')}}
                {{Form::select('user_type_id',$UserTypes,'',['id'=>'user_type_id','class'=>'form-control select2_class','style'=>'width:100%'])}}
              </div>
            </div>
          </div>
        </div>
        <div class="ibox-content">
          <table class="table table-bordered table-hover table-striped table-condensed" width="100%" id='dataTable'>
            <thead>
              <tr>
                <th>#</th>
                <th>Module</th>
                <th>Sub Moduel</th>
                <th>Status</th>
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
@endsection
@section('script')
<script src="{{ asset('public/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.jqueryui.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.fixedColumns.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('public/js/dataTables.responsive.js')}}"></script>
<script src="{{ asset('public/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{ asset('public/js/switchery.js')}}"></script>
<script type="text/javascript">
  var dataTable=$('#dataTable').dataTable( {
    "processing": true,
    "serverSide": true,
    "paging": false,
    "ajax": {
      "url":"<?= route('UserTypePrivilegesTable') ?>",
      "dataType":"json",
      "type":"POST",
      data:function(d){
        d._token= "<?= csrf_token() ?>";
        d.user_type_id=$('#user_type_id').val();
      },
    },
    "columns":[
    {"data":"id"},
    {"data":"module"},
    {"data":"sub_module"},
    {"data":"status"},
    {"data":"action"},
    ],
    "columnDefs":[
    {"targets": [3],'visible':false},
    ],
    "fnDrawCallback": function(settings, json) {
      var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
      elems.forEach(function(html) {
        var switchery = new Switchery(html);
      });
    },
  } );
</script>
<script type="text/javascript">
  $(document).on('change','.user_type_privilage_change',function(){
    var user_type_id=$(this).attr('user_type_id');
    var project_module_id=$(this).attr('project_module_id');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url: 'Privilages_change_ajax',
      type: 'post',
      data: {
        _token: "<?= csrf_token() ?>",
        user_type_id:user_type_id,
        project_module_id:project_module_id
      },
      dataType: 'JSON',
      success: function (data) { 
        if(data.result!='success') { alert(data.result); }
        dataTable.fnDraw();
      }
    }); 
  });
  $('#user_type_id').change(function(){
    dataTable.fnDraw();
  });
</script>
@endsection
