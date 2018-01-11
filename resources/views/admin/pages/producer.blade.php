@extends('layouts.admin')
@section('content')
    <div class="title-page col-md-12">
            @if( !$pages->isEmpty() )
                Edit Producers:
            @else
                Create Producers
            @endif
    </div>
    <form action="/admin/pages/producer" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 page-main-wrapper box-shadow-default main-div-color">
                    <div class="row">
                        <div class="pages-inner-wrapper clearfix">
                            @if( $pages->isEmpty() )
                            <div class="home-producer-inner-wrapper clearfix">
                                <div class="col-md-5">
                                    <input type="hidden" name="id[]">

                                    <input type="text" name="title[]" placeholder="Name">
                                    <div>
                                        <div id="first_producer" class="preview_div_style">
                                            <input type="file" name="file_path[]" id="first_producer_image">
                                        </div>
                                        </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <input type="number" min="0" name="order[]" id="page-order" placeholder="Ordinal num">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="faq-textarea" name="description[]" rows="12" placeholder="Description"></textarea>
                                </div>

                            </div>
                            @else
                                @for($i = 0; $i < count($pages); $i++)
                                    <div class="home-producer-inner-wrapper clearfix">
                                        <div class="col-md-5">
                                            <input type="hidden" name="id[]" value="{{$pages[$i]->id}}">
                                            <input type="text" name="title[]" placeholder="Name" value="{{$pages[$i]->title}}">
                                            <div>
                                                <div id="preview_{{$pages[$i]->id}}" class="preview_div_style" @if( !empty( $pages[$i]->file_path ) ) style="background-image: url('{{$pages[$i]->file_path}}')"  @endif>
                                                    <input type="file" name="file_path[]" id="input_{{$pages[$i]->id}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <input type="number" min="0" name="order[]" id="page-order" placeholder="Ordinal num" value="{{$pages[$i]->order}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea class="faq-textarea" name="description[]" rows="12" placeholder="Description">{{$pages[$i]->description}}</textarea>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="page-single-delete">
                                                <a class="delete_single_producer" href="/admin/pages/delete/{{$pages[$i]->id}}">
                                                    <button type="button">X</button>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                @endfor
                            @endif
                            <div class="faq-appended clearfix"></div>
                            <div class="col-md-12">
                                <button type="button" class="pull-right add-new-producer-btn">Add new Producer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="btn-save">
                    <button class="pull-right" type="submit">SAVE</button>
                </div>
            </div>
        </div>
    </form>
@endsection
