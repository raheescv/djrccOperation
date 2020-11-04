<!doctype html>
<html class="fixed">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>INSPINIA | Register</title>
	<link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/css/font-awesome.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/css/custom.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/css/animate.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/css/style.min.css') }}" />
	@toastr_css
</head>
<body class="gray-bg">
	<div class="middle-box text-center loginscreen   animated fadeInDown">
		<div>
			<div>
				<h1 class="logo-name">RCV</h1>
			</div>
			<h3>Register to RCV</h3>
			<p>
				Perfectly designed and precisely prepared admin theme
			</p>
			<p>Create account to see it in action.</p>
			<form class="m-t" method="POST" id="registerForm" action="{{ route('Register') }}">
				{{ csrf_field() }}
				@foreach($errors->all(':message') as $message)
				<div id="form-messages" class="alert alert-danger" role="alert">
					{{ $message }}
				</div>
				@endforeach()
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}  mb-lg">
					<label>Name</label>
					<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus />
				</div>
				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} mb-lg">
					<label>E-mail Address</label>
					<input name="email" type="email" class="form-control" value="{{ old('email') }}" required />
				</div>
				<button type="submit" class="btn btn-primary block full-width m-b">Register</button>
				<p class="text-muted text-center"><small>Already have an account?</small></p>
				<a class="btn btn-sm btn-white btn-block" href="{{ url('SignIn') }}">Login</a>
			</form>
		</div>
	</div>
	<script src="{{ asset('public/js/jquery-2.1.1.js')}}"></script>
	<script src="{{ asset('public/js/bootstrap.min.js')}}"></script>
	<script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
	@toastr_js
	<script>
	$('#registerForm').validate({
		rules: {
			name: "required",
			email:{
				required: true,
				remote: {
					url: "{{ route('check_email_exists')}}",
					type: "post",
					data: {
						email: function() {
							return $('#registerForm input[name="email"]').val();
						},
						'register': true,
						'_token': "{{ csrf_token() }}"
					}
				}
			},
		},
		messages: {
			email:{
				required: "Email Required",
				email: "Please enter a valid email address",
				remote: "{{ route('check_email_exists')}}"
			},
		},
		errorPlacement: function(error,element) {
			console.log(element.attr("name"));
			if (element.attr("name") == "email") {
				error.insertAfter(element);
			} else {
				return true;
			}
		}
	});
	</script>
	@toastr_render
</body>
</html>
