<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Url Shortner</title>
    <meta name="description" content="Cymatrax offers audio processing...">
    <meta name="keywords" content="Audio Processing, Audio Equalization">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <link rel="icon" type="image/png" href="{{URL::to('/')}}/assets/images/favicon.png">--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/417999d16a.js"></script>

    <link href="{{URL::to('/')}}/assets/css/index.css" rel="stylesheet"/>
    <script>
        var APP_URL = '{{URL::to("/")}}';
        var CSRF_TOKEN = '{{csrf_token()}}'
    </script>

    <style>
        #overlay {
            position: fixed;
            z-index: 99999;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.9);
            transition: 1s 0.4s;
        }

        #overlay > img {
            position: absolute;
            top: 35%;
            left: 45%;
        }
    </style>

</head>
<body>

<header>

    <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
        <ul class="navbar-nav">
            @if(Auth::user())

                <li class="nav-item active">
                    <a class="nav-link" href="{{URL::to('/')}}/dashboard">Dashboard</a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="{{URL::to('/')}}/profile">Profile</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="{{URL::to('/')}}/change-password">Change Password</a>--}}
{{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            @else
                <li class="nav-item"><a class="nav-link" href="{{URL::to('/')}}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{URL::to('/')}}/login">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{URL::to('/')}}/register">Registration</a></li>
            @endif
        </ul>
    </nav>

    <div id="app">
        {{--    <div id="overlay">--}}
        {{--        <img src="{{asset('assets/images/loader.gif')}}" alt="Loading" />--}}
        {{--    </div>--}}
        @yield('content')
    </div>
    <footer>
        {{--    <p>Copyright © 2020 All rights reserved</p>--}}
    </footer>

</body>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script src="{{ asset('public/js/component.js') }}"></script>
<!-- sweet aleart -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11 -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>

@if(session()->has('message'))

    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session()->get('message') }}",
            icon: 'success',
            showCancelButton: false,
        });
    </script>
@endif

<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if (exist) {

        Swal.fire({
            title: 'Thank You',
            text: msg,
            icon: 'success',
            showCancelButton: false,
        });
    }
    var msg1 = '{{Session::get('error')}}';
    var exist1 = '{{Session::has('error')}}';
    if (exist1) {
        Swal.fire({
            title: 'Error!',
            text: msg1,
            icon: 'error',
            showCancelButton: false,
        });
    }

    var msg2 = "{!! Session::get('success') !!}";
    var exist2 = '{{Session::has('success')}}';
    if (exist2) {
        Swal.fire({
            title: 'Success',
            text: msg2,
            icon: 'success',
            showCancelButton: false,
        });
    }
</script>

</html>
