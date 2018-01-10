@extends('layouts.admin')
@section('content')

    <div class="title-page col-md-12">
        Shop Options
    </div>
    {!! Form::open(['url' => 'admin/shop_options/create', 'id' => 'shop_option_save', 'files' => true]) !!}
    <div class="col-md-6">
        <div class="shop-color-main-wrapper box-shadow-default">

            <div class="col-md-12 no-right-padding">
                <label for="colors">COLORS</label>

                <button data-reset-fields="main_color,secondary_color,third_color,fourth_color,text_color" type="button" href="/admin/shop_options/resetfields" class="default-options float-right">RESET DEFAULT COLORS</button>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <hr>
                </div>
            </div>
            <div class="col-md-7">
                <div class="shop-color-inner-wrapper">
                    <div class="row">
                        <div class="col-md-10">
                            <label for="main_color">MAIN COLOR</label>
                        </div>
                        <div class="col-md-2">
                            <div class="row"><input type="text" id="main_color" name="main_color"
                                                    class="shop_colorpicker input-focus-border-none"
                                                    value="@if(!empty($shop->main_color)){{$shop->main_color}} @endif"
                                                    style="background-color: {{$shop->main_color}}"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <label for="secondary_color">SECONDARY COLOR</label>
                        </div>
                        <div class="col-md-2">
                            <div class="row"><input type="text" id="secondary_color" name="secondary_color"
                                                    class="shop_colorpicker input-focus-border-none"
                                                    value="@if(!empty($shop->secondary_color)){{$shop->secondary_color}} @endif"
                                                    style="background-color: {{$shop->secondary_color}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <label for="third_color">THIRD COLOR</label>
                        </div>
                        <div class="col-md-2">
                            <div class="row"><input type="text" id="third_color" name="third_color"
                                                    class="shop_colorpicker input-focus-border-none"
                                                    value="@if(!empty($shop->third_color)){{$shop->third_color}} @endif"
                                                    style="background-color: {{$shop->third_color}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <label for="third_color">FOURTH COLOR</label>
                        </div>
                        <div class="col-md-2">
                            <div class="row"><input type="text" id="fourth_color" name="fourth_color"
                                                    class="shop_colorpicker input-focus-border-none"
                                                    value="@if(!empty($shop->fourth_color)){{$shop->fourth_color}} @endif"
                                                    style="background-color: {{$shop->fourth_color}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <label for="third_color">TEXT COLOR</label>
                        </div>
                        <div class="col-md-2">
                            <div class="row"><input type="text" id="text_color" name="text_color"
                                                    class="shop_colorpicker input-focus-border-none"
                                                    value="@if(!empty($shop->text_color)){{$shop->text_color}} @endif"
                                                    style="background-color: {{$shop->text_color}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="color-preview-container"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="shop-logo-inner-wrapper box-shadow-default main-div-color">
            <div class="col-md-12">
                <label for="logo">LOGO</label>
            </div>
            <div id="shop_logo"
                 @if(!empty($shop->logo_path)) style="background-image: url('{{$shop->logo_path}}') @endif">
                <input type="file" name="logo_path" id="image-upload" accept="image/x-png, image/jpeg"/>

            </div>
        </div>
        <div class="box-shadow-default main-div-color shop-country-wrap">
                <h4>COUNTRY</h4>

                <select name="country" style="width: 100%">
                    @if(!empty($countries))
                        @foreach($countries as &$country)
                            @if(@$shop->country == $country['id'])
                                <option value="{{$country['id']}}" selected>{{$country['text']}}</option>
                            @else
                                <option value="{{$country['id']}}">{{$country['text']}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>

        </div>
    </div>

    <div class="col-md-9">
        <div class="shop-email-content-wrapper main-div-color clearfix box-shadow-default">
            <div class="col-md-12">
                <label for="">MAIL TEXT</label>
                <button data-reset-fields="email_content" type="button" href="/admin/shop_options/resetfields" class="default-options float-right">RESET DEFAULT TEXT</button>
                <hr>
                <textarea name="email_content" id="email_content" cols="30"
                          rows="10">@if(isset($shop->email_content)){!! $shop->email_content !!} @endif</textarea>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="shop-thank-you-content-wrapper main-div-color clearfix box-shadow-default">
            <div class="col-md-12">
                <label for="">THANK YOU PAGE</label>
                <button data-reset-fields="thank_you_page"  type="button" href="/admin/shop_options/resetfields" class="default-options float-right">RESET DEFAULT TEXT</button>
                <hr>
                <textarea name="thank_you_page" id="thank_you_page" cols="30"
                          rows="10">@if(isset($shop->thank_you_page)){!! $shop->thank_you_page !!} @endif</textarea>
            </div>
        </div>
    </div>
    <div class="col-md-9">

        <div class="col-md-6 no-left-padding">
            <div class="shop-paypal-inner-wrapper main-div-color clearfix box-shadow-default">
                <div class="col-md-12">
                    <label for="paypal_email">PAYMENT EMAIL (PAY PAL)</label>

                    <div class="row">
                        <hr>
                        <div class="col-md-12">
                            <div class="paypall-input-inner-wrapper">
                                <input type="email" class="" name="paypal_email" id="paypal_email"
                                       placeholder="enter pay pal email"
                                       value="@if(!empty($shop->paypal_email)){{$shop->paypal_email}}@endif">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-3 pull-right">
            <div class="row">
                <div class="shop-beat-logo-inner-wrapper box-shadow-default main-div-color clearfix">
                    <div class="col-md-10  col-md-offset-1">
                        <label for="logo">BEAT DEFAULT THUMBNAIL</label>
                    </div>
                    <div class="col-md-10 col-md-offset-1">
                        <div data-has-image="@if( !empty($shop->beat_thumbnail_path) ){{ 'true' }}@else{{'false'}}@endif" id="shop_beat_logo" @if(!empty($shop->beat_thumbnail_path)) style="background-image: url('{{$shop->beat_thumbnail_path}}') @endif">
                            <input type="file" name="beat_thumbnail_path" id="image-upload-beat-logo" accept="image/x-png, image/jpeg"/>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-9">
        <div class="col-md-6 no-left-padding">
            <div class="shop-paypal-inner-wrapper main-div-color clearfix box-shadow-default">
                <div class="col-md-12">
                    <label for="paypal_email">ACCOUNT INFORMATION</label>
                    <div class="row">
                        <hr>
                        <div class="col-md-12">
                            <div class="master-input-mail-inner-wrapper">
                                <label for="">EMAIL</label>
                                <input type="email" id="master_email" name="master_email"
                                       placeholder="enter master email"
                                       value="@if(!empty($acc_info->email) ){{$acc_info->email}}@endif">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="master-input-mail-inner-wrapper">
                                <label for="">PASSWORD</label>
                                <input type="password" id="master_password" name="master_password" value="@if(!empty($acc_info->password) ){{$acc_info->password}}@endif">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 pull-right">
            <div class="row">
                <div class="shop-beat-logo-inner-wrapper box-shadow-default main-div-color clearfix">
                    <div class="col-md-10  col-md-offset-1">
                        <label for="logo">CATEGORY THUMBNAIL</label>
                    </div>
                    <div class="col-md-10 col-md-offset-1">
                        <div data-has-image="@if( !empty($shop->category_thumbnail_path)) ){{ 'true' }}@else{{'false'}}@endif" id="shop_category_logo" class="preview_div_style" @if(!empty($shop->category_thumbnail_path)) style="background-image: url('{{$shop->category_thumbnail_path}}') @endif">
                            <input type="file" name="category_thumbnail_path" id="image-upload-category-logo" accept="image/x-png, image/jpeg"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-9">
        <div class="col-md-6 no-left-padding">
            <div class="shop-paypal-inner-wrapper main-div-color clearfix box-shadow-default">
                <div class="col-md-12">
                    <label for="google_analytics">GOOGLE ANALYTICS</label>
                    <div class="row">
                        <hr>
                        <div class="col-md-12">
                            <textarea name="google_analytics" id="" cols="15" rows="4">{{@$shop->google_analytics}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 no-right-padding">
            <div class="shop-paypal-inner-wrapper main-div-color clearfix box-shadow-default">
                <div class="col-md-12">
                    <label for="paypal_email">WEBSITE NAME</label>

                    <div class="row">
                        <hr>
                        <div class="col-md-12">
                            <div class="paypall-input-inner-wrapper">
                                <input type="text" class="" name="sub_name" id="sub_name"
                                       placeholder="enter website name"
                                       value="{{env('APP_NAME')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-9">
        <div class="col-md-4 btn-save no-right-padding pull-right">
            <div class="relative-shop-button">
                <button id="shop_save_btn">SAVE</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection