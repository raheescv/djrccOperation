<?php use App\Models\Beacon; ?>
<?php use App\Models\Situation; ?>
<?php use App\Models\Country; ?>
@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ url('public/css/dataTables.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/buttons.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/dataTables.responsive.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/dataTables.tableTools.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/fixedHeader.dataTables.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/bootstrap-clockpicker.min.css') }}" />
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-sm-4">
    <h2>{{$TableName}}</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a href="{{url('Situations')}}">{{$TableName}}s</a></li>
      <li class="active"><strong>{{$TableName}}</strong></li>
    </ol>
  </div>
  <div class="col-sm-8">
    <div class="title-action">
      <a href="{{url('Situations')}}" class="btn btn-success" >{{$TableName}} List</a>
    </div>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-content">
          {!! Form::open(['id'=>$TableName.'Form','url'=>$TableName.'/Store/'.$Self['id']]) !!}
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('beacon_type_id','Beacon Type',['class'=>"text-capitalize"])}}
                {{Form::select('beacon_type_id',[''=>'Please Select']+Beacon::typeOptions(),$Self['beacon_type_id'],['class'=>'form-control select2_class'])}}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('beacon_id','Beacon ID *',['class'=>"text-capitalize"])}}
                {{Form::select('beacon_id',$Beacon,$Self['beacon_id'],['class'=>'form-control','required'])}}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('country_id','country *',['class'=>"text-capitalize"])}}
                {{Form::select('country_id',[''=>'Please Select']+Country::countryOptions(),$Self['country_id'],['class'=>'form-control select2_class','required'])}}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('registered','registered *',['class'=>"text-capitalize"])}}
                {{Form::select('registered',[''=>'Please Select']+Situation::registeredOptions(),$Self['registered'],['class'=>'form-control select2_class','required'])}}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10">
              <div class="col-md-6">
                <div class="form-group">
                  {{Form::label('opened_by','opened by *',['class'=>"text-capitalize"])}}
                  {{Form::select('opened_by',[''=>'Please Select']+$OpenedBy,$Self['opened_by'],['class'=>'form-control','required'])}}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{Form::label('closed_by','closed by *',['class'=>"text-capitalize"])}}
                  {{Form::select('closed_by',[''=>'Please Select']+$ClosedBy,$Self['closed_by'],['class'=>'form-control','required'])}}
                </div>
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group"><br>
                {{Form::button('save',['type'=>'submit','class'=>'btn btn-success btn-fw'])}}
              </div>
            </div>
            @if($Self['id'])
            <div class="col-md-1">
              <div class="form-group"><br>
                <a href="{{url('Situation/Print/'.$Self->id)}}"><i class="fa fa-2x fa-print"></i></a>
              </div>
            </div>
            @endif
          </div>
          @if($Self['id'])
          <div class="row">
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped text-capitalize" id='dataTable' width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>date</th>
                        <th>time</th>
                        <th width="40%">details</th>
                        <th>initial</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <td>0</td>
                        <td>{{Form::date('date',date('Y-m-d'),['id'=>'date','class'=>'form-control'])}}</td>
                        <td>
                          <input type="time" name='time' id="time" style="width:100%" class="form-control" value="<?= date('H:i') ?>">
                        </td>
                        <td>{{Form::text('details','',['id'=>'details','class'=>'form-control cart_item','style'=>"width:100%"])}}</td>
                        <td>{{Form::text('initial','',['id'=>'initial','class'=>'form-control cart_item','style'=>"width:100%"])}}</td>
                        <td><button type="button" tabindex="-1" class="btn btn-primary btn-sm" id="add_item"><i class="fa fa-plus"></i></button></td>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          @endif
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>
@component('component.'.'Beacon'.'Model',['TableName'=>'Beacon']) @endcomponent
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
$('.cart_item').keypress(function(event) {
  var keycode = (event.keyCode ? event.keyCode : event.which);
  if (keycode == '13') {$('#add_item').click(); return false; }
});
$(document).on('click', '#add_item', function() {
  var date       =$('#date').val();
  var time       =$('#time').val();
  var details    =$('#details').val();
  var initial    =$('#initial').val();
  var data={
    _token        :"<?= csrf_token() ?>",
    situation_id  :"{{$Self['id']}}",
    date          :date,
    time          :time,
    details       :details,
    initial       :initial,
  };
  add_to_cart(data);
});
function add_to_cart(data) {
  var url_address = "{{url('SituationDetail/Store')}}";
  $.post(url_address, data, function(response) {
    if (response.result != 'success') { Swal.fire( 'Error!', response.result, 'error' ); return false; }
    $('#details').val('');
    $('#initial').val('');
    dataTable.fnDraw();
    $('#details').select();
  }, "json");
}
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
      var url_address = '{{url("SituationDetail/Delete")}}/' + table_id;
      $.get(url_address, function(response) {
        if (response.result != 'success') { Swal.fire( 'Error!', response.result, 'error' ); return false; }
        dataTable.fnDraw();
      }, "json");
    }
  });
});
</script>
<script type="text/javascript">
var dataTable = $('#dataTable').dataTable({
  "processing": true,
  "serverSide": true,
  "fixedHeader": true,
  "bInfo": false,
  "paging": false,
  "ordering": false,
  "ajax": {
    "url": "<?= route('SituationDetailTable') ?>",
    "dataType": "json",
    "type": "POST",
    data: function(d) {
      d._token       =  "<?= csrf_token() ?>";
      d.situation_id = "{{$Self['id']}}";
    },
  },
  "columns": [
    { "data": "key", 'visible': true },
    { "data": "date"},
    { "data": "time"},
    { "data": "details"},
    { "data": "initial"},
    { "data": "action", 'visible': true },
  ],
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
        _token    : "<?= csrf_token() ?>",
        search_tag: data.term,
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
$('#beacon_type_id').on("select2:select", function(e) {
  $('#beacon_id').select2('open');
});
$('#beacon_id').on("select2:select", function(e) {
  if($(this).val()=='Add') { $('#employee_id').val('').change(); $('#BeaconModal').modal('toggle'); return false; }
  $('#country_id').select2('open');
});
$('#country_id').on("select2:select", function(e) {
  $('#registered').select2('open');
});
$('#registered').on("select2:select", function(e) {
  $('#opened_by').select2('open');
});
$('#opened_by').on("select2:select", function(e) {
  $('#closed_by').select2('open');
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
