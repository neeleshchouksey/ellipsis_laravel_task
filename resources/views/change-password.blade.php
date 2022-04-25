@extends('layouts.app')

@section('content')
    <div class="content">
        <section>
            <div class="relative">
                @if (session('status'))
                    <div class="success">{{ session('status') }}</div>
                @endif

                @php $error = $errors->getMessages(); @endphp

                @if(isset($error['password']))
                    <div class="alert alert-danger">{{ $error['password'][0] }}</div>
                @endif

                <br>
                <form method="POST" action="{{ route('update-password') }}" class="form-change-pass">
                    @csrf
                    <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt=""
                         width="72"
                         height="72">
                    <h2>Change Password</h2>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputPassword" class="sr-only">Old Password</label>
                                    <input id="password-old" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="old_password"
                                           placeholder="Old Password"
                                           required autocomplete="current-password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputPassword" class="sr-only">New Password</label>
                                    <input id="password-new" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="new_password"
                                           placeholder="New Password"
                                           required autocomplete="current-password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputPassword">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password"
                                           name="confirm_password" required autocomplete="new-password">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <button class="btn btn-primary btn-block mt-4" type="submit">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection
