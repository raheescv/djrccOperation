@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ url('public/css/switchery.css') }}" />
<style type="text/css">
.switchery {
  width: 110px; // your width
  border: 2px solid black;
}
.switchery:before {
  content: 'Yes';
  color: #333;
  position: absolute;
  left:40px;
  top: 50%;
  transform: translateY(-50%) translateX(-10%);
}
.js-switch:checked + .switchery:before {
  color: #fff;
  content: 'No';
  width:100px;
  left:40px;
}
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Settings</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>Company</a></li>
      <li class="active"><strong>Settings</strong></li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Settings<small> Tables</small></h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
          {!! Form::open(array('url' => '/Settings_Update','id'=>'SettingsForm','method'=>'post')); !!}
          <div class="form-group row">
            <div class="col-md-6 col-md-offset-3">
              <table class="table table-bordered table-hover table-striped table-condensed" width="100%">
                <thead>
                  <tr>
                    <th width="60%">Title</th>
                    <th width="40%">Value</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th class="text-center">{{Form::label('collapse_menu','Collapse Menu')}}</th>
                    <td>
                      <div class="onoffswitch">
                        <input type="checkbox" name="collapse_menu" class="onoffswitch-checkbox" value="Yes" @if($Settings->collapse_menu=='Yes') checked @endif id="collapse_menu">
                        <label class="onoffswitch-label" for="collapse_menu">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                        </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-center">{{Form::label('fixed_nav_bar','Fixed Nav Bar')}}</th>
                    <td>
                      <div class="onoffswitch">
                        <input type="checkbox" name="fixed_nav_bar" class="onoffswitch-checkbox" value="Yes" @if($Settings->fixed_nav_bar=='Yes') checked @endif id="fixed_nav_bar">
                        <label class="onoffswitch-label" for="fixed_nav_bar">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                        </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-center">{{Form::label('fixed_side_bar','Fixed Side Bar')}}</th>
                    <td>
                      <div class="onoffswitch">
                        <input type="checkbox" name="fixed_side_bar" class="onoffswitch-checkbox" value="Yes" @if($Settings->fixed_side_bar=='Yes') checked @endif id="fixed_side_bar">
                        <label class="onoffswitch-label" for="fixed_side_bar">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                        </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-center">{{Form::label('fixed_footer','Fixed Footer')}}</th>
                    <td>
                      <div class="onoffswitch">
                        <input type="checkbox" name="fixed_footer" class="onoffswitch-checkbox" value="Yes" @if($Settings->fixed_footer=='Yes') checked @endif id="fixed_footer">
                        <label class="onoffswitch-label" for="fixed_footer">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                        </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-center">{{Form::label('skin','Skin')}}</th>
                    <td>{{Form::select('skin',$skins,$Settings->skin,['class'=>'form-control select2_class','id'=>'skin'])}}</td>
                  </tr>
                  <tr>
                    <td colspan="2"><button type="submit" id='submit_button' class="btn btn-primary btn-sm btn-block">Update Settings</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ url('public/js/switchery.js')}}"></script>
<script>
var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
elems.forEach(function(html) {
  var switchery = new Switchery(html);
});
shortcut.add("ctrl+shift+a", function() {
  $('#table_add_button').click();
});
</script>
@endsection
