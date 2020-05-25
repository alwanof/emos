<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'NULL') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

</head>
<body>

<div class="container p-5">
   <div class="row justify-content-center">
       <div class="col-lg-6">
           <div class="card">
               <div class="card-header bg-danger h2 ">
                   <img src="{{asset('assets/dist/img/logo-header.png')}}" height="40" alt="">
                   <span class="badge badge-dark float-right">{{$board->name}}</span>
               </div>
               <div class="card-body p-3">
                   <p class="lead text-center"><i class="fas fa-quote-left text-danger mx-1"></i>
                       {{__('menu.qrmsgtop')}}
                       <i class="fas fa-quote-right text-danger mx-1"></i></p>
                   <p class="text-center">
                       {!! $board->printQrcode !!}
                   </p>
                   <p class="lead text-center">
                       {{__('menu.qrmsgbot')}}
                   </p>
               </div>
               <div class="card-footer text-center">
                   <a href="#" class="btn btn-danger mx-1">
                       <i class="fab fa-apple"></i> App Store
                   </a>
                   <a href="#" class="btn btn-danger mx-1">
                       <i class="fab fa-android"></i> Google Play
                   </a>
               </div>
           </div>
       </div>
   </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
