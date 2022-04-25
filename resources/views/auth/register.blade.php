@extends('layouts.app')

@section('content')
    <div class="content">
        <section>
            <div class="relative">
                @if (session('status'))
                    <div class="success">{{ session('status') }}</div>
                @endif

                @php $error = $errors->getMessages(); @endphp

                @if(isset($error['name']))
                    <div class="alert alert-danger">{{ $error['name'][0] }}</div>
                @elseif(isset($error['email']))
                    <div class="alert alert-danger">{{ $error['email'][0] }}</div>
                @elseif(isset($error['password']))
                    <div class="alert alert-danger">{{ $error['password'][0] }}</div>
                @elseif(isset($error['streetaddress']))
                    <div class="alert alert-danger">{{ $error['streetaddress'][0] }}</div>
                @elseif(isset($error['city']))
                    <div class="alert alert-danger">{{ $error['city'][0] }}</div>
                @elseif(isset($error['state']))
                    <div class="alert alert-danger">{{ $error['state'][0] }}</div>
                @elseif(isset($error['country']))
                    <div class="alert alert-danger">{{ $error['country'][0] }}</div>
                @elseif(isset($error['zipcode']))
                    <div class="alert alert-danger">{{ $error['zipcode'][0] }}</div>
                @endif

                <br>
                <form method="POST" action="{{ route('register') }}" class="form-signup">
                    @csrf
{{--                    <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt=""--}}
{{--                         width="72"--}}
{{--                         height="72">--}}
                    <h2>Registration</h2>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputEmail">Name</label>
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputEmail">Email address</label>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
                                           autofocus
                                           placeholder="Email address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputPassword">Password</label>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           placeholder="Password"
                                           required autocomplete="current-password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputPassword">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <button class="btn btn-primary btn-block mt-4" type="submit">Create Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection
