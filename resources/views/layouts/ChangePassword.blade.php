<div id="change_password_modal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <h3 class="m-t-none m-b">Change Password</h3>
            {!! Form::open(array('url' => '/UpdateUserPassword/','class'=>'form','method'=>'post')); !!}
            <div class="col-sm-12">
              <div class="form-group">
                <label>Current Password</label>
                {{Form::password('old_password',['class'=>'form-control','placeholder'=>'Enter Current Password','autofocus','required'])}}
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>New Password</label>
                {{Form::password('password',['class'=>'form-control','placeholder'=>'Enter New Password','required'])}}
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Confirm Password</label>
                {{Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Confirm Password','required'])}}
              </div>
            </div>
            <div class="col-sm-12">
              <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-pencil"></i>Edit User</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
