<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NULL') }} - @yield('title')</title>
    <link rel="icon" href="{{asset('assets/dist/img/log-icon.png')}}" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <!-- flahs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.css" />
    <link rel="stylesheet" href="{{asset('assets/dist/css/front.css')}}">

    @yield('css')
</head>

<body>
<center>
    <!-- GTranslate: https://gtranslate.io/ -->


    <style type="text/css">
        <!--
        a.gflag {vertical-align:middle;font-size:16px;padding:1px 0;background-repeat:no-repeat;background-image:url(//gtranslate.net/flags/16.png);}
        a.gflag img {border:0;}
        a.gflag:hover {background-image:url(//gtranslate.net/flags/16a.png);}
        #goog-gt-tt {display:none !important;}
        .goog-te-banner-frame {display:none !important;}
        .goog-te-menu-value:hover {text-decoration:none !important;}
        body {top:0 !important;}
        #google_translate_element2 {display:none!important;}
        -->
    </style>

    <div id="google_translate_element2"></div>
    <script type="text/javascript">
        function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'tr',autoDisplay: false}, 'google_translate_element2');}
    </script><script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>


    <script type="text/javascript">
        /* <![CDATA[ */
        eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',43,43,'||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'),0,{}))
        /* ]]> */
    </script>
</center>


<div id="app" >
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    @yield('sidenav')

</div>
<!-- Use any element to open the sidenav -->


<i id="toggler" class="fas fa-bars fa-2x text-danger m-2" onclick="openNav()"></i>


<div id="main">

    <div class="container text-center mb-5">
        <div class="row">
            <div class="col-sm-12" >

                @yield('cover')

                <div class="h2 mt-2">
                    <a href="#" onclick="doGTranslate('tr|tr');return false;"><i class="flag-icon flag-icon-tr m-1"></i></i></a>
                    <a href="#" onclick="doGTranslate('tr|en');return false;"><i class="flag-icon flag-icon-us m-1"></i></a>
                    <a href="#" onclick="doGTranslate('tr|ar');return false;"><i class="flag-icon flag-icon-sa m-1"></i></a>
                    <a href="#" onclick="doGTranslate('tr|fr');return false;"><i class="flag-icon flag-icon-fr m-1"></i></i></a>
                    <a href="#" onclick="doGTranslate('tr|ru');return false;"><i class="flag-icon flag-icon-ru m-1"></i></i></a>
                    <a href="#" onclick="doGTranslate('tr|sv');return false;"><i class="flag-icon flag-icon-se m-1"></i></i></a>
                    <a href="#" onclick="doGTranslate('tr|fa');return false;"><i class="flag-icon flag-icon-ir m-1"></i></i></a>
                    <a href="#" onclick="doGTranslate('tr|am');return false;"><i class="flag-icon flag-icon-et m-1"></i></i></a>
                    <a href="#" onclick="doGTranslate('tr|zh-CN');return false;"><i class="flag-icon flag-icon-cn m-1"></i></i></a>
                    <a href="#" onclick="doGTranslate('tr|ur');return false;"><i class="pb-2"><img src="{{asset('assets/dist/img/ur.png')}}" height="28"></i></a>

                </div>
                <div class="progress my-2">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>

                </div>
            </div>
        </div>
        @yield('content')

    </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="{{ asset('js/app.js') }}" ></script>
<script src="{{asset('assets/dist/js/front.js')}}"></script>
@yield('js')


</body>

</html>

