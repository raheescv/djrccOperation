@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('public/css/fullcalendar.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/bootstrap-datetimepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/bootstrap-colorselector.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/bootstrap-clockpicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/buttons.jqueryui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.responsive.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.tableTools.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/fixedHeader.dataTables.min.css') }}" />
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
			<button class="btn btn-success" data-toggle="modal" data-target="#Task_modal">Add Task</button>
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
						<div class="col-md-3">
							{{Form::label('from','From')}}
							{{Form::date('from',date('Y-m-d',strtotime('first day of this month')),['class'=>'form-control','id'=>'from'])}}
						</div>
						<div class="col-md-3">
							{{Form::label('to','To')}}
							{{Form::date('to',date('Y-m-t'),['class'=>'form-control','id'=>'to'])}}
						</div>
						<div class="col-md-3"><br>
							<button class='btn btn-success' id="get_button">GET</button>
						</div>
					</div>
				</div>
				<div class="ibox-content">
					<div class="table-responsivse">
						<table class="table table-bordered table-hover table-striped table-condensed mb-none" id='dataTable' width="100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Title</th>
									<th>Description</th>
									<th>Date</th>
									<th>Start Time</th>
									<th>End Time</th>
									<th>Color</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				@include('tasks.Task_modal')
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{ url('public/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.jqueryui.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ url('public/js/buttons.jqueryui.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.fixedColumns.min.js')}}"></script>
<script src="{{ url('public/js/buttons.colVis.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ url('public/js/dataTables.responsive.js')}}"></script>
<script src="{{ url('public/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{ url('public/js/buttons.flash.min.js')}}"></script>
<script src="{{ url('public/js/jszip.min.js')}}"></script>
<script src="{{ url('public/js/pdfmake.min.js')}}"></script>
<script src="{{ url('public/js/vfs_fonts.js')}}"></script>
<script src="{{ url('public/js/buttons.html5.min.js')}}"></script>
<script src="{{ url('public/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('public/js/moment.min.js')}}"></script>
<script src="{{ asset('public/js/fullcalendar.min.js')}}"></script>
<script src="{{ asset('public/js/bootstrap-colorselector.js')}}"></script>
<script src="{{ asset('public/js/switchery.js')}}"></script>
<script type="text/javascript">
var dataTable=$('#dataTable').dataTable( {
	"processing": true,
	"serverSide": true,
	"lengthMenu": [[ 50, 100, 200,1000], [ 50, 100, 200,1000, ]],
	"ajax": {
		"url":"<?= route('TaskTable') ?>",
		"dataType":"json",
		"type":"POST",
		data:function(d){
			d._token= "<?= csrf_token() ?>";
			d.from  = $('#from').val();
			d.to    = $('#to').val();
		},
	},
	dom: 'Bfrtip',
	buttons: [
		{extend: 'colvis' },
		{extend: 'csv'  ,footer: true,exportOptions: {columns: ':visible'}},
		{extend: 'excel',footer: true,exportOptions: {columns: ':visible'}},
		'pageLength',
	],
	"createdRow": function( row, data, dataIndex ) {
		// $(row).css('background-color',data['color']);
	},
	"columns":[
		{"data":"id",'visible':false},
		{"data":"title"},
		{"data":"description"},
		{"data":"date"},
		{"data":"start_time"},
		{"data":"end_time"},
		{"data":"color"},
		{"data":"status"},
		{"data":"action"},
	],
	"columnDefs":[
	],
} );
$('#get_button').click(function(){
	dataTable.fnDraw();
});
</script>
<script type="text/javascript">
$('#Task_save_button').click(function(){
	if(!$('#TaskForm input[name="title"]').val()){
		$('#TaskForm input[name="title"]').select(); return false;
	}
	var data=$('#TaskForm').serialize();
	var url_address=$('#TaskForm input[name="url"]').val();
	$.post( url_address,data, function( response ) {
		if(response.result!='success') { alert(response.result); return false; }
		$('#Task_modal').modal('hide');
		dataTable.fnDraw();
	}, "json");
});
</script>
<script type="text/javascript">
$('#table_add_button').click(function(){
	$('#TaskForm')[0].reset();
	$('#TaskForm input[name="url"]').val('<?= url('add_Task') ?>');
});
$(document).on('click','.edit',function(){
	var table_id=$(this).attr('table_id');
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
			$('#status').val(data.status).change();
			$('#colorselector').val(data.color).change();
			$('#Task_modal').modal('show');
		}
	});
});
$(document).on('click','.delete',function(){
	if(!confirm('Are You Sure')) {return false;}
	var table_id=$(this).attr('table_id');
	var url_address="<?= url('delete_Task') ?>/"+$(this).attr('table_id');
	$.get(url_address,function(data){
		if(data.result!='success') { alert(data.result); return false; }
		dataTable.fnDraw();
	}, "json");
});
</script>
<script type="text/javascript">
$('.clockpicker').clockpicker();
$('#colorselector').colorselector();
</script>
@endsection
