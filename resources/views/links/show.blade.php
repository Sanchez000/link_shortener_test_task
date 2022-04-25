@extends('links.layout')
  
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Generated Link Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('links.create') }}"> Back</a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
                <div class="form-group col-xs-6 col-sm-6 col-md-6" id="short_code">
                    <strong>Short Url:</strong>
                    {{ $link->fullShortUrl }}
                </div>
                <div class="form-group col-xs-6 col-sm-6 col-md-6" >
                    <button onclick="copyLink()">Copy to clipboard</button>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Original Url:</strong>
                {{ $link->original_url }}
            </div>
        </div>
    </div>
@endsection
<script>
    function copyLink() {
        let shortUrlElement = document.getElementById("short_code").innerText;
        let re = /Short Url: /gi;
        let onlyLink = shortUrlElement.replace(re, '');
        navigator.clipboard.writeText(onlyLink);
    }
</script>