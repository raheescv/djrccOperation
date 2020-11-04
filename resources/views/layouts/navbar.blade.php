<div class="row border-bottom">
  <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <ul class="nav navbar-top-links navbar-left">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa  fa-bars"></i> </a>
        @if($LoggedUser->UserTypePrivilegeModule('Report',$LoggedUser->user_type_id))
        @if($LoggedUser->UserTypePrivilege('StockLog',$LoggedUser->user_type_id))
        <li>
          <a aria-expanded="false" role="button" href="#" class="fa fa-2x fa-bar-chart-o" data-toggle="dropdown"><span class="caret"></span></a>
          <ul class="nav dropdown-menu">
            @if($LoggedUser->UserTypePrivilege('StockLog',$LoggedUser->user_type_id))
            <li><a href="{{ url('/StockLog') }}">StockLog</a></li>
            @endif
          </ul>
        </li>
        @endif
        @endif
      </ul>
    </div>
    <ul class="nav navbar-top-links navbar-right">
      <li>
        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
          <i class="fa fa-language"></i>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
          <li><a href="{{ url('lang/en') }}">English</a></li>
          <li><a href="{{ url('lang/mal') }}">Malayalam</a></li>
        </ul>
      </li>
      <li>
        <span class="m-r-sm text-muted welcome-message">Welcome to @lang('admin_panel')</span>
      </li>
      @if($LoggedUser->UserTypePrivilegeModule('Settings',$LoggedUser->user_type_id))
      <li>
        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
          <i class="fa fa-2x fa-wrench"></i>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
          @if($LoggedUser->UserTypePrivilege('DocumentType',$LoggedUser->user_type_id))
          <li><a href="{{ url('/DocumentType') }}">DocumentType</a></li>
          @endif
          @if($LoggedUser->UserTypePrivilege('Settings',$LoggedUser->user_type_id))
          <li><a href="{{ url('/Settings') }}">Settings</a></li>
          @endif
          @if($LoggedUser->UserTypePrivilege('Download',$LoggedUser->user_type_id))
          <li><a href="{{ url('/Download') }}">BackupDB</a></li>
          @endif
        </ul>
      </li>
      @endif
      @if($LoggedUser->UserTypePrivilege('Reminders',$LoggedUser->user_type_id))
      <li class="dropdown">
        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
          <i class="fa fa-bell"></i>  <span class="label label-primary">{!! $Reminder->count() !!}</span>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
          @foreach($Reminder as $reminder )
          <li>
            <a href="{{ url('/Reminders') }}">
              <i class="fa fa-envelope fa-fw"></i> {{ $reminder->subject }}
              <span class="pull-right text-muted small">
                @if($reminder->Day($reminder->date)==0)
                {{'Today'}}
                @else
                {{$reminder->Day($reminder->date)}} Days
                @endif
              </span>
            </a>
          </li>
          <li class="divider"></li>
          @endforeach
          <li>
            <div class="text-center link-block">
              <a href="{{ url('/Reminders') }}">
                <strong>See All Alerts</strong>
                <i class="fa fa-angle-right"></i>
              </a>
            </div>
          </li>
        </ul>
      </li>
      @endif
      <li>
        <a href="{{ route('Logout') }}"> <i class="fa fa-sign-out"></i> Log out </a>
      </li>
    </ul>
  </nav>
</div>
