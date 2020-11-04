<div id="{{$TableName}}Modal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-content">
        {!! Form::open(['id'=>$TableName.'Form','method'=>'PUT','url'=>$TableName.'/Change/'.$user_id]) !!}
        <div class="modal-header">
          <h3 class="m-t-none m-b">{{$TableName}}</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('password','Password *')}}
                {{Form::password('password',['class'=>'form-control','autofocus','required'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('confirm_password','Confirm Password *')}}
                {{Form::password('confirm_password',['class'=>'form-control','required'])}}
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
            <button type="submit" class="btn bg-success btn-wide btn-rounded" id='{{$TableName}}_save'><i class="fa fa-check"></i>Save</button>
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
if($('#{{$TableName}}Form input[name="password"]').val()!=$('#{{$TableName}}Form input[name="confirm_password"]').val()) { alert('Password Not Match') }
//   var data = $('#{{$TableName}}Form').serialize();
//   var url_address = $('#{{$TableName}}Form input[name="url"]').val();
//   $.post(url_address, data, function(response) {
//     if (response.result != 'success') { Swal.fire( 'Error!', response.result, 'error' ); return false; }
//     $('#{{$TableName}}Modal').modal('hide');
//     $('#{{$TableName}}Form')[0].reset();
//   }, "json");
});
$('#{{$TableName}}Form').validate({
  rules: {
    password:{ required: true, },
    confirm_password:{ required: true, },
  },
  messages: {
    password:{ required: "Required", },
    confirm_password:{ required: "Required", },
  },
  errorPlacement: function(error,element) {
    error.insertAfter(element);
  }
});
</script>
@stop
