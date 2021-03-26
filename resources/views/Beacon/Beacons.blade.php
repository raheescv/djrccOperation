<?php use App\Models\Beacon; ?>
<?php use App\Models\Country; ?>
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
    <h2>
      @if($status==Beacon::TESTBEACON) Test @endif {{$TableName}}
    </h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>Master</a></li>
      <li class="active"><strong>{{$TableName}}s</strong></li>
    </ol>
  </div>
  <div class="col-sm-2">
    <div class="title-action">
      @if($status==Beacon::TESTBEACON)
      <a href="{{url('TestBeacon')}}" class="btn btn-success">New Test{{$TableName}}</a>
      @else
      <a href="{{url('Beacon')}}" class="btn btn-success">New {{$TableName}}</a>
      @endif
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
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('beacon_type_id','beacon type',['class'=>"text-capitalize"])}}
                {{Form::select('beacon_type_id',[''=>'Please Select']+Beacon::typeOptions(),'',['class'=>'form-control select2_class table_change'])}}
              </div>
            </div>
            <div class="col-md-3" hidden>
              <div class="form-group">
                {{Form::label('special_status','Special Status',['class'=>"text-capitalize"])}}
                {{Form::select('special_status',[''=>'Please Select']+Beacon::specialStatusOptions(),'',['class'=>'form-control select2_class table_change'])}}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('country_id','country',['class'=>"text-capitalize"])}}
                {{Form::select('country_id',[''=>'Please Select']+Country::countryOptions(),'',['class'=>'form-control select2_class table_change'])}}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('vehicle_type_id','vehicle type',['class'=>"text-capitalize"])}}
                {{Form::select('vehicle_type_id',[''=>'Please Select']+Beacon::vehicleTypeOptions(),'',['class'=>'form-control select2_class table_change'])}}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('manufacturer','manufacturer',['class'=>"text-capitalize"])}}
                {{Form::select('manufacturer',[''=>'Please select']+Beacon::manufacturerOptions(),'',['class'=>'form-control select2_class table_change'])}}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('activation_method','activation method',['class'=>"text-capitalize"])}}
                {{Form::select('activation_method',[''=>'Please select']+Beacon::activationMethodOptions(),'',['class'=>'form-control select2_class table_change'])}}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('beacon_home_device','beacon home device',['class'=>"text-capitalize"])}}
                {{Form::select('beacon_home_device',[''=>'Please select']+Beacon::beaconHomeDeviceOptions(),'',['class'=>'form-control select2_class table_change'])}}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('from_date','From Date',['class'=>"text-capitalize"])}}
                {{Form::date('from_date',date('Y-m-01'),['id'=>'from_date','class'=>'form-control table_change'])}}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('to_date','To Date',['class'=>"text-capitalize"])}}
                {{Form::date('to_date',date('Y-m-d'),['id'=>'to_date','class'=>'form-control table_change'])}}
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
                  <th>hex no</th>
                  <th>beacon type</th>
                  <th>country</th>
                  <!-- <th>security question</th> -->
                  <!-- <th>security answer</th> -->
                  <!-- <th>special status</th> -->
                  <th>description</th>
                  <th>name</th>
                  <th>address</th>
                  <th>city</th>
                  <th>state</th>
                  <th>postal code</th>
                  <th>email</th>
                  <th>telephone</th>
                  <th>mobile</th>
                  <th>vehicle type</th>
                  <th>manufacturer</th>
                  <th>model no</th>
                  <th>c s type approval no</th>
                  <th>activation method</th>
                  <th>beacon home device</th>
                  <th>additional information</th>
                  <th>primary name</th>
                  <th>primary address line 1</th>
                  <th>primary address line 2</th>
                  <th>primary phone number 1</th>
                  <th>primary phone number 2</th>
                  <th>primary phone number 3</th>
                  <th>primary phone number 4</th>
                  <th>alternative name</th>
                  <th>alternative address line 1</th>
                  <th>alternative address line 2</th>
                  <th>alternative phone number 1</th>
                  <th>alternative phone number 2</th>
                  <th>alternative phone number 3</th>
                  <th>alternative phone number 4</th>
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
<script src="{{ url('public/js/vfs_fonts.js')}}"></script>
<script src="{{ url('public/js/dataTables.fixedColumns.min.js')}}"></script>
<script src="{{ url('public/js/buttons.colVis.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.responsive.js')}}"></script>
<script src="{{ url('public/js/dataTables.tableTools.min.js')}}"></script>
<script type="text/javascript">
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
      d._token            = "<?= csrf_token() ?>";
      d.status            ='{{$status}}',
      d.from_date         =$("#from_date").val();
      d.to_date           =$("#to_date").val();
      d.beacon_type_id    =$("#beacon_type_id").val();
      d.special_status    =$("#special_status").val();
      d.country_id        =$("#country_id").val();
      d.vehicle_type_id   =$("#vehicle_type_id").val();
      d.manufacturer      =$("#manufacturer").val();
      d.activation_method =$("#activation_method").val();
      d.beacon_home_device=$("#beacon_home_device").val();
    },
  },
  dom: 'Bfrtip',
  buttons: [
    'colvis',
    'pageLength',
  ],
  "columns": [
    { "data": "id", 'visible': false },
    { "data": "hex_no","visible":true},
    { "data": "beacon_type_id","visible":true},
    { "data": "country_id","visible":false},
    // { "data": "security_question","visible":false},
    // { "data": "security_answer","visible":false},
    // { "data": "special_status","visible":true},
    { "data": "description","visible":false},
    { "data": "name","visible":true},
    { "data": "address","visible":false},
    { "data": "city","visible":false},
    { "data": "state","visible":false},
    { "data": "postal_code","visible":false},
    { "data": "email","visible":false},
    { "data": "telephone","visible":false},
    { "data": "mobile","visible":false},
    { "data": "vehicle_type_id","visible":true},
    { "data": "manufacturer","visible":true},
    { "data": "model_no","visible":false},
    { "data": "c_s_type_approval_no","visible":false},
    { "data": "activation_method","visible":true},
    { "data": "beacon_home_device","visible":true},
    { "data": "additional_information","visible":false},
    { "data": "primary_name","visible":false},
    { "data": "primary_address_line_1","visible":false},
    { "data": "primary_address_line_2","visible":false},
    { "data": "primary_phone_number_1","visible":false},
    { "data": "primary_phone_number_2","visible":false},
    { "data": "primary_phone_number_3","visible":false},
    { "data": "primary_phone_number_4","visible":false},
    { "data": "alternative_name","visible":false},
    { "data": "alternative_address_line_1","visible":false},
    { "data": "alternative_address_line_2","visible":false},
    { "data": "alternative_phone_number_1","visible":false},
    { "data": "alternative_phone_number_2","visible":false},
    { "data": "alternative_phone_number_3","visible":false},
    { "data": "alternative_phone_number_4","visible":false},
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
$('body').removeClass('');
$('body').addClass('pace-done mini-navbar');
</script>
@endsection
