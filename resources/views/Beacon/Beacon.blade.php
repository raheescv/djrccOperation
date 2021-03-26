<?php use App\Models\Beacon; ?>
<?php use App\Models\Country; ?>
@extends('layouts.app')
@section('style')
<link href="{{url('public/css/jquery.steps.css')}}" rel="stylesheet">
<style media="screen">
.wizard > .content > .body{
  position: relative;
}
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-sm-4">
    <h2>Beacon</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>Form</a></li>
      <li class="active"><strong>Beacon</strong></li>
    </ol>
  </div>
  <div class="col-sm-8">
    <div class="title-action">
      <a href="{{url('Beacons')}}" class="btn btn-success" >Beacon List</a>
    </div>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>{{$TableName}}<small> form</small></h5>
        </div>
        @if(!$Self['id'])
        <div class="ibox-content">
          {!! Form::open(['id'=>$TableName.'Form','url'=>$TableName.'/Store']) !!}
          {{Form::hidden('status',$status)}}
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                {{Form::label('hex_no','Beacon hex ID *',['class'=>"text-capitalize"])}}
                {{Form::text('hex_no','',['class'=>'form-control','required'])}}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {{Form::label('beacon_type_id','beacon type *',['class'=>"text-capitalize"])}}
                {{Form::select('beacon_type_id',[''=>'Please Select']+Beacon::typeOptions(),'',['class'=>'form-control select2_classs','required'])}}
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group"><br>
                {{Form::button('save',['type'=>'submit','class'=>'btn btn-success btn-fw'])}}
              </div>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        @else
        <div class="ibox-content">
          <h2> Beacon ELT Registration </h2>
          <p class="text-right"> * indicates required field </p>
          {!! Form::open(['id'=>'form','url'=>$TableName.'/Update/'.$Self['id'],'class'=>"wizard-big"]) !!}
          <h1>Account Information</h1>
          <fieldset>
            <h2>Account Information</h2>
            <div class="row">
              <div class="col-lg-12">
                <div class="col-lg-6">
                  <div class="form-group">
                    {{Form::label('hex_no','Beacon hex ID *',['class'=>"text-capitalize"])}}
                    {{Form::text('hex_no',$Self['hex_no'],['class'=>'form-control','required'])}}
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Beacon Type *</label>
                    {{Form::text('beacon_type_id',$Self['beacon_type_id'],['class'=>'form-control','required','readonly'])}}
                  </div>
                </div>
              </div>
              @if("password"=="Need")
              <div class="col-lg-12">
                <div class="col-lg-6">
                  <div class="form-group">
                    {{Form::label('password','password *',['class'=>"text-capitalize"])}}
                    {{Form::password('password',['class'=>'form-control','required'])}}
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    {{Form::label('password','Confirm Password *',['class'=>"text-capitalize"])}}
                    {{Form::password('confirm',['class'=>'form-control','required'])}}
                  </div>
                </div>
              </div>
              @endif
              <div class="col-lg-12" hidden>
                <div class="col-lg-2">
                  <div class="form-group">
                    {{Form::label('special_status','Special Status',['class'=>"text-capitalize"])}}
                    {{Form::select('special_status',[''=>'Please Select']+Beacon::specialStatusOptions(),$Self['special_status'],['class'=>'form-control select2_classs'])}}
                  </div>
                </div>
                <div class="col-lg-5">
                  <div class="form-group">
                    {{Form::label('security_question','Security Question',['class'=>"text-capitalize"])}}
                    {{Form::select('security_question',[''=>'Please Select']+Beacon::securityQuestionOptions(),$Self['security_question'],['class'=>'form-control select2_classs'])}}
                  </div>
                </div>
                <div class="col-lg-5">
                  <div class="form-group">
                    {{Form::label('security_answer','Security Answer',['class'=>"text-capitalize"])}}
                    {{Form::text('security_answer',$Self['security_answer'],['class'=>'form-control'])}}
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="col-lg-12">
                  <div class="form-group">
                    {{Form::label('description','Reason or Comments',['class'=>"text-capitalize"])}}
                    {{Form::textarea('description',$Self['description'],['class'=>'form-control'])}}
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
          <h1>Owner/Operation Information</h1>
          <fieldset>
            <h2>Owner/Operation Information</h2>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('name','name *',['class'=>"text-capitalize"])}}
                  {{Form::text('name',$Self['name'],['class'=>'form-control','required'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('address','address *',['class'=>"text-capitalize"])}}
                  {{Form::text('address',$Self['address'],['class'=>'form-control','required'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('city','city *',['class'=>"text-capitalize"])}}
                  {{Form::text('city',$Self['city'],['class'=>'form-control','required'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('state','state',['class'=>"text-capitalize"])}}
                  {{Form::text('state',$Self['state'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('country_id','country',['class'=>"text-capitalize"])}}
                  {{Form::select('country_id',[''=>'Please Select']+Country::countryOptions(),$Self['country_id'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('postal_code','Postal Code',['class'=>"text-capitalize"])}}
                  {{Form::text('postal_code',$Self['postal_code'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  {{Form::label('email','email',['class'=>"text-capitalize"])}}
                  {{Form::text('email',$Self['email'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('telephone','telephone',['class'=>"text-capitalize"])}}
                  {{Form::text('telephone',$Self['telephone'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('mobile','mobile',['class'=>"text-capitalize"])}}
                  {{Form::text('mobile',$Self['mobile'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
          </fieldset>
          @switch($Self['beacon_type_id'])
          @case("ELT")
          <h1>AirCraft Information</h1>
          <fieldset>
            <h2>AirCraft Information</h2>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('vehicle_type_id','vehicle type *',['class'=>"text-capitalize"])}}
                  {{Form::select('vehicle_type_id',[''=>'Please Select']+Beacon::vehicleTypeOptions(),$Self['vehicle_type_id'],['class'=>'form-control','required'])}}
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('air_craft_manufacturer','air craft anufacturer',['class'=>"text-capitalize"])}}
                  {{Form::text('air_craft_manufacturer',$Self['air_craft_manufacturer'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('color','color',['class'=>"text-capitalize"])}}
                  {{Form::text('color',$Self['color'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('air_craft_operation_agency','air craft operation agency',['class'=>"text-capitalize"])}}
                  {{Form::text('air_craft_operation_agency',$Self['air_craft_operation_agency'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('radio_equipment','radio equipment',['class'=>"text-capitalize"])}}
                  {{Form::select('radio_equipment',[''=>'Please Select']+Beacon::radioEquipmentOptions(),$Self['radio_equipment'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
          </fieldset>
          @break
          @case("EPIRB")
          <h1>Vehicle Information</h1>
          <fieldset>
            <h2>Vehicle Information</h2>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('vehicle_type_id','vehicle type *',['class'=>"text-capitalize"])}}
                  {{Form::select('vehicle_type_id',[''=>'Please Select']+Beacon::vehicleTypeOptions(),$Self['vehicle_type_id'],['class'=>'form-control','required'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('specific_usage','specific usage',['class'=>"text-capitalize"])}}
                  {{Form::text('specific_usage',$Self['specific_usage'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  {{Form::label('additional_usage','additional usage',['class'=>"text-capitalize"])}}
                  {{Form::textarea('additional_usage',$Self['additional_usage'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
          </fieldset>
          @break
          @case("PLB")
          <h1>Vessel Information</h1>
          <fieldset>
            <h2>Vessel Information</h2>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('vehicle_type_id','vehicle type *',['class'=>"text-capitalize"])}}
                  {{Form::select('vehicle_type_id',[''=>'Please Select']+Beacon::vehicleTypeOptions(),$Self['vehicle_type_id'],['class'=>'form-control','required'])}}
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('vessel_name','vessel name',['class'=>"text-capitalize"])}}
                  {{Form::text('vessel_name',$Self['vessel_name'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('color','vessel color',['class'=>"text-capitalize"])}}
                  {{Form::text('color',$Self['color'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3">
                <div class="form-group">
                  {{Form::label('no_of_life_boats','no of life boats',['class'=>"text-capitalize"])}}
                  {{Form::text('no_of_life_boats',$Self['no_of_life_boats'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  {{Form::label('no_of_life_rafts','no of life rafts',['class'=>"text-capitalize"])}}
                  {{Form::text('no_of_life_rafts',$Self['no_of_life_rafts'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  {{Form::label('inmarsat','inmarsat',['class'=>"text-uppercase"])}}
                  {{Form::text('inmarsat',$Self['inmarsat'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  {{Form::label('vessel_cellular','vessel cellular',['class'=>"text-capitalize"])}}
                  {{Form::text('vessel_cellular',$Self['vessel_cellular'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('radio_call_sign','radio call sign',['class'=>"text-capitalize"])}}
                  {{Form::text('radio_call_sign',$Self['radio_call_sign'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('radio_call_sign_decode','radio call sign decode',['class'=>"text-capitalize"])}}
                  {{Form::text('radio_call_sign_decode',$Self['radio_call_sign_decode'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('radio_equipment','radio equipment',['class'=>"text-capitalize"])}}
                  {{Form::select('radio_equipment',[''=>'Please Select']+Beacon::radioEquipmentOptions(),$Self['radio_equipment'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
          </fieldset>
          @break
          @endswitch
          <h1>{{$Self['beacon_type_id']}} Information</h1>
          <fieldset>
            <h2>{{$Self['beacon_type_id']}} Information</h2>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('manufacturer','manufacturer *',['class'=>"text-capitalize"])}}
                  {{Form::select('manufacturer',[''=>'Please select']+Beacon::manufacturerOptions(),$Self['manufacturer'],['class'=>'form-control','required'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('model_no','model no *',['class'=>"text-capitalize"])}}
                  {{Form::text('model_no',$Self['model_no'],['class'=>'form-control','required'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('c_s_type_approval_no','c s type approval no',['class'=>"text-capitalize"])}}
                  {{Form::text('c_s_type_approval_no',$Self['c_s_type_approval_no'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('activation_method','activation method',['class'=>"text-capitalize"])}}
                  {{Form::select('activation_method',[''=>'Please select']+Beacon::activationMethodOptions(),$Self['activation_method'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  {{Form::label('beacon_home_device','Becon Homing Devices',['class'=>"text-capitalize"])}}
                  {{Form::select('beacon_home_device',[''=>'Please select']+Beacon::beaconHomeDeviceOptions(),$Self['beacon_home_device'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  {{Form::label('additional_information','additional information',['class'=>"text-capitalize"])}}
                  {{Form::text('additional_information',$Self['additional_information'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
          </fieldset>
          <h1>24 Hour Emergency Contact Information</h1>
          <fieldset>
            <h2>24 Hour Emergency Contact Information</h2>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  {{Form::label('primary_name','Name of the Primary 24-Hour Emergency Contact  *',['class'=>"text-capitalize"])}}
                  {{Form::text('primary_name',$Self['primary_name'],['class'=>'form-control','required'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('primary_address_line_1','Primary Contact address Line 1',['class'=>"text-capitalize"])}}
                  {{Form::text('primary_address_line_1',$Self['primary_address_line_1'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('primary_address_line_2','Primary Contact address Line 2',['class'=>"text-capitalize"])}}
                  {{Form::text('primary_address_line_2',$Self['primary_address_line_2'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <h3 align="center">Telephone</h3>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('primary_phone_number_1','Primary Phone Number 1',['class'=>"text-capitalize"])}}
                  {{Form::text('primary_phone_number_1',$Self['primary_phone_number_1'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('primary_phone_number_2','Primary Phone Number 2',['class'=>"text-capitalize"])}}
                  {{Form::text('primary_phone_number_2',$Self['primary_phone_number_2'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('primary_phone_number_3','Primary Phone Number 3',['class'=>"text-capitalize"])}}
                  {{Form::text('primary_phone_number_3',$Self['primary_phone_number_3'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('primary_phone_number_4','Primary Phone Number 4',['class'=>"text-capitalize"])}}
                  {{Form::text('primary_phone_number_4',$Self['primary_phone_number_4'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row" hidden>
              <div class="col-lg-12">
                <div class="form-group">
                  {{Form::label('alternative_name','Name of the Alternative 24-Hour Emergency Contact *',['class'=>"text-capitalize"])}}
                  {{Form::text('alternative_name',$Self['alternative_name'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('alternative_address_line_1','Alternative Contact address Line 1',['class'=>"text-capitalize"])}}
                  {{Form::text('alternative_address_line_1',$Self['alternative_address_line_1'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('alternative_address_line_2','Alternative Contact address Line 2',['class'=>"text-capitalize"])}}
                  {{Form::text('alternative_address_line_2',$Self['alternative_address_line_2'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row" hidden>
              <h3 align="center">Telephone</h3>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('alternative_phone_number_1','Alternative Phone Number 1',['class'=>"text-capitalize"])}}
                  {{Form::text('alternative_phone_number_1',$Self['alternative_phone_number_1'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('alternative_phone_number_2','Alternative Phone Number 2',['class'=>"text-capitalize"])}}
                  {{Form::text('alternative_phone_number_2',$Self['alternative_phone_number_2'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
            <div class="row" hidden>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('alternative_phone_number_3','Alternative Phone Number 3',['class'=>"text-capitalize"])}}
                  {{Form::text('alternative_phone_number_3',$Self['alternative_phone_number_3'],['class'=>'form-control'])}}
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  {{Form::label('alternative_phone_number_4','Alternative Phone Number 4',['class'=>"text-capitalize"])}}
                  {{Form::text('alternative_phone_number_4',$Self['alternative_phone_number_4'],['class'=>'form-control'])}}
                </div>
              </div>
            </div>
          </fieldset>
          {!! Form::close() !!}
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{url('public/js/jquery.steps.min.js')}}"></script>
<script src="{{url('public/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#wizard").steps();
  $("#form").steps({
    bodyTag: "fieldset",
    onStepChanging: function (event, currentIndex, newIndex) {
      // Always allow going backward even if the current step contains invalid fields!
      if (currentIndex > newIndex) {
        return true;
      }
      // Forbid suppressing "Warning" step if the user is to young
      if (newIndex === 3 && Number($("#age").val()) < 18) {
        return false;
      }
      var form = $(this);
      // Clean up if user went backward before
      if (currentIndex < newIndex) {
        // To remove error styles
        $(".body:eq(" + newIndex + ") label.error", form).remove();
        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
      }
      // Disable validation on fields that are disabled or hidden.
      form.validate().settings.ignore = ":disabled,:hidden";
      // Start validation; Prevent going forward if false
      return form.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex) {
      // Suppress (skip) "Warning" step if the user is old enough.
      if (currentIndex === 2 && Number($("#age").val()) >= 18) {
        $(this).steps("next");
      }
      // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
      if (currentIndex === 2 && priorIndex === 3) {
        $(this).steps("previous");
      }
    },
    onFinishing: function (event, currentIndex) {
      var form = $(this);
      form.validate().settings.ignore = ":disabled";
      return form.valid();
    },
    onFinished: function (event, currentIndex) {
      var form = $(this);
      form.submit();
    }
  }).validate({
    errorPlacement: function (error, element) {
      element.before(error);
    },
    rules: {
      // confirm: { equalTo: "#password" }
    }
  });
});
</script>
<script type="text/javascript">
@if($Self['id'])
@if($Self['status']==Beacon::TESTBEACON)
$('input,textarea,select').filter('[required]:visible').attr('required',false);
@endif
@endif
</script>
@endsection
