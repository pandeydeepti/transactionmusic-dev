<div class="footer-main-wrapper">
    <div class="footer-link-wrapper">
        <div class="container">
            <ul>
                <div class="col-xs-4 footer-list-items ">
                    <a href="{{url('/faq')}}">
                        <li>FAQ</li>
                    </a>
                </div>
                @if( !empty($terms_policies) )
                    <div class="col-xs-4 footer-list-items ">
                        <a href="{{url('/').'/'.$terms_policies->slug}}">
                            <li>TERMS / POLICIES</li>
                        </a>
                    </div>
                @endif
                <div class="col-xs-4 footer-list-items ">
                    <a href="{{url('/contact')}}">
                        <li>CONTACT US</li>
                    </a>
                </div>
            </ul>
        </div>
    </div>

    <div class="footer-inner-wrapper clearfix">
        <div class="container">
            <div class="footer-bottom-container clearfix">
                <div class="col-xs-9">
                    <span>Copyrights &copy; 2017 TransactionMusic.com is designed and maintained by</span>
                    <a href="http://elwci.com/" target="_blank"><img src="images/elwc1.gif" alt="elwc_logo"></a>
                </div>
                <div class="col-xs-3 pay-pal-content">
                    <img src="/images/paypal.png" class="footer-paypal-logo float-right" alt="paypal_logo">
                </div>
            </div>
        </div>
    </div>
</div>

@if(!empty($google_analytics))
    {!! $google_analytics !!}
@endif
{{--{{Html::script('plugins/jquery-uploadpreview/jquery.uploadPreview.js')}}--}}
{{--{{Html::script('components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js')}}--}}
{{--{{Html::script('plugins/jquery-ajax-form/jquery-ajax-form.js')}}--}}
{{--{{Html::script('plugins/jquery-upload-audio/js/jquery.uploadfile.js')}}--}}
{{--{{Html::script('plugins/data-tables/jquery.dataTables.min.js')}}--}}
{{--{{Html::script('components/alertify.js/lib/alertify.min.js')}}--}}
{{--{{Html::script('components/tinymce/tinymce.min.js')}}--}}
{{--{{Html::script('js/front-main.js')}}--}}
{{--{{Html::script('js/app.js')}}--}}

{{Html::script('components/alertify.js/lib/alertify.js')}}
{{Html::script('components/jquery/dist/jquery.js')}}
{{Html::script('components/angular/angular.min.js')}}
{{Html::script('components/angular-soundmanager2/dist/angular-soundmanager2.js')}}
{{Html::script('js/angular.js')}}
{{Html::script('components/angular-rateit/dist/ng-rateit.js')}}
{{Html::script('components/jquery-slimscroll/jquery.slimscroll.js')}}

{{Html::script('plugins/chosen/chosen.jquery.js')}}
{{Html::script('components/angular-chosen-localytics/dist/angular-chosen.js')}}
{{Html::script('plugins/featherlight-1.5.0/release/featherlight.min.js')}}
{{Html::script('js/front-main.js')}}