@extends('layouts.app')
@section('style')
<style media="screen">
.no-border {
  border: 0;
  box-shadow: none; /* You may want to include this as bootstrap applies these styles too */
}
.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  outline: none;
  background: white;
  cursor: inherit;
  display: block;
}
#img-upload {
  width: 100%;
}
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-sm-6">
    <h2>Profile</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>User</a></li>
      <li class="active"><strong>Profile</strong></li>
    </ol>
  </div>
  <div class="col-sm-2">
    <div class="title-action">
      <button class="btn btn-warning" data-toggle="modal" data-target="#UserPasswordModal">Change Password</button>
    </div>
  </div>
  @if($LoggedUser->user_type_id==1)
  <div class="col-md-2">
    <div class="input-group-btn title-action">
      <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">{{ $User->name }} <span class="caret"></span></button>
      <ul class="dropdown-menu">
        @foreach($Users as $single)
        <li><a href="{{ url('/User').'/'.$single->id }}">{{$single->name}}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="title-action">
      <button class="btn btn-success" data-toggle="modal" id='table_add_button' data-target="#User_Modal">Add User</button>
    </div>
  </div>
  @endif
</div>
<div class="wrapper wrapper-content">
  <div class="row animated fadeInRight">
    <div class="col-md-4">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>User Detail</h5>
        </div>
        {!! Form::open(array('url' => '/UpdateUser/'.$id,'files'=>'true','id'=>'UserForm','class'=>'form-sample','method'=>'post','enctype'=>'multipart/form-data')); !!}
        {{ csrf_field() }}
        <div>
          <div class="ibox-content no-padding border-left-right">
            @if($User->image)
            <img alt="image" class="img-responsive avatar-view" id='img-upload' src="{{ url('public/profile').'/'.$User->image }} ">
            @else
            <img alt="image" class="img-responsive avatar-view" id='img-upload' src="{{ url('public/image').'/profile_big.jpg' }} ">
            @endif
            <div class="input-group">
              <span class="input-group-btn">
                <span class="btn btn-default btn-file">
                  Browse… {{Form::file('image_upload',['id'=>'imgInp'])}}
                </span>
              </span>
              {{Form::text('image',$User->image,['class'=>'form-control','readonly'])}}
            </div>
          </div>
          <div class="ibox-content profile-content">
            <table class="table table-hover" width="100%">
              <tbody>
                <tr>
                  <td class="text-right"><strong>{{Form::label('name','Name')}}</strong></td>
                  <td>{{Form::text('name',$User->name,['class'=>'form-control no-border','placeholder'=>'Enter UserName','autofocus','required'])}}</td>
                </tr>
                <tr>
                  <td class="text-right"><strong>{{Form::label('user_type_id','UserType')}}</strong></td>
                  <td>{{Form::select('user_type_id',$UserTypes,$User->user_type_id,['class'=>'select2_class','style'=>'border-radius: 0px;','required'])}}</td>
                </tr>
                <tr>
                  <td class="text-right"><strong>{{Form::label('first_name','First Name')}}</strong></td>
                  <td>{{Form::text('first_name',$User->first_name,['class'=>'form-control no-border','placeholder'=>'Enter FirstName'])}}</td>
                </tr>
                <tr>
                  <td class="text-right"><strong>{{Form::label('last_name','Last Name')}}</strong></td>
                  <td>{{Form::text('last_name',$User->last_name,['class'=>'form-control no-border','placeholder'=>'Enter LastName'])}}</td>
                </tr>
                <tr>
                  <td class="text-right"><strong>{{Form::label('country_code','Country Code')}}</strong></td>
                  <td>{{Form::text('country_code',$User->country_code,['class'=>'form-control no-border','placeholder'=>'Enter Country Code'])}}</td>
                </tr>
                <tr>
                  <td class="text-right"><strong>{{Form::label('mobile','Mobile')}}</strong></td>
                  <td>{{Form::text('mobile',$User->mobile,['class'=>'form-control no-border','placeholder'=>'Enter Mobile'])}}</td>
                </tr>
                <tr>
                  <td class="text-right"><strong><a href="{{ $User->web_site }}" target="_blank">WebSite</a></strong></td>
                  <td>{{Form::text('web_site',$User->web_site,['class'=>'form-control no-border','placeholder'=>'Enter WebSite Address'])}}</td>
                </tr>
                <tr>
                  <td class="text-right"><strong>{{Form::label('email','Email')}}</strong></td>
                  <td>{{Form::text('email',$User->email,['class'=>'form-control no-border','placeholder'=>'Enter Email'])}}</td>
                </tr>
              </tbody>
            </table>
            <div class="user-button">
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-pencil"></i>Edit User</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
    <div class="col-md-8">
      <div class="ibox float-e-margins">
        <div class="panel blank-panel">
          <div class="panel-heading">
            <div class="panel-options">
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-2">Activites</a></li>
                <li><a data-toggle="tab" href="#tab-1">Email</a></li>
              </ul>
            </div>
          </div>
          <div class="panel-body">
            <div class="tab-content">
              <div id="tab-1" class="tab-pane">
                <div class="mail-box">
                  {!! Form::open(array('url' =>'SendMail','class'=>'form','method'=>'post')); !!}
                  <div class="mail-body">
                    <div class="form-group"><label class="col-sm-2 control-label">From:</label>
                      <div class="col-sm-10">
                        {{Form::text('from',$User->email,['class'=>'form-control','placeholder'=>'Enter From Address','required','readonly'])}}
                        <br>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Name:</label>
                      <div class="col-sm-10">
                        {{Form::text('name',$User->name,['class'=>'form-control','placeholder'=>'Enter Name','required','readonly'])}}
                        <br>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">To:</label>
                      <div class="col-sm-10">
                        {{Form::text('to','',['class'=>'form-control','placeholder'=>'Enter To Address','required'])}}
                        <br>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Subject:</label>
                      <div class="col-sm-10">
                        {{Form::text('subject','',['class'=>'form-control','placeholder'=>'Enter Subject','required'])}}
                        <br>
                      </div>
                    </div>
                  </div>
                  <div class="mail-text h-200">
                    {{Form::textarea('message','',['class'=>'form-control','rows'=>9,'cols'=>9,'placeholder'=>'Enter Message To Send','required'])}}
                    <div class="clearfix"></div>
                  </div>
                  <div class="mail-body text-right tooltip-demo">
                    <button type="submit" class="btn btn-sm btn-primary" name="button"><i class="fa fa-reply"></i> Send</button>
                  </div>
                  {!! Form::close() !!}
                  <div class="clearfix"></div>
                </div>
              </div>
              <div id="tab-2" class="tab-pane active">
                <div class="ibox-title">
                  <h5>Activites</h5>
                  <div class="ibox-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                      <i class="fa fa-times"></i>
                    </a>
                  </div>
                </div>
                <div class="ibox-content">
                  <div class="feed-activity-list">
                    @foreach ($Audits as $Audit)
                    <div class="feed-element">
                      @if($Profile->logo)
                      <a href="#" class="pull-left"> <img alt="image" class="img-circle" src="{{ url('/') }}/public/profile').'/'.$Profile->logo }}" /> </a>
                      @else
                      <a href="#" class="pull-left"> <img alt="image" class="img-circle" src="{{ url('/') }}/public/image/a2.jpg"> </a>
                      @endif
                      <div class="media-body ">
                        <small class="pull-right">{{ $Audit->created_at->diffForHumans() }}</small>
                        <strong>{{ $Audit->User->name }}</strong> {{ $Audit->event }} on <strong> {{ $Audit->AuditableType() }} </strong> Table. <br>
                        <small class="text-muted">{{ date('d-m-Y H:i:s',strtotime($Audit->created_at)) }}</small>
                        <div class="well">
                          <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" width="100%">
                              <thead>
                                <tr>
                                  <td>Column</td>
                                  <td>Old Value</td>
                                  <td>New Value</td>
                                </tr>
                              </thead>
                              <tbody>
                                @if($Audit->event=='created')
                                @foreach ($Audit->new_values as $key => $value)
                                <tr>
                                  <td class="text-uppercase">{{$key}}</td>
                                  <td>{{$value}}</td>
                                  <td></td>
                                </tr>
                                @endforeach
                                @else
                                @foreach($Audit->old_values as $key => $value)
                                <tr>
                                  <td class="text-uppercase">{{$key}}</td>
                                  <td>{{$value}}</td>
                                  <td><?php if(isset($Audit->new_values[$key]))  { echo $Audit->new_values[$key]; } else { echo ''; }   ?></td>
                                </tr>
                                @endforeach
                                @endif
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('users.User_Modal')
@component('component.UserPasswordModel',['TableName'=>'UserPassword','user_id'=>$User->id]) @endcomponent
@endsection
@section('script')
<script type="text/javascript">
function readImageURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#img-upload').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#imgInp").change(function() {
  readImageURL(this);
});
</script>
@endsection
