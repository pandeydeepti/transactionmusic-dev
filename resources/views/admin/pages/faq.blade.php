@extends('layouts.admin')
@section('content')
    <div class="title-page col-md-12">
        <div class="row">
            Edit FAQ:
        </div>
    </div>
    <form action="/admin/pages/faq/update" method="post">
        {{csrf_field()}}
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 page-main-wrapper box-shadow-default main-div-color">
                    <div class="row">
                        <div class="pages-inner-wrapper clearfix">
                            @if( !$pages->isEmpty()  )
                                @for($i = 0; $i < count($pages); $i++)
                                    <div class="faq-update-wrapper clearfix">
                                        <input type="hidden" name="id[]" value="{{$pages[$i]->id}}">
                                        <div class="faq-question-inner-wrapper clearfix">
                                            <div class="col-md-5">
                                                <input type="text" name="title[]" id="" placeholder="Question" value="{{$pages[$i]->title}}">

                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <input type="number" min="0" name="order[]" id="page-order"
                                                               placeholder="Ordinal num" value="{{$pages[$i]->order}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="faq-textarea" name="description[]" id="" rows="10" placeholder="Answer"> {!! $pages[$i]->description !!}</textarea>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="page-single-delete">
                                                    <a class="delete_single_faq" href="/admin/pages/delete/{{$pages[$i]->id}}">
                                                        <button type="button">X</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @else
                                <div class="faq-update-wrapper clearfix">
                                    <div class="col-md-5">
                                        <input type="hidden" name="ids[]" value="">

                                        <input type="text" name="title[]" id="" placeholder="Question">

                                        <div class="col-md-4">
                                            <div class="row">
                                                <input type="number" min="0" name="order[]" id="page-order"
                                                       placeholder="Ordinal num">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <textarea class="faq-textarea" name="description[]" id="" rows="10"
                                                  placeholder="Answer"></textarea>
                                    </div>

                                </div>
                            @endif
                            <div class="faq-appended clearfix"></div>
                            <div class="col-md-12">
                                <button type="button" class="pull-right add-new-faq-btn">Add new FAQ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="btn-save">
                    <button class="pull-right" id="faq-update" type="submit">SAVE</button>
                </div>
            </div>
        </div>
    </form>
@endsection