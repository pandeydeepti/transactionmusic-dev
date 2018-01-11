@extends('layouts.admin')
@section('content')
    <div class="title-page col-md-12 col-xs-12">
        Add Page
    </div>
    <div class="col-md-9">
        <div class="row">
            {!! Form::open(['url' => 'admin/pages', 'id'=>'add_page']) !!}
            <input type="hidden" name="type">
            <div class="col-md-12 page-main-wrapper box-shadow-default main-div-color" id="create-cat-main">
                <div class="row">
                    <div class="pages-inner-wrapper clearfix">
                        <div class="page-title-order-wrapper clearfix">
                            <div class="col-md-4">
                                <div><label for="page-title">PAGE TITLE</label></div>
                                <input type="text" name="title" placeholder="Title" id="page-title">
                            </div>
                            <div class="col-md-3 pull-right pullrightdiv">
                                <label for="page-order" class="float-right">PAGE ORDER</label>
                                <input type="number" min="0" name="order" id="page-order" class="float-right">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="category-textarea">
                                <label for="page-description">PAGE DESCRIPTION</label> <br>
                                <textarea name="description" cols="95" rows="9" id="page-description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-save">
                <button class="pull-right" id="page-save">SAVE</button>
            </div>
            {!! Form::close() !!}

            {!! Form::open(['url' => 'admin/pages/faq', 'id'=>'add_faq']) !!}
            <input type="hidden" name="type">
            <div class="col-md-12 page-main-wrapper box-shadow-default main-div-color" id="create-faq-main">
                <div class="faq-appended clearfix">
                    <div class="faq-question-main-wrapper clearfix">
                        <div class="col-md-5">
                            {{Form::text('title[]', null,['placeholder' => 'Question'])}}
                            <div class="col-md-4">
                                <div class="row">
                                    <input type="number" min="0" name="order[]" id="page-order" placeholder="Ordinal num">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{Form::textarea('description[]', null,['placeholder' => 'Answer', 'rows' => '10', 'class' => 'faq-textarea'])}}
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <button type="button" class="pull-right add-new-faq-btn">Add new FAQ</button>
                </div>
            </div>
            <div class="btn-save">
                <button class="pull-right" id="faq-save">SAVE</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
    <div class="col-md-3">
        <div class="select-page-faq-main-wrapper add-category-main-wrapper">
            <label for="options">PAGE TYPE</label> <br>

            <select name="categories" class="page-faq-toggle">
                <option value="page">Page</option>
                <option value="faq">FAQ</option>
            </select>
        </div>
    </div>

    {{--<div class="faq-appended-inner-wrapper clearfix">--}}
    {{--<div class="col-md-5">--}}
    {{--{{Form::text('title[]', null,['placeholder' => 'Question'])}}--}}
    {{--</div>--}}
    {{--<div class="col-md-7">--}}
    {{--<div class="row">--}}
    {{--{{Form::textarea('description[]', null,['placeholder' => 'Answer', 'rows' => '10'])}}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection
