@extends('layouts.main')
@section('content')
    <div class="inner-page-container">
        <div class="faq-main-wrapper clearfix">
            <div class="col-md-12">
                <div class="row">
                    <div class="title-page"> FAQ</div>
                </div>
            </div>
                <div class="single-faq-inner-wrapper">
            @foreach($faqs as $faq)
                    <div class="single-faq-title-wrapper">
                        <i class="fa fa-caret-right" aria-hidden="true"></i> <span>{{$faq->title}}</span>
                        <div class="single-faq-content-wrapper">
                            {!! $faq->description !!}
                        </div>
                    </div>
            @endforeach
                </div>
        </div>
    </div>
@endsection