<?php use App\Models\Beacon; ?>
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
      <li><a href="{{ url('Beacons') }}">Beacons</a></li>
      <li class="active"><strong>{{$Self['beacon_type_id']}}</strong></li>
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
          <h5>{{$TableName}}<small> {{$Self['beacon_type_id']}} Information</small></h5>
          <div class="ibox-tools">
            <a href="{{url('Beacon/'.$Self['id'])}}"><i class="fa fa-edit"></i>Edit</a>
          </div>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-bordered table-hover table-striped" width="100%">
                <thead>
                  <th class="text-center" colspan="2"><h2><b>Account Information</b></h2></th>
                </thead>
                <tbody>
                  <tr>
                    <th class="text-capitalize">hex no</th>
                    <td>{{$Self['hex_no']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">Beacon Type</th>
                    <td>{{$Self['beacon_type_id']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">country code</th>
                    <td>{{$Self->Country?$Self->Country->code:''}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">special status</th>
                    <td>{{$Self['special_status']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">security question</th>
                    <td>{{$Self['security_question']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">security answer</th>
                    <td>{{$Self['security_answer']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">Reason or Comments</th>
                    <td>{{$Self['description']}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-bordered table-hover table-striped" width="100%">
                <thead>
                  <th class="text-center" colspan="2"><h2><b>Owner/Operation Information</b></h2></th>
                </thead>
                <tbody>
                  <tr>
                    <th class="text-capitalize">name</th>
                    <td>{{$Self['name']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">address</th>
                    <td>{{$Self['address']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">city</th>
                    <td>{{$Self['city']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">country</th>
                    <td>{{$Self->Country?$Self->Country->name:''}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">state</th>
                    <td>{{$Self['state']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">postal code</th>
                    <td>{{$Self['postal_code']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">email</th>
                    <td>{{$Self['email']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">telephone</th>
                    <td>{{$Self['telephone']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">mobile</th>
                    <td>{{$Self['mobile']}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <table class="table table-bordered table-hover table-striped" width="100%">
                <thead>
                  <th class="text-center" colspan="2"><h2><b>{{$Self['beacon_type_id']}} Information</b></h2></th>
                </thead>
                <tbody>
                  <tr>
                    <th class="text-capitalize">manufacturer</th>
                    <td>{{ $Self['manufacturer'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">model no</th>
                    <td>{{ $Self['model_no'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">c s type approval no</th>
                    <td>{{ $Self['c_s_type_approval_no'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">activation method</th>
                    <td>{{ $Self['activation_method'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">beacon home device</th>
                    <td>{{ $Self['beacon_home_device'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">additional information</th>
                    <td>{{ $Self['additional_information'] }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-bordered table-hover table-striped" width="100%">
                @switch($Self['beacon_type_id'])
                @case("ELT")
                <thead>
                  <th class="text-center" colspan="2"><h2><b>AirCraft Information</b></h2></th>
                </thead>
                <tbody>
                  <tr>
                    <th class="text-capitalize">manufacturer</th>
                    <td>{{ $Self['manufacturer'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">vehicle type</th>
                    <td>{{$Self['vehicle_type_id']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">radio equipment</th>
                    <td>{{$Self['radio_equipment']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">color</th>
                    <td>{{$Self['color']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">air craft manufacturer</th>
                    <td>{{$Self['air_craft_manufacturer']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">air craft operation agency</th>
                    <td>{{$Self['air_craft_operation_agency']}}</td>
                  </tr>
                </tbody>
                @break
                @case("EPIRB")
                <thead>
                  <th class="text-center" colspan="2"><h2><b>Vehicle Information</b></h2></th>
                </thead>
                <tbody>
                  <tr>
                    <th class="text-capitalize">vehicle type</th>
                    <td>{{$Self['vehicle_type_id']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">specific usage</th>
                    <td>{{$Self['specific_usage']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">additional usage</th>
                    <td>{{$Self['additional_usage']}}</td>
                  </tr>
                </tbody>
                @break
                @case("PLB")
                <thead>
                  <th class="text-center" colspan="2"><h2><b>Vessel Information</b></h2></th>
                </thead>
                <tbody>
                  <tr>
                    <th class="text-capitalize">vehicle type</th>
                    <td>{{$Self['vehicle_type_id']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">radio equipment</th>
                    <td>{{$Self['radio_equipment']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">vessel name</th>
                    <td>{{ $Self['vessel_name'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">vessel Color</th>
                    <td>{{ $Self['color'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">no of life boats</th>
                    <td>{{ $Self['no_of_life_boats'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">no of life rafts</th>
                    <td>{{ $Self['no_of_life_rafts'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">radio call sign</th>
                    <td>{{ $Self['radio_call_sign'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">radio call sign decode</th>
                    <td>{{ $Self['radio_call_sign_decode'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">inmarsat</th>
                    <td>{{ $Self['inmarsat'] }}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">vessel cellular</th>
                    <td>{{ $Self['vessel_cellular'] }}</td>
                  </tr>
                </tbody>
                @break
                @endswitch
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered table-hover table-striped" width="100%">
                <thead>
                  <th class="text-center" colspan="2"><h2><b>24 Hour Emergency Contact Information</b></h2></th>
                </thead>
                <tbody>
                  <tr>
                    <th class="text-capitalize">primary name</th>
                    <td>{{$Self['primary_name']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">primary address line 1</th>
                    <td>{{$Self['primary_address_line_1']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">primary address line 2</th>
                    <td>{{$Self['primary_address_line_2']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">primary phone number 1</th>
                    <td>{{$Self['primary_phone_number_1']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">primary phone number 2</th>
                    <td>{{$Self['primary_phone_number_2']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">primary phone number 3</th>
                    <td>{{$Self['primary_phone_number_3']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">primary phone number 4</th>
                    <td>{{$Self['primary_phone_number_4']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">alternative name</th>
                    <td>{{$Self['alternative_name']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">alternative address line 1</th>
                    <td>{{$Self['alternative_address_line_1']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">alternative address line 2</th>
                    <td>{{$Self['alternative_address_line_2']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">alternative phone number 1</th>
                    <td>{{$Self['alternative_phone_number_1']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">alternative phone number 2</th>
                    <td>{{$Self['alternative_phone_number_2']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">alternative phone number 3</th>
                    <td>{{$Self['alternative_phone_number_3']}}</td>
                  </tr>
                  <tr>
                    <th class="text-capitalize">alternative phone number 4</th>
                    <td>{{$Self['alternative_phone_number_4']}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
@section('script')
@endsection
