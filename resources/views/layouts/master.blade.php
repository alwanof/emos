<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NULL') }} - @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/dist/img/log-icon.png') }}" type="image/gif" sizes="16x16">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- flahs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.css" />
    <link rel="stylesheet" href="{{ asset('assets/dist/css/style.css') }}">
    @yield('head-js')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('css')
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div id="app" class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <!--
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
-->


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                @include('widgets.notifications')
                @php $locale = session()->get('locale'); @endphp

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-globe"></i>

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">{{ __('master.select-language') }}</span>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('lang', 'en') }}" class="dropdown-item">
                            English
                            <span class="float-right text-muted text-sm">
                                <i class="flag-icon flag-icon-us"></i>
                            </span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('lang', 'tr') }}" class="dropdown-item">
                            Türkiye
                            <span class="float-right text-muted text-sm">
                                <i class="flag-icon flag-icon-tr"></i>
                            </span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('lang', 'fr') }}" class="dropdown-item">
                            Ranska
                            <span class="float-right text-muted text-sm">
                                <i class="flag-icon flag-icon-fr"></i>
                            </span>
                        </a>
                    </div>
                </li>
                @switch($locale)
                    @case('ar')
                    <i class="flag-icon flag-icon-sa"></i>
                    @break
                    @default
                    <i class="flag-icon flag-icon-us"></i>
                @endswitch



            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ Auth::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ route('me') }}" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    {{ __('master.dashboard') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" class="nav-link ">
                                        <i class="fa fa-home nav-icon"></i>
                                        <p>{{ __('master.home') }}</p>
                                    </a>
                                </li>
                                @can('access-users')
                                    <li class="nav-item ">
                                        <a href="{{ route('users') }}" class="nav-link ">
                                            <i class="fa fa-users nav-icon"></i>
                                            <p>{{ __('master.users') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('access_members')
                                    <li class="nav-item ">
                                        <a href="{{ route('members.index') }}" class="nav-link ">
                                            <i class="fa fa-users nav-icon"></i>
                                            <p>{{ __('members.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('access-configs')
                                    <li class="nav-item">
                                        <a href="{{ route('config.index') }}" class="nav-link ">
                                            <i class="fas fa-cogs"></i>
                                            <p>{{ __('master.config') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                <li class="nav-item">
                                    <a href="{{ route('config.settings') }}" class="nav-link ">
                                        <i class="fas fa-cog"></i>
                                        <p>{{ __('master.settings') }}</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @can('access_menu_manager')
                            <li class="nav-item has-treeview menu-open">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-fist-raised"></i>
                                    <p>
                                        {{ __('menu.title') }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('access_tables')
                                        <li class="nav-item">
                                            <a href="{{ route('boards.index') }}" class="nav-link ">
                                                <i class="fas fa-retweet"></i>
                                                {{ __('menu.tables') }}

                                            </a>
                                        </li>
                                    @endcan
                                    @can('access_categories')
                                        <li class="nav-item">
                                            <a href="{{ route('category.index') }}" class="nav-link ">
                                                <i class="fas fa-retweet"></i>
                                                {{ __('menu.categories') }}

                                            </a>
                                        </li>
                                    @endcan
                                    @can('access_items')
                                        <li class="nav-item">
                                            <a href="{{ route('item.index') }}" class="nav-link ">
                                                <i class="fas fa-retweet"></i>
                                                {{ __('menu.items') }}

                                            </a>
                                        </li>
                                    @endcan
                                    @can('access_hooks')
                                        <li class="nav-item">
                                            <a href="{{ route('hooks.index') }}" class="nav-link ">
                                                <i class="fas fa-retweet"></i>
                                                {{ __('menu.hooks') }}

                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('access_orders')
                            <li class="nav-item has-treeview menu-open">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-fist-raised"></i>
                                    <p>
                                        {{ __('orders.order_title') }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('access_right_now')
                                        <li class="nav-item">
                                            <a href="{{ route('order.new') }}" class="nav-link ">
                                                <i class="fas fa-retweet"></i>
                                                {{ __('orders.new_order') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('access_remote_now')
                                        <li class="nav-item">
                                            <a href="{{ route('order.remote') }}" class="nav-link ">
                                                <i class="fas fa-retweet"></i>
                                                {{ __('orders.remote_order') }}
                                                <span class="right badge badge-danger">{{ __('orders.remote') }}</span>

                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('access_operations_room')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('stack.index') }}">
                                    <i class="nav-icon fas fa-retweet"></i>
                                    <p>
                                        {{ __('stack.title') }}
                                    </p>
                                </a>
                            </li>
                        @endcan



                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    {{ __('master.logout') }}
                                    <span class="right badge badge-danger">{{ __('master.goodBye') }}</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('nav')

            </section>

            <!-- Main content -->
            <section class="content">
                @include('alert')
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.0.1
            </div>
            <strong>Copyright &copy; 2020 <a href="https://2uerkey.com">2urkey</a>.</strong> All rights
            reserved.
        </footer>
        <notifications :actor="{{ json_encode(Auth::user()) }}" ></notifications>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>
  <script src="{{asset('assets/plugins/jquery.playSound.js')}}"></script>
    @yield('js')
     <script>
            // request permission on page load
        document.addEventListener('DOMContentLoaded', function() {
         if (!Notification) {
          alert('Desktop notifications not available in your browser. Try Chromium.');
          return;
         }

         if (Notification.permission !== 'granted')
          Notification.requestPermission();
        });
        </script>

</body>

</html>
