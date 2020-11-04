@extends('layouts.app')
@section('style')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-sm-4">
    <h2>Empty</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>Form</a></li>
      <li class="active"><strong>Empty</strong></li>
    </ol>
  </div>
  <div class="col-sm-8">
    <div class="title-action">
      <button class="btn btn-success" data-toggle="modal" id='table_add_button' data-target="#Empty_modal">Add Empty</button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="wrapper wrapper-content">
      <div class="middle-box text-center animated fadeInRightBig">
        <h3 class="font-bold">This is page content</h3>
        <div class="error-desc">
          You can create here any grid layout you want. And any variation layout you imagine:) Check out main dashboard and other site. It use many different layout.
          <br/><a href="{{ url('/') }}" class="btn btn-primary m-t">Dashboard</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@endsection
