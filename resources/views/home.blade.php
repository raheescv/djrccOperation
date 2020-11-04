@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="wrapper wrapper-content">
      <div class="row">
        @if($LoggedUser->UserTypePrivilegeModule('Beacons',$LoggedUser->user_type_id))
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <span class="label label-success pull-right"></span>
              <h5><a href="{{url('Beacons')}}">ELT</a></h5>
            </div>
            <div class="ibox-content">
              <h1 class="no-margins">{{$ELTCount}}</h1>
              <div class="stat-percent font-bold text-success"></div>
              <small>Total ELT Registration</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <span class="label label-success pull-right"></span>
              <h5><a href="{{url('Beacons')}}">EPIRB</a></h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{$EPIRBCount}}</h1>
              <div class="stat-percent font-bold text-success"></div>
              <small>Total EPIRB Registration</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <span class="label label-success pull-right"></span>
              <h5><a href="{{url('Beacons')}}">PLB</a></h5>
            </div>
            <div class="ibox-content">
              <h1 class="no-margins">{{$PLBCount}}</h1>
              <div class="stat-percent font-bold text-success"></div>
              <small>Total PLB Registration</small>
            </div>
          </div>
        </div>
        @endif
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5>Document Expiry</h5>
              <div class="ibox-tools">
                <span class="label label-warning-light">{{ count($Document) }} Documents</span>
              </div>
            </div>
            @if(count($Document))
            <div class="ibox-content ibox-heading">
              <h2><i class="fa fa-files-o"></i> Coming Expiry Documents</h2>
              <small><i class="fa fa-tim"></i> You have {{count($Document)}} new Documents</small>
            </div>
            @endif
            <div class="ibox-content">
              <div>
                <div class="feed-activity-list">
                  <?php foreach ($Document as $key => $value): ?>
                    <div class="feed-element">
                      <div>
                        <small class="pull-right text-navy">({{$value->Remaining()}}){{ date('d-m-Y',strtotime($value->date_of_expiry)) }}</small>
                        <strong>{{ $value->Employee->name }} : </strong> {{$value->DocumentType->name}} <br>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                <a  href="{{ url('Document') }}" class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Show More</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5>Reminder</h5>
              <div class="ibox-tools">
                <a class="collapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                  <i class="fa fa-times"></i>
                </a>
              </div>
            </div>
            @if(count($Reminder))
            <div class="ibox-content ibox-heading">
              <h3><i class="fa fa-envelope-o"></i> New Reminder</h3>
              <small><i class="fa fa-tim"></i> You have {{count($Reminder)}} new messages</small>
            </div>
            @endif
            <div class="ibox-content">
              <div class="feed-activity-list">
                @foreach($Reminder as $value)
                <div class="feed-element">
                  <div>
                    <small class="pull-right text-navy">{{ date('d-m-Y H:i A',strtotime($value->date)) }}</small>
                    <strong>{{ $value->subject }}</strong>
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
@endsection
@section('script')
<script src="{{ asset('public/js/jquery.flot.js')}}"></script>
<script src="{{ asset('public/js/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{ asset('public/js/jquery.flot.spline.js')}}"></script>
<script src="{{ asset('public/js/jquery.flot.resize.js')}}"></script>
<script src="{{ asset('public/js/jquery.flot.pie.js')}}"></script>
<script src="{{ asset('public/js/Chart.min.js')}}"></script>
@endsection
