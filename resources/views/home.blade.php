@extends('layouts.app')

@section('content')

    <h1 class="text-center mt-3">Short URL</h1>
    <form class="form-signin" method="POST" action="{{ route('short-url') }}">
        @error('url')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        @csrf
        <h2 class="h3 mb-3 font-weight-normal">Paste the URL to be shortened</h2>
        <div class="form-group">
            <input id="url" type="text" class="form-control @error('email') is-invalid @enderror"
                   name="url" value="{{ old('url') }}" required autocomplete="url" autofocus
                   placeholder="Enter Url">
        </div>
        <button class="btn btn-primary btn-block mt-3" type="submit">Short URL</button>
    </form>

@endsection
