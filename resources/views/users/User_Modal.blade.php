<div id="User_Modal" class="modal fade" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="m-t" method="POST" id="User-Form" action="{{ route('AddUser') }}">
				{{ csrf_field() }}
				<div class="modal-header">
					<h4>User Form</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									@foreach($errors->all(':message') as $message)
									<div id="form-messages" class="alert alert-danger" role="alert">
										{{ $message }}
									</div>
									@endforeach()
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}  mb-lg">
										<label>Name</label>
										<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus />
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} mb-lg">
										<label>E-mail Address</label>
										<input name="email" type="email" class="form-control" value="{{ old('email') }}" required />
									</div>
								</div>
								<div class="col-md-4">
									{{Form::label('user_type_id','User Type')}}
									{{Form::select('user_type_id',$UserTypes,'',['id'=>'user_type_id','class'=>'form-control select2_class','style'=>'width:100%'])}}
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}  mb-lg">
										<label>FirstName</label>
										<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} mb-lg">
										<label>Last Name</label>
										<input name="last_name" type="text" class="form-control" value="{{ old('first_name') }}" placeholder="Last Name" />
									</div>
								</div>
								<div class="col-md-4" hidden>
									<div class="form-group{{ $errors->has('web_site') ? ' has-error' : '' }} mb-lg" >
										<label>Web Site</label>
										<input name="web_site" type="text" class="form-control" value="{{ old('web_site') }}" placeholder="Web Site"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} mb-none">
										<div class="row">
											<div class="col-sm-6">
												<label>Password</label>
												<input name="password" type="password" class="form-control input-lg" />
											</div>
											<div class="col-sm-6">
												<label>Password Confirmation</label>
												<input name="password_confirm" type="password" class="form-control input-lg" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary block full-width m-b">Save</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
