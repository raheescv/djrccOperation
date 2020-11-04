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
                {{Form::label('name','Name *')}}
                {{Form::text('name','',['class'=>'form-control','autofocus','required'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('employee_code','Employee Code *')}}
                {{Form::text('employee_code','',['class'=>'form-control','required'])}}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                {{Form::label('name_arabic','Arabic Name *')}}
                {{Form::text('name_arabic','',['class'=>'form-control'])}}
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
    var routeName="{{Route::getCurrentRoute()->getActionMethod()}}";
    if(routeName=='Employee'){
      dataTable.fnDraw();
    } else {
      $('#employee_id').append($("<option></option>").attr("value",response.key).text(response.value));
      $('#employee_id').val(response.key).trigger('change');
    }
  }, "json");
});
$('#{{$TableName}}Form').validate({
  rules: {
    name:{ required: true, },
    employee_code:{
      required: true,
      remote: {
        url: "{{ route('Employee_employee_code_check')}}",
        type: "post",
        data: {
          employee_code: function() {
            return $('#{{$TableName}}Form input[name="employee_code"]').val();
          },
          'register': true,
          '_token': "{{ csrf_token() }}"
        }
      }
    },
  },
  messages: {
    name:{ required: "Required", },
    employee_code:{
      required: "Required",
      remote: "{{ route('Employee_employee_code_check')}}"
    },
  },
  errorPlacement: function(error,element) {
    error.insertAfter(element);
  }
});
</script>
@stop
