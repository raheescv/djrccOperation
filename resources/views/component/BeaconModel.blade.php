<?php use App\Models\Beacon; ?>
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
                {{Form::label('beacon_type_id','Beacon Type *')}}
                {{Form::select('beacon_type_id',[''=>'Please Select']+Beacon::typeOptions(),'',['class'=>'form-control select2_class','required','id'=>'modal_beacon_type_id'])}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('hex_no','HEX No *')}}
                {{Form::text('hex_no','',['class'=>'form-control','autofocus','required'])}}
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
  if(!$('#modal_beacon_type_id').val()){ $('#modal_beacon_type_id').select2('open'); return false; }
  if(!$('#{{$TableName}}Form').valid()) return false;
  var data = $('#{{$TableName}}Form').serialize();
  var url_address = $('#{{$TableName}}Form input[name="url"]').val();
  $.post(url_address, data, function(response) {
    if (response.result != 'success') { Swal.fire( 'Error!', response.result, 'error' ); return false; }
    $('#beacon_id').val('').change();
    $('#beacon_id').select2('open');
    $('#{{$TableName}}Modal').modal('hide');
  }, "json");
});
$('#{{$TableName}}Form').validate({
  rules: {
    name:{ required: true, },
    beacon_type_id:{ required: true, },
  },
  messages: {
    name:{ required: "Required", },
  },
  errorPlacement: function(error,element) {
    error.insertAfter(element);
  }
});
</script>
@stop
