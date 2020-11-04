<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DJRCC | Login</title>
  <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/font-awesome.min.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/animate.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/style.css') }}" />
  @toastr_css
</head>
<body class="gray-bg">
  <div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
      <div>
        <h1 class="logo-name"><img src="{{url('public/image/djrcc.jpeg')}}" alt=""></h1>
      </div>
      <h3>Welcome to DJRCC</h3>
      <p>Login in. To see it in action.</p>
      <p>
        @foreach($errors->all(':message') as $message)
        <div id="form-messages" class="alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @endforeach()
      </p>
      <form class="m-t" method="POST" role="form" action="{{ route('Login') }}">
        {{ csrf_field() }}
        <div id="signIn"></div>
        <!-- <a data-target="#ForgotPassword_Modal" data-toggle="modal"><small>Forgot password?</small></a> -->
        <!-- <a class="btn btn-sm btn-white btn-block" href="{{ route('SignUp') }}">Create an account</a> -->
      </form>
      <p class="m-t"> <small>Astra we app framework base on Bootstrap 3 &copy; 2020</small> </p>
    </div>
  </div>
  <div id="ForgotPassword_Modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <h3 class="m-t-none m-b">Forgot Password</h3>
              {!! Form::open(array('url' => 'ForgotPasswordMail','id'=>'ForgotPasswordForm','class'=>'form','method'=>'post')); !!}
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Email</label>
                  {{Form::text('email','',['class'=>'form-control','placeholder'=>'Enter Message To Send','autofocus','required'])}}
                </div>
              </div>
              <div class="col-sm-12">
                <button type="submit" id="ForgotPasswordMailButton" class="btn btn-primary btn-sm btn-block"><i class="fa fa-mail"></i>Send Mail</button>
              </div>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ url('public/js/jquery-2.1.1.js')}}"></script>
  <script src="{{ url('public/js/bootstrap.min.js')}}"></script>
  <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
  <script src="{{ url('public/js/app.js')}}"></script>
  @toastr_js
  <script>
  $('#ForgotPasswordForm').validate({
    rules: {
      email:{
        required: true,
        remote: {
          url: "{{ route('check_email_exists')}}",
          type: "post",
          data: {
            email: function() {
              return $('#ForgotPasswordForm input[name="email"]').val();
            },
            'lostpassword': true,
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
