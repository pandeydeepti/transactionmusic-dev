@extends('layouts.admin')
@section('content')
    <div class="title-page col-md-12">
        Banners
    </div>
    <div class="col-md-12 form-main-wrapper">
        <div class="row">
            <form action="/admin/banners" method="post" enctype="multipart/form-data" id="save-banner">
                @if( $banners->isEmpty() )
                    <div class="col-md-5">
                        <div class="banners box-shadow-default main-div-color">
                            <div class="col-md-12">
                                <div class="text-banner">main banner</div>
                                <input type="text" name="name[]" hidden>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <hr>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="url" name="url[]" id="main_url" placeholder="enter URL">

                                <div id="main_banner" class="banner-image">
                                    <input type="file" class="banner-file" name="banner[]" id="main_banner_image" accept="image/x-png, image/jpeg"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 pull-right">
                        <div class="banners box-shadow-default main-div-color">
                            <div class="col-md-12">
                                <div class="text-banner">secondary banner</div>
                                <input type="text" name="name[]" hidden>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <hr>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="url" name="url[]" id="secondary_url" placeholder="enter URL">

                                <div id="secondary_banner" class="banner-image">
                                    <input type="file" class="banner-file" name="banner[]" id="secondary_banner_image" accept="image/x-png, image/jpeg"/>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach($banners as $banner)
                        <div class="col-md-5 @if($loop->iteration % 2 == 0) pull-right @endif">
                            <div class="banners box-shadow-default main-div-color">
                                <i class="fa fa-times banner-delete" href="/admin/banners/delete/{{$banner->id}}" aria-hidden="true"></i>
                                <div class="col-md-12">
                                    <div class="text-banner">{{$banner->name}} banner</div>
                                    <input type="text" name="name[]" value="{{$banner->name}}" hidden>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="url" name="url[]" id="{{$banner->name}}_url" placeholder="enter URL" value="{{$banner->url}}">

                                    <div id="{{$banner->name}}_banner" @if( !empty( $banner->file_path ) ) style="{{$banner->file_path}}"  @endif class="banner-image">
                                        <input type="file" class="banner-file" name="banner[]" id="{{$banner->name}}_banner_image" accept="image/x-png, image/jpeg"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                {{csrf_field()}}

                <div class="col-md-12 btn-save">
                    <button class="pull-right" id="banner-save-btn">SAVE</button>
                </div>
            </form>
        </div>
    </div>

@endsection
