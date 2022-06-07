<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>
    <link rel="shortcut icon" href="{{asset('img/logo.ico')}}" type="image/x-icon" />
    <link href="{{asset('css/style.css')}}" rel="stylesheet" />
</head>
<body>
    @yield('content')
</body>
<script src="{{asset('js/app.js')}}"></script>
@yield('scripts')
</html>
