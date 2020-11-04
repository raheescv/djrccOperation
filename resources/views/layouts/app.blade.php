<!doctype html>
<html class="fixed" lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <title><?= $Profile->company ?></title>
  <meta name="keywords" content="HTML5 Admin Template" />
  <meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
  <meta name="author" content="JSOFT.net">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/font-awesome.min.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/toastr.min.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/jquery.gritter.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/animate.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/style.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/jquery-ui.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/select2.min.css') }}" />
  <!-- <link rel="stylesheet" href="{{ url('public/css/app.css') }}" /> -->
  <link rel="stylesheet" href="{{ url('public/css/sweetalert2.min.css') }}" />
  @yield('style')
  <script src="{{ url('public/js/jquery-3.3.1.js')}}"></script>
  <script src="{{ url('public/js/bootstrap-datetimepicker.js')}}"></script>
  <style type="text/css">
  input {
    padding-left : 0px !important;
    padding-right: 0px !important;
  }
  .number {
    text-align: right;
  }
  .modal{
    z-index: 2030 !important;
  }
  .clockpicker-popover{
    z-index: 2030 !important;
  }
  .swal2-container {
    z-index: 100005 !important;
  }
  .select2-dropdown{
    z-index: 30510;
  }
</style>
<script type="text/javascript">
$(document).ajaxStart(function(e)    { $("#wait").show(); });
$(document).ajaxComplete(function(e) { $("#wait").hide(); });
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
</head>
<body>
  <div id="wrapper">
    @include('layouts.sidebar')
    <div id="page-wrapper" class="gray-bg dashbard-1">
      @include('layouts.navbar')
      @yield('content')
      <div id="wait" style="display:none; width:2000px;height:2000px;position:fixed;top: 50%;left:50%;padding:2px;"><img src="{{ url('public/image/spinner.gif') }}" width="100" height="100" /><br>Loading..</div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="footer">
          <div class="pull-right">RCV</div>
          <div><strong>ASTRA</strong></div>
        </div>
      </div>
    </div>
  </div>
  @include('layouts.ChangePassword')
  <script src="{{ url('public/js/bootstrap.min.js')}}"></script>
  <script src="{{ url('public/js/jquery.metisMenu.js')}}"></script>
  <script src="{{ url('public/js/jquery.slimscroll.min.js')}}"></script>
  <script src="{{ url('public/js/jquery.peity.min.js')}}"></script>
  <script src="{{ url('public/js/peity-demo.js')}}"></script>
  <script src="{{ url('public/js/inspinia.js')}}"></script>
  <script src="{{ url('public/js/pace.min.js')}}"></script>
  <script src="{{ url('public/js/jquery-ui.min.js')}}"></script>
  <script src="{{ url('public/js/jquery.gritter.min.js')}}"></script>
  <script src="{{ url('public/js/jquery.sparkline.min.js')}}"></script>
  <script src="{{ url('public/js/sparkline-demo.js')}}"></script>
  <script src="{{ url('public/js/toastr.min.js')}}"></script>
  <script src="{{ url('public/js/DesktopNotification.js') }}"></script>
  <script src="{{ url('public/js/select2.min.js')}}"></script>
  <script src="{{ url('public/js/app.js')}}"></script>
  <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
  <script src="{{ url('public/js/sweetalert.min.js')}}"></script>
  <script type="text/javascript">
  $('.modal').on('shown.bs.modal', function() {
    $(this).find('[autofocus]').focus();
  });
  $('input').click(function(){
    $(this).select();
  });
  $(document).on('keyup','.number',function(){
    if(isNaN($(this).val()) || $(this).val()=='')
    {
      $(this).val('0').keyup();
    }
  });
  $(document).ready(function(){
    // $('.dataTable_class').dataTable();
    $('.select2_class').select2({
      width:"100%",
    });
  });
</script>
<script type="text/javascript">
var idleTime = 0;
$(document).ready(function () {
  var idleInterval = setInterval(timerIncrement, 60000); // 1 minutes
  $(this).mousemove(function (e) {
    idleTime = 0;
  });
  $(this).keypress(function (e) {
    idleTime = 0;
  });
});
function timerIncrement() {
  idleTime = idleTime + 1;
  if (idleTime > 19) { // 20 minutes
    var url="{{ url('/') }}";
    NotificationFunction('Session Time Out','Your Session is Going To Exprire Please Go Back Your Site',url);
    idleTime=0;
  }
}
</script>
<script type="text/javascript">
$("body").addClass("{{$Settings->skin}}");
</script>
@if($Settings->fixed_nav_bar=='Yes')
<script type="text/javascript">
$(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
$("body").addClass('fixed-nav');
</script>
@endif
@if($Settings->fixed_side_bar=='Yes')
<script type="text/javascript">
$("body").addClass('fixed-sidebar');
$('.sidebar-collapse').slimScroll({
  height: '100%',
  railOpacity: 0.9,
});
</script>
@endif
@if($Settings->collapse_menu=='Yes')
<script type="text/javascript">
$("body").addClass('mini-navbar');
SmoothlyMenu();
</script>
@endif
@if($Settings->fixed_footer=='Yes')
<script type="text/javascript">
$(".footer").addClass('fixed');
</script>
@endif

@include('layouts.messages')
@yield('script')
@toastr_render
</body>
</html>
