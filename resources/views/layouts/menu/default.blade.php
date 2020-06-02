<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NULL') }} - @yield('title')</title>
    <link rel="icon" href="{{asset('assets/dist/img/log-icon.png')}}" type="image/gif" sizes="16x16">
    <!-- flahs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- Loading Flat UI Pro -->
    <link href="{{asset('templates/default/css/flat-ui.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('templates/default/style.css')}}">
</head>
<body>

 @yield('content')
</div>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script src="http://vjs.zencdn.net/6.6.3/video.js"></script>

<script src="{{asset('templates/default/scripts/flat-ui.js')}}"></script>
<script>
    function openNav() {
        console.log(document.getElementById("mySidebar").style.width);
        if(document.getElementById("mySidebar").style.width == '0px' || document.getElementById("mySidebar").style.width == 0  ){
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }else{
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
        }
        console.log(document.getElementById("mySidebar").style.width);

    }

    function closeNav() {

    }
</script>
</body>
</html>
