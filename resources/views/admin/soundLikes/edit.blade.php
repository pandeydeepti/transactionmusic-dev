@extends('layouts.admin')
@section('content')
    {!! Form::open(['url' => 'admin/sounds_like/update', 'id' => 'update_soundlike', 'files' => true]) !!}
    <div class="title-page col-md-12 top-padding-title">
        <div class="row">
            <div class="checkbox-title-togle">
                Edit {{$soundlike->title}}
            </div>
            <div class="toggle-checkbox">
                <label class="switch">
                    {{Form::hidden('active',0)}}
                    {{Form::checkbox('active', 1, $soundlike->active, ['id' => 'soundslike-active'])}}
                    <div class="slider round"></div>
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">


            @if(isset($soundlike->active) && $soundlike->active==0)
                <div class="col-md-12  category-main-wrapper box-shadow-default main-div-color innactive-affected-row">
                    @else
                        <div class="col-md-12  category-main-wrapper box-shadow-default main-div-color">
                            @endif
                <div class="row">
                    <div class="category-inner-wrapper">
                        <div class="col-md-6">
                            <div class="row">
                                <label for="title">SOUNDS LIKE</label>
                                <input type="text" disabled="disabled" id="soundlike-title" placeholder="Title" required value="{{$soundlike->title}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="title">COVER</label>
                            <div id="soundlike-cover" @if(!empty($soundlike->cover)) style="{{$soundlike->cover}}"@endif>
                                <input type="file" name="cover"
                                       id="soundlike-upload"
                                       accept="image/x-png, image/jpeg"/>
                            </div>
                            <br>
                                                         <span>Max Width: 200px | Max Height: 200px</span>
                        </div>
                       
                        <input type="hidden" name="id" id="sod_id" value="{{$soundlike->id}}">

                        <div class="col-md-10 category-textarea">
                            <div class="row">
                                <label for="description">SOUNDS LIKE DESCRIPTION</label> <br>
                                <textarea name="description" cols="95" rows="9" id="soundlike-desc">{{$soundlike->description}}</textarea>
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