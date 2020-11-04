<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RCV | Login</title>
  <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/font-awesome.min.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/animate.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/style.css') }}" />
</head>
<body class="gray-bg">
  <div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
      <div>
        <h1 class="logo-name">RCV</h1>
      </div>
      <h3>Welcome to RCV</h3>
      <p> '' </p>
      <p>Login in. To see it in action.</p>
      <p>
        @foreach($errors->all(':message') as $message)
        <div id="form-messages" class="alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @endforeach()
      </p>
      {{ Form::open(array('url' => '/PasswordReset/'.$user_id, 'method' => 'put', 'class'=>'m-t')) }}
      {{ csrf_field() }}
      <div id="PasswordReset"></div>
      {!! Form::close() !!}
      <p class="m-t"> <small>RCV we app framework base on Bootstrap 3 &copy; 2019</small> </p>
    </div>
  </div>
  <!-- Mainly scripts -->
  <script src="{{ url('public/js/jquery-2.1.1.js')}}"></script>
  <script src="{{ url('public/js/bootstrap.min.js')}}"></script>
  <script src="{{ url('public/js/app.js')}}"></script>
</body>
</html>
