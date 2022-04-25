@extends('layouts.app')

@section('content')

    <h1 class="text-center mt-5">Please wait while we are redirecting</h1>
    <h3 class="text-center">Loading...</h3>

@endsection

<script>
    setTimeout(function (){
        window.location = '{{$url}}'
    },5000);
</script>
