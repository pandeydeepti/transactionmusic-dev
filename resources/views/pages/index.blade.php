@extends('layouts.main')
@section('content')
    <div class="container">
            <div class="col-md-12">
            </div>
        <div class="page-main-wrapper">
            <div class="title-page"> {{$page->title}}</div>
            <div class="page-single-inner-wrapper">
                {!! $page->description !!}
            </div>
        </div>
        </div>
@endsection