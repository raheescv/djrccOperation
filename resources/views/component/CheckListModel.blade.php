<div id="{{$TableName}}Modal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-content">
        {!! Form::open(['id'=>$TableName.'Form','url'=>$TableName.'/Store']) !!}
        {{ Form::hidden('url',url($TableName.'/Store')) }}
        <div class="modal-header">
          <h3 class="m-t-none m-b">{{$TableName}}</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                {{Form::label('date','date *',['class'=>'text-capitalize'])}}
                {{Form::date('date',date('Y-m-d'),['class'=>'form-control','required'])}}
              </div>
            </div>
            <div class="col-md-4">
              {{Form::label('time','Time')}}
              <div class="input-group clockpicker" data-placement="left" data-donetext="Done" data-align="top" data-autoclose="true">
                <input type="time" name='time' id="time" class="form-control" value="<?= date('H:i') ?>">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                </span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {{Form::label('employee_id','employee *',['class'=>'text-capitalize'])}}
                {{Form::select('employee_id',[],'',['id'=>"modal_employee_id",'class'=>'form-control','required'])}}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('sarp_data','s a r p data',['class'=>'text-capitalize'])}}
                {{Form::text('sarp_data','',['class'=>'form-control'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('orbit_data','orbit data',['class'=>'text-capitalize'])}}
                {{Form::text('orbit_data','',['class'=>'form-control'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('ftp_link','f t p link',['class'=>'text-capitalize'])}}
                {{Form::text('ftp_link','',['class'=>'form-control'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('aftn_link','a f t n link',['class'=>'text-capitalize'])}}
                {{Form::text('aftn_link','',['class'=>'form-control'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('amhs_link','a m h s link',['class'=>'text-capitalize'])}}
                {{Form::text('amhs_link','',['class'=>'form-control'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('tele_fax','tele/fax',['class'=>'text-capitalize'])}}
                {{Form::text('tele_fax','',['class'=>'form-control'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('printer','printer',['class'=>'text-capitalize'])}}
                {{Form::text('printer','',['class'=>'form-control'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('ops_room_status','o p s room status',['class'=>'text-capitalize'])}}
                {{Form::text('ops_room_status','',['class'=>'form-control'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('leo_lut','l e o lut',['class'=>'text-capitalize'])}}
                {{Form::text('leo_lut','',['class'=>'form-control'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('geo_lut','g e o lut',['class'=>'text-capitalize'])}}
                {{Form::text('geo_lut','',['class'=>'form-control'])}}
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
            <button type="button" class="btn bg-success btn-wide btn-rounded" id='{{$TableName}}_save'><i class="fa fa-check"></i>Save</button>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@section('script')
@parent
<script type="text/javascript">
$('#{{$TableName}}Form').keypress(function(event) {
  var keycode = (event.keyCode ? event.keyCode : event.which);
  if (keycode == '13') {$('#{{$TableName}}_save').click(); return false; }
});
$('#{{$TableName}}_save').click(function() {
  if(!$('#{{$TableName}}Form').valid()) return false;
  var data = $('#{{$TableName}}Form').serialize();
  var url_address = $('#{{$TableName}}Form input[name="url"]').val();
  $.post(url_address, data, function(response) {
    if (response.result != 'success') { Swal.fire( 'Error!', response.result, 'error' ); return false; }
    $('#{{$TableName}}Form')[0].reset();
    $('#{{$TableName}}Modal').modal('hide');
    dataTable.fnDraw();
  }, "json");
});
$('#{{$TableName}}Form').validate({
  rules: {
    employee_id:{ required: true, },
    controller_id:{ required: true, },
    date:{ required: true, },
    entry_time:{ required: true, },
    exit_time:{ required: true, },
    remarks:{ required: true, },
  },
  messages: {
    employee_id:{ required: "Required", },
    controller_id:{ required: "Required", },
    date:{ required: "Required", },
    entry_time:{ required: "Required", },
    exit_time:{ required: "Required", },
    remarks:{ required: "Required", },
  },
  errorPlacement: function(error,element) {
    error.insertAfter(element);
  }
});
$("#modal_employee_id,#modal_controller_id").select2({
  placeholder: "Select Employee",
  width: '100%',
  ajax: {
    url: '<?= url('Employee/GetList') ?>',
    dataType: 'json',
    method: 'post',
    delay: 250,
    data: function(data) {
      return {
        _token    : "<?= csrf_token() ?>",
        search_tag: data.term,
        type: 'name',
      };
    },
    processResults: function(data, params) {
      params.page = params.page || 1;
      return {
        results: $.map(data.items, function(obj) { return { id: obj.id, text: obj.name }; }),
        pagination: { more: (params.page * 30) < data.total_count }
      };
    },
    cache: true
  },
});
$('#date').on("change", function(e) {
  $('#entry_time').click();
});
$('#entry_time').on("change", function(e) {
  $('#exit_time').click();
});
$('#exit_time').on("change", function(e) {
  $('#modal_employee_id').select2('open');
});
$('#modal_employee_id').on("select2:select", function(e) {
  // if($(this).val()=='Add') { $('#modal_employee_id').val('').change(); $('#EmployeeModal').modal('toggle'); return false; }
  $('#modal_controller_id').select2('open');
});
$('#modal_controller_id').on("select2:select", function(e) {
  // if($(this).val()=='Add') { $('#modal_controller_id').val('').change(); $('#EmployeeModal').modal('toggle'); return false; }
  $('#remarks').select();
});
</script>
@stop
