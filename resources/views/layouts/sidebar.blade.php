<nav class="sidebar navbar-default navbar-static-side" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav" id="side-menu">
      <li class="nav-header">
        <div class="dropdown profile-element"> <span>
          @if($Profile->logo)
          <img alt="image" class="img" style="width: 100%; height: 100%" src="{{ url('public/profile').'/'.$Profile->logo }}" />
          @else
          <img alt="image" class="img" style="width: 100%; height: 100%" src="{{ url('public/image').'/djrcc.jpeg' }}" />
          @endif
        </span>
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
          <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ $LoggedUser->name }}</strong>
          </span> <span class="text-muted text-xs block">{{$LoggedUser->UserType->name}} <b class="caret"></b></span> </span> </a>
          <ul class="dropdown-menu animated fadeInRight m-t-xs">
            @if($LoggedUser->UserTypePrivilege('Profile',$LoggedUser->user_type_id))
            <li><a href="{{ url('/CompanyProfile') }}">Company Profile</a></li>
            @endif
            <li><a href="{{ url('/User').'/'.$LoggedUser->id }}">User Profile</a></li>
            <li><a data-toggle="modal" href="#change_password_modal" >Change Password</a></li>
            <li class="divider"></li>
            <li><a href="{{ route('SignIn') }}">Logout</a></li>
          </ul>
        </div>
        <div class="logo-element">RCV</div>
      </li>
      <li class="nav-item {{ (request()->is('/')) ? 'active' : '' }}"><a href="{{ url('/') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a></li>
      @if($LoggedUser->UserTypePrivilegeModule('Log',$LoggedUser->user_type_id))
      <li class="nav-item {{ (request()->is('Log')) ? 'active' : '' }}"><a href="{{ url('Log') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Log</span></a></li>
      @endif
      @if($LoggedUser->UserTypePrivilegeModule('CheckList',$LoggedUser->user_type_id))
      <li class="nav-item {{ (request()->is('CheckList')) ? 'active' : '' }}"><a href="{{ url('CheckList') }}"><i class="fa fa-th-large"></i> <span class="nav-label">CheckList</span></a></li>
      @endif
      @if($LoggedUser->UserTypePrivilegeModule('Beacons',$LoggedUser->user_type_id))
      <li class="nav-item {{ (request()->is(['Beacons','Beacon','BeaconView/*','Beacon/*','TestBeacon','TestBeacon/*','TestBeacons','TestBeaconView/*'])) ? 'active' : '' }}">
        <a class="nav-link" href="#"><i class="fa fa-list"></i> <span class="nav-label">Beacons</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          @if($LoggedUser->UserTypePrivilege('Beacons',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is(['Beacon','Beacon/*'])) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/Beacon') }}"><i class="fa fa-list"></i><span class="nav-label">New</span></a></li>
          @endif
          @if($LoggedUser->UserTypePrivilege('Beacons',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is(['Beacons','BeaconView/*'])) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/Beacons') }}"><i class="fa fa-list"></i><span class="nav-label">Beacon List</span></a></li>
          @endif
          @if($LoggedUser->UserTypePrivilege('Beacons',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is(['TestBeacon','TestBeacon/*'])) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/TestBeacon') }}"><i class="fa fa-list"></i><span class="nav-label">Test</span></a></li>
          @endif
          @if($LoggedUser->UserTypePrivilege('Beacons',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is(['TestBeacons','TestBeaconView/*'])) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/TestBeacons') }}"><i class="fa fa-list"></i><span class="nav-label">Test Beacon List</span></a></li>
          @endif
        </ul>
      </li>
      @endif
      @if($LoggedUser->UserTypePrivilegeModule('Situations',$LoggedUser->user_type_id))
      <li class="nav-item {{ (request()->is(['Situations','Situation','SituationView/*','Situation/*'])) ? 'active' : '' }}">
        <a class="nav-link" href="#"><i class="fa fa-list"></i> <span class="nav-label">Situations</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          @if($LoggedUser->UserTypePrivilege('Situations',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is(['Situation','Situation/*'])) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/Situation') }}"><i class="fa fa-list"></i><span class="nav-label">New</span></a></li>
          @endif
          @if($LoggedUser->UserTypePrivilege('Situations',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is(['Situations','SituationView/*'])) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/Situations') }}"><i class="fa fa-list"></i><span class="nav-label">Situation List</span></a></li>
          @endif
        </ul>
      </li>
      @endif
      @if($LoggedUser->UserTypePrivilegeModule('Employees',$LoggedUser->user_type_id))
      <li class="nav-item {{ (request()->is(['Document','Employee'])) ? 'active' : '' }}">
        <a class="nav-link" href="#"><i class="fa fa-users"></i> <span class="nav-label">Employee</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          @if($LoggedUser->UserTypePrivilege('Documents',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is('Document')) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/Document') }}"><i class="fa fa-files-o"></i><span class="nav-label">Document</span></a></li>
          @endif
          @if($LoggedUser->UserTypePrivilege('Employee',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is('Employee')) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/Employee') }}"><i class="fa fa-users"></i><span class="nav-label">Employee</span></a></li>
          @endif
        </ul>
      </li>
      @endif
      @if($LoggedUser->user_type_id==1)
      @if($LoggedUser->UserTypePrivilegeModule('User',$LoggedUser->user_type_id))
      <li class="nav-item {{ (request()->is(['UserList','UserTypePrivileges','UserTypes'])) ? 'active' : '' }}">
        <a class="nav-link" href="#"><i class="fa fa-user"></i> <span class="nav-label">User</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          @if($LoggedUser->UserTypePrivilege('UserList',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is('UserList')) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/UserList') }}">UserList</a></li>
          @endif
          @if($LoggedUser->UserTypePrivilege('UserTypePrivileges',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is('UserTypePrivileges')) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/UserTypePrivileges') }}">UserTypePrivileges</a></li>
          @endif
          @if($LoggedUser->UserTypePrivilege('UserTypes',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is('UserTypes')) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/UserTypes') }}">UserTypes</a></li>
          @endif
        </ul>
      </li>
      @endif
      @endif
      @if($LoggedUser->UserTypePrivilegeModule('Tasks',$LoggedUser->user_type_id))
      <li class="nav-item {{ (request()->is(['Calender','Tasks'])) ? 'active' : '' }}">
        <a class="nav-link" href="#"><i class="fa fa-tasks"></i> <span class="nav-label">Tasks</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          @if($LoggedUser->UserTypePrivilege('Calender',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is('Calender')) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/Calender') }}">Calender View</a></li>
          @endif
          @if($LoggedUser->UserTypePrivilege('Tasks',$LoggedUser->user_type_id))
          <li class="nav-item {{ (request()->is('Tasks')) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/Tasks') }}">Tasks</a></li>
          @endif
        </ul>
      </li>
      @endif
      @if($LoggedUser->UserTypePrivilege('Reminders',$LoggedUser->user_type_id))
      <li class="nav-item {{ (request()->is('Reminders')) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/Reminders') }}"><i class="fa fa-envelope"></i> <span class="nav-label">Reminders</span><span class="label label-warning pull-right">{!! $Reminder->count() !!}</span></a></li>
      @endif
      @if($LoggedUser->user_type_id==1)
      @if($LoggedUser->UserTypePrivilege('languages',$LoggedUser->user_type_id))
      <li class="nav-item {{ (request()->is('languages')) ? 'active' : '' }}"><a class="nav-link" href="{{ url('/languages') }}"><i class="fa fa-language"></i> <span class="nav-label">Languages</span></a></li>
      @endif
      @endif
    </ul>
  </div>
</nav>
