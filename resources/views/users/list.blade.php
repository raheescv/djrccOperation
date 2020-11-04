@extends('layouts.app')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>User</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>Forms</a></li>
      <li class="active"><strong>User</strong></li>
    </ol>
  </div>
  <div class="col-sm-2">
    <div class="title-action">
      <button class="btn btn-success" data-toggle="modal" id='table_add_button' data-target="#User_Modal">Add User</button>
    </div>
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
            @foreach($User as $SingleUser)
            <div class="col-lg-4">
              <div class="contact-box">
                  <div class="col-sm-4">
                    <div class="text-center">
                      @if($SingleUser->image)
                      <img alt="image" class="img-circle m-t-xs img-responsive" src="{{ url('public/profile/'.$SingleUser->image) }}">
                      @else
                      <img alt="image" class="img-circle m-t-xs img-responsive" src="{{ url('public/image/a2.jpg') }}">
                      @endif
                      <div class="m-t-xs font-bold">{{$SingleUser->UserType->name}}</div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <h3><strong>{{$SingleUser->name}}</strong></h3>
                    <p><i class="fa fa-map-marker"></i> {{$SingleUser->web_site}}</p>
                    <address>
                      <strong>{{$SingleUser->email}}</strong><br>
                      {{date('d-m-Y',strtotime($SingleUser->created_at))}}<br>
                      <abbr title="Phone">Ph:</abbr> +({{$SingleUser->country_code}}) {{$SingleUser->mobile}}
                    </address>
                    <a href="{{ url('/User').'/'.$SingleUser->id }}">View</a>
                  </div>
                  <div class="clearfix"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('users.User_Modal')
@endsection
@section('script')
<script>
  $(document).ready(function(){
    $('.contact-box').each(function() {
      animationHover(this, 'pulse');
    });
  });
</script>
<script type="text/javascript">
  $(document).on('click','.delete',function(){
    if(!confirm("Are you sure?")) { return false; }
    var table_id=$(this).closest('td span').attr('table_id');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url: 'user/delete/'+table_id,
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
