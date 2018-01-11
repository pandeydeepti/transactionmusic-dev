@extends('layouts.admin')
@section('content')
    <div class="title-page col-md-12">
        <div class="row">Embed</div>
    </div>

    <div class="col-md-12 main-div-color">
        <div class="embed-main-wrapper">
            <label for="">EMBED SIZE</label>
            <hr>
            <form action="/admin/embed" method="post" id="embed-update">
                {{csrf_field()}}
                <div class="embed-inner-wrapper">
                    <div class="clearfix">
                        <div class="col-md-2 no-left-padding">
                            <label for="embed_width">WIDTH</label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="width" id="embed_width" value="@if(!empty($embed_width)){{$embed_width}}@endif">
                        </div>
                    </div>
                    <div>
                        <div class="clearfix">

                            <div class="col-md-2 no-left-padding">
                                <label for="embed_height">HEIGHT</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="height" id="embed_height" value="@if(!empty($embed_height)){{$embed_height}}@endif">
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="embed-code-wrapper">
                <label for="embed-code">YOUR EMBED CODE</label>
                <textarea name="embed-code" id="embed-code" cols="50" rows="10"></textarea>
            </div>

        </div>
    </div>
    <div class="col-md-12 no-padding"> <button id="save-embed" class="pull-right">SAVE</button></div>

@endsection
