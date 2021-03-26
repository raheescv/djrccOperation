<div id="{{$TableName}}Modal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-content">
        {!! Form::open(['id'=>$TableName.'Form','url'=>$TableName.'/Store']) !!}
        {{ Form::hidden('url',url($TableName.'/Store')) }}
        <div class="modal-header">
          <h3 class="m-t-none m-b">{{$TableName}}</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('date','date *',['class'=>'text-capitalize'])}}
                {{Form::date('date',date('Y-m-d'),['class'=>'form-control','required'])}}
              </div>
            </div>
            <div class="col-md-6">
              {{Form::label('time','Time')}}
              <div class="input-group clockpicker" data-placement="left" data-donetext="Done" data-align="top" data-autoclose="true">
                <input type="time" name='time' id="time" class="form-control" value="<?= date('H:i') ?>">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                </span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                {{Form::label('employee_id','Employee *',['class'=>'text-capitalize'])}}
                {{Form::select('employee_id',[],'',['id'=>"modal_employee_id",'class'=>'form-control','required'])}}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                {{Form::label('remarks','remarks',['class'=>'text-capitalize'])}}
                {{Form::textarea('remarks','',['class'=>'form-control'])}}
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
    dataTable.draw();
  }, "json");
});
$('#{{$TableName}}Form').validate({
  rules: {
    employee_id:{ required: true, },
    date:{ required: true, },
    time:{ required: true, },
  },
  messages: {
    employee_id:{ required: "Required", },
    date:{ required: "Required", },
    time:{ required: "Required", },
  },
  errorPlacement: function(error,element) {
    error.insertAfter(element);
  }
});
$("#modal_employee_id").select2({
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
  $('#time').click();
});
$('#time').on("change", function(e) {
  $('#modal_employee_id').select2('open');
});
$('#modal_employee_id').on("select2:select", function(e) {
  // if($(this).val()=='Add') { $('#modal_employee_id').val('').change(); $('#EmployeeModal').modal('toggle'); return false; }
  $('#remarks').select();
});
</script>
@stop
