@extends('layouts.app')

@section('content')
            <div class="form-signin">
                <h1 class="text-center mt-5">Your shortened URL</h1>

                <div class="input-group mt-5 mb-3">
                    <input id="url" type="text" class="form-control" value="{{$url->short_url}}" disabled/>
                    <div class="input-group-append">
                        <button class="btn btn-primary" onclick="copyText()">Copy URL</button>
                    </div>
                </div>
                <p style="color:green" id="copy-success"></p>
                <p>
                    Long URL : <a target="_blank" href="{{$url->original_url}}">{{$url->original_url}}</a>
                </p>
            </div>

    </div>
@endsection

<script>

    function copyText() {
        /* Get the text field */
        var copyText = document.getElementById("url");

        /* Select the text field */
        copyText.select();

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);
        $("#copy-success").html("URL Copied");
    }
</script>
