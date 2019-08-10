<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @laravelPWA
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}


    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        *{
            box-sizing: border-box;
            margin: 0;
        }
        .navmenu{
            position: fixed;
            left: 15px;
            z-index: 100;
            width: 100px;
            bottom: 30%
        }
        .navmenu a{
            width: 100%;
            float: left;
            padding: 10px 12px;
            background: #fff;
            text-align: center;
            font-size: 14px;
            margin-top: 2px;
            border-radius: 30px;
            border-top-left-radius: 0px;
            color: #ffa900
        }
        .navmenu a:hover,.navmenu .active{
            text-decoration: none;
            color: 	#ff0000;
            animation: jello 1s;
        }
        .navmenu a i{
            font-size: 20px;
        }
        .bg-img{
            background-size: cover;
            z-index: 0;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            opacity: .1;
            background-attachment: fixed;
            background-size: cover;
        }
        @media (max-width:600px){
            .navmenu {
                background: #fff
            }
            .navmenu a{
                width: 25%;
                padding: 16px 0;
            }
            .navmenu a span{
                display: none
            }
            .navmenu{
                position: fixed;
                z-index: 100;
                width: 100%;
                bottom: 0;
                left: 0;
            }
            .btn-logout{
                display: none
            }
        }

        .datepicker{z-index:1151;}

    </style>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.css">   

     <style>
     a{
         color: #262A2D
     }
     .produk{
         color: black;
         transition: .5s;
         border-radius: 30px;
         background: #fff;
         /* cursor: pointer; */
         animation: bounceIn 1s;
         font-size: 12px
     }
     .produk:hover{
         box-shadow: 2px 10px 20px #ccc;
         transform: translateY(-10px);
         transition: .5s;
     }
     .btn-circle{
         border-radius: 30px;
     }
     .btn-topleft{
         border-radius: 30px;
         border-top-left-radius: 0px;
     }
     .btn-edit{
        background: #fff;
        color: #ff0000;
     }
     .produk:hover .btn-edit{
         animation: zoomIn 1s;
         transition: 1s;
     }
     </style>
    @yield("css-after")

</head>
<body>
    <img src="/login.png" class="bg-img" alt="bg">
    <div id="app">
        <nav class="navmenu">
                    @if(Auth::user())
                        <a class="@if(Request::is('/home')) active  @endif)" href="/home">
                            <img width="30px"  src="/logo.png" alt="Logo"><br>
                            <span>Evordigi</span>
                        </a>
                        <a class="@if(Request::is('jasa')) active  @endif)" href="/jasa">
                            <i class="fa fa-th-list"></i><br>
                            <span>Jasa</span>
                        </a>
                        <a class="@if(Request::is('booking')) active  @endif)" href="/booking">
                            <i class="fa fa-fire"></i><br>
                            <span>Booking</span>
                        </a>
                        <a class="@if(Request::is('profile')) active  @endif)" href="#" >
                                <i class="fa fa-user"></i><br>
                                <span>{{ Auth::user()->name }}</span>
                        </a>
                        {{-- Logout --}}
                        <a class="btn-logout" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-arrow-right"></i><br>
                                <span>{{ __('Logout') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                    <a href="/">
                        <img width="30px" src="/logo.png" alt="Logo">
                    </a>
                    <a href="{{ route('login') }}">
                        <i class="fa fa-arrow-right"></i><br>
                            <span>{{ __('Login') }}</span>
                    </a>
                    @endif
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
        <br>
        <br>
        <br>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
 
    @yield('js-after')

</body>
</html>
