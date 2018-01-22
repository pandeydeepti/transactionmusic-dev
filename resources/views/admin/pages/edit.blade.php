@extends('layouts.admin')
@section('content')
            {!! Form::open(['url' => 'admin/pages/update', 'id'=>'update_page']) !!}
    <div class="title-page col-md-12">
        <div class="row">
            {{$page->title}}
            <div class="toggle-checkbox">
                <label class="switch">
                    {{ Form::hidden('active', false) }}
                    {{Form::checkbox('active', true, $page->active, ['id' => 'page-active'])}}
                    <div class="slider round"></div>
                </label>
            </div>
            <span class="loader-wrapper"><i class="fa fa-spinner fa-pulse fa-fw"></i></span>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            @if(isset($page->active) && $page->active==0)
                <div id="opacity-wrapper" class="innactive-affected-row col-md-12 page-main-wrapper box-shadow-default main-div-color">
                    @else
                        <div id="opacity-wrapper" class="col-md-12 page-main-wrapper box-shadow-default main-div-color ">
                            @endif
                <div class="row">
                    <div class="pages-inner-wrapper clearfix">
                        <div class="page-title-order-wrapper clearfix">
                            <div class="col-md-6">
                                <div><label for="page-title">PAGE TITLE</label></div>
                                <input type="text" name="title" placeholder="Title" id="page-title" value="{{$page->title}}">
                            </div>
                            <div class="col-md-4 pull-right">
                                <label for="page-order" class="float-right">PAGE ORDER</label>
                                <input type="number" min="0" name="order" id="page-order" class="float-right" value="{{$page->order}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="category-textarea">
                                <label for="page-description">PAGE DESCRIPTION</label> <br>
                                <textarea name="description" cols="95" rows="9" id="page-description">{{$page->description}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($page->title !='POLICIES / TERMS')
            <input type="hidden" name="id" value="{{$page->id}}">
            @endif
        </div>
    </div>
    {{--<div class="col-md-3">--}}
        {{--<div class="select-page-faq-main-wrapper add-category-main-wrapper">--}}
            {{--<label for="options">PAGE TYPE</label> <br>--}}

            {{--<select name="options" class="page-faq-toggle">--}}
                {{--<option value="page">Page</option>--}}
                {{--<option value="faq">FAQ</option>--}}
            {{--</select>--}}
        {{--</div>--}}
    {{--</div>--}}

    </div>
     @if($page->title !='POLICIES / TERMS')
    <div class="col-md-8">
        <div class="row">
            <div class="btn-save">
                <button class="pull-right" id="page-update">SAVE</button>
            </div>
        </div>
    </div>
     @endif
    {!! Form::close() !!}

@endsection
