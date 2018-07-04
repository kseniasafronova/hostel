<!DOCTYPE html>
<html lang="en">
<head>
    @section('meta')
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @show
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/font-awesome.css') }}">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                @include('_booking')
            </div>
            <div class="col-lg-9 col-md-8 col-sm-6">
                @yield('content')
            </div>
        </div>
        <div id="calendar" style="visibility: hidden;">
            @include('_calendar')
        </div>
    </div>

    @section('scripts')
        <script src="{{ URL::asset('js/jquery.js') }}"></script>
        <script src="{{ URL::asset('js/main.js') }}"></script>
    @show
   
</body>
</html>

