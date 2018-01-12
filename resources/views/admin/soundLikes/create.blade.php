@extends('layouts.admin')
@section('content')
    {!! Form::open(['url' => 'admin/sounds_like/create', 'id'=>'add_soundlike', 'files' => true]) !!}
    <div class="title-page col-md-12 top-padding-title">
        <div class="row">
            <div class="checkbox-title-togle">
                Add Soundslike
            </div>
            <div class="toggle-checkbox">
                <label class="switch">
                    {{Form::hidden('active',0)}}
                    {{Form::checkbox('active', 1, true, ['id' => 'soundlike-active'])}}
                    <div class="slider round"></div>
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 category-main-wrapper box-shadow-default main-div-color">
                <div class="row">
                    <div class="category-inner-wrapper">
                        <div class="col-md-6">
                            <div class="row">
                                <label for="title">SOUNDS LIKE</label>
                                <input type="text" name="title" placeholder="Title" id="soundlike-title">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="title">COVER</label>
                            <div id="soundlike-cover">
                                <input type="file" name="cover"
                                       id="soundlike-upload"
                                       accept="image/x-png, image/jpeg"/>
                            </div>
                            <br>
                               <span>Max Width: 200px | Max Height: 200px</span>
                        </div>
                      
                        <div class="col-md-10 category-textarea">
                            <div class="row">
                                <label for="description">SOUNDS LIKE DESCRIPTION</label> <br>
                                <textarea name="description" cols="95" rows="9" id="soundlike-desc"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="btn-save">
                <button class="pull-right" id="soundlike-save">SAVE</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection