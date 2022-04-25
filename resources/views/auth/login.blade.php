@extends('layouts.app')

@section('content')

    <form class="form-signin" method="POST" action="{{ route('login') }}">
        @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
        @endif
        <br>
        @csrf
{{--        <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72"--}}
{{--             height="72">--}}
        <h2 class="h3 mb-3 font-weight-normal">Please sign in</h2>
        <div class="form-group">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                   placeholder="Email address">
        </div>
        <div class="form-group">

            <label for="inputPassword" class="sr-only">Password</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password"
                   required autocomplete="current-password">
        </div>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-primary btn-block" type="submit">Sign in</button>
        <p>Forgot your password? <a href="{{ route('password.request') }}">Click Here</a></p>
        <p>Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
    </form>

@endsection
