<div id="Task_modal" class="modal fade" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			{!! Form::open(['id'=>'TaskForm']) !!}
			{{ Form::hidden('url',url('add_Task')) }}
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12"><h3 class="m-t-none m-b">Task</h3>
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<h4>{{Form::label('title','Title')}}</h4>
										{{Form::text('title','',['class'=>'form-control','placeholder'=>'Enter Title','autofocus'])}}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<h4>{{Form::label('description','Description')}}</h4>
										{{Form::text('description','',['class'=>'form-control','placeholder'=>'Enter Description'])}}
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-4 input-append">
									<h4>{{Form::label('date','Date')}}</h4>
									<div class="input-group">
										<input type="date" name='date' class="form-control" value="<?= date('Y-m-d') ?>">
									</div>
								</div>
								<div class="col-md-4 input-append">
									<h4>{{Form::label('start_time','Start Time')}}</h4>
									<div class="input-group clockpicker" data-placement="left" data-donetext="Done" data-align="top" data-autoclose="true">
										<input type="time" name='start_time' id="start_time" class="form-control" value="<?= date('H:i') ?>">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-time"></span>
										</span>
									</div>
								</div>
								<div class="col-md-4 input-append">
									<h4>{{Form::label('end_time','End Time')}}</h4>
									<div class="input-group clockpicker" data-placement="left" data-donetext="Done" data-align="top" data-autoclose="true">
										<input type="time" name='end_time' id="end_time" class="form-control" value="<?= date('H:i') ?>">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-time"></span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2">
									<div class="form-group">
										<h4>{{Form::label('color','Color')}}</h4>
										<select id="colorselector" name="color">
											<option value="#007bff"  data-color="#007bff" selected="selected">Blue</option>
											<option value="#28a745"  data-color="#28a745">Green</option>
											<option value="#17a2b8"  data-color="#17a2b8">Purple</option>
											<option value="#ffc107"  data-color="#ffc107">Yellow</option>
											<option value="#dc3545"  data-color="#dc3545">Red</option>
											<option value="#343a40"  data-color="#343a40">Dark Gray</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<h4>{{Form::label('status','Status')}}</h4>
										{{Form::select('status',['1'=>'Pending','2'=>'Completed','3'=>'Cancel'],'',['id'=>'status','class'=>'form-control select2_class','style'=>'width:100%'])}}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
					<button type="button" class="btn bg-success btn-wide btn-rounded" id='Task_save_button'><i class="fa fa-check"></i>Save</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@section('script')
@parent
<script type="text/javascript">
	$('#start_time').on("change", function(e) {
		var start_time=$(this).val();
		split_time=start_time.split(':');
		minut=parseInt(split_time[1])+parseInt(30);
		end_time=split_time[0]+':'+minut;
		$('#end_time').val(end_time);
        $('#end_time').select();
    });
	$('#end_time').on("change", function(e) {
        $('#status').select2('open');
    });
	$('#status').on("select2:select", function(e) {
        $('#title').select();
    });
    $('#TaskForm').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {$('#Task_save_button').click(); return false; }
    });
</script>
@stop
