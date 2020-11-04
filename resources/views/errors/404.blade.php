<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Template | 404 Error</title>
  <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/font-awesome.min.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/animate.css') }}" />
  <link rel="stylesheet" href="{{ url('public/css/style.css') }}" />
</head>
<body class="gray-bg">
  <div class="middle-box text-center animated fadeInDown">
    <h1>404</h1>
    <h3 class="font-bold">Page Not Found</h3>
    <div class="error-desc">
      Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.
      <form class="form-inline m-t" role="form">
        <a href="{{url('/')}}" class="btn btn-primary">DashBoard</a>
      </form>
    </div>
  </div>
  <script src="{{ url('public/js/jquery-3.3.1.js')}}"></script>
  <script src="{{ url('public/js/bootstrap.min.js')}}"></script>
</body>
</html>
