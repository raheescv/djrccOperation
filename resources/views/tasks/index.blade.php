@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ url('public/css/fullcalendar.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/bootstrap-datetimepicker.min.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/bootstrap-colorselector.css') }}" />
<link rel="stylesheet" href="{{ url('public/css/bootstrap-clockpicker.min.css') }}" />
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-sm-4">
    <h2>Calendar</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-2x fa-home"></i></a></li>
      <li><a>Forms</a></li>
      <li class="active"><strong>Calendar</strong></li>
    </ol>
  </div>
  <div class="col-sm-8">
    <div class="title-action">
      <button class="btn btn-success" id='table_add_button' data-toggle="modal" data-target="#Task_modal">Add Task</button>
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
            <div class="col-md-12">
              <div>
                <div id="calendar-id"></div>
              </div>
            </div>
            @include('tasks.Task_modal')
          </div>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-md-12">
              <p class="h4 text-light">Up Comming Tasks</p>
              <div>
                @foreach($Tasks as $Event)
                <div style="background:{{ $Event->color }}" class="external-event label">{{ $Event->title }}-{{ date('H:i',strtotime($Event->start_date)) }}</div>
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
<script src="{{ url('public/js/moment.min.js')}}"></script>
<script src="{{ url('public/js/fullcalendar.min.js')}}"></script>
<script src="{{ url('public/js/bootstrap-colorselector.js')}}"></script>
<script src="{{ url('public/js/bootstrap-clockpicker.min.js')}}"></script>
<script type="text/javascript">
$(".form_datetime").datetimepicker({
  format: "dd-mm-yyyy HH:ii P",
  showMeridian: true,
  autoclose: true,
  todayBtn: true
});
$('.clockpicker').clockpicker();
$('#colorselector').colorselector();
</script>
<script type="text/javascript">
$('#Task_save_button').click(function(){
  if (!$('#title').val()) { $('#title').focus(); return false; }
  if ($('#date').val() == 0) {$('#date').focus(); return false; }
  if ($('#start_time').val() == 0) {$('#start_time').focus(); return false; }
  if ($('#end_time').val() == 0) {$('#end_time').focus(); return false; }
  var data=$('#TaskForm').serialize();
  var url_address=$('#TaskForm input[name="url"]').val();
  $.post( url_address,data, function( response ) {
    if(response.result!='success') { alert(response.result); return false; }
    $('#Task_modal').modal('hide');
    location.reload();
  }, "json");
});
$('#table_add_button').click(function(){
  $('#TaskForm')[0].reset();
  $('#TaskForm input[name="url"]').val('<?= url('add_Task') ?>');
});
function edit(table_id) {
  $.ajax({
    url: '<?= url('get_Task') ?>'+'/'+table_id,
    type: 'get',
    dataType: 'JSON',
    success: function (data) {
      $('#TaskForm input[name="url"]').val('<?= url('edit_Task') ?>'+'/'+table_id);
      $('#TaskForm input[name="title"]').val(data.title);
      $('#TaskForm input[name="date"]').val(data.date);
      $('#TaskForm input[name="start_time"]').val(data.start_time);
      $('#TaskForm input[name="end_time"]').val(data.end_time);
      $('#accounthead_id').val(data.accounthead_id).change();
      $('#employee_id').val(data.employee_id).change();
      $('#service_id').val(data.service_id).change();
      $('#status').val(data.status).change();
      $('#colorselector').val(data.color).change();
      $('#Task_modal').modal('show');
    }
  });
};
</script>
<script>
$(document).ready(function(){
  $('#calendar-id').fullCalendar({
    header:{
      left:"prev,next today",
      center:"title",
      right: 'month,agendaWeek,agendaDay,listWeek'
    },
    eventLimit:true,
    eventClick:function(event) {
      edit(event.id);
    },
    events:[
      @foreach($calendar as $Event)
      {"id":"{{$Event->id}}","title":"{{$Event->title}}","allDay":false,"start":"{{$Event->date.'T'.$Event->start_time}}","end":"{{$Event->date.'T'.$Event->end_time}}","color":"{{$Event->color}}"},
      @endforeach
    ]
  });
});
</script>
@endsection
