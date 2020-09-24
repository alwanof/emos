<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'NULL') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <style>
        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }

    </style>
</head>

<body>

    <div class="container p-5" id="app">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="{{ $actor->avatar }}" height="40" alt="">
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-12">
                                <span class="font-weight-bold">#</span>{{ Str::substr($orderID, 0, 6) }}
                                <hr>
                            </div>
                            <div class="col"><span class="font-weight-bold">Date:</span> {{ Date('d-M-Y') }}</div>
                            <div class="col"><span class="font-weight-bold">Time:</span> {{ Date('H:i:s') }}</div>
                        </div>
                        <invoice-print :lang={{ json_encode(app()->getLocale()) }}
                            :auth="{{ json_encode(Auth::user()) }}" :orderid="{{ json_encode($orderID) }}"
                            puretotal="{{ json_encode($pureTotal) }}" :actor="{{ json_encode($actor) }}">
                        </invoice-print>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" onclick="window.print();return false;" class="btn btn-danger mx-1 no-print">
                            <i class="fas fa-print"></i> Print
                        </a>
                        <div>
                            <small> Thanks for visiting {{ $actor->name }}, {{ $actor->email }}</small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function printpage() {
            //Get the print button and put it into a variable
            var printButton = document.getElementById("pr");
            // var printButtonk = document.getElementById("prK");
            //Set the print button visibility to 'hidden'
            // printButton.style.visibility = 'hidden';
            // printButtonk.style.visibility = 'hidden';
            document.title = "";
            document.URL = "";

            //Print the page content
            window.print()
            //Set the print button to 'visible' again
            //[Delete this line if you want it to stay hidden after printing]
            printButton.style.visibility = 'visible';
            // printButtonk.style.visibility = 'visible';


        }

    </script>
</body>

</html>
