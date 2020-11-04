<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template | 500 Error</title>
    <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url('public/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ url('public/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ url('public/css/style.css') }}" />
</head>
<body class="gray-bg">
    <div class="middle-box text-center animated fadeInDown">
        <h1>500</h1>
        <h3 class="font-bold">Internal Server Error</h3>
        <div class="error-desc">
            The server encountered something unexpected that didn't allow it to complete the request. We apologize.<br/>
            You can go back to main page: <br/><a href="{{url('/')}}" class="btn btn-primary m-t">Dashboard</a>
        </div>
    </div>
  <script src="{{ url('public/js/jquery-3.3.1.js')}}"></script>
  <script src="{{ url('public/js/bootstrap.min.js')}}"></script>
</body>
</html>
