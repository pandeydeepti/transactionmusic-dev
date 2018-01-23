@extends('layouts.admin')
@section('content')
    {!! Form::open(['url' => 'admin/producers/update', 'id' => 'update_producer', 'files' => true]) !!}
    <div class="title-page col-md-12 top-padding-title">
       
            <div class="checkbox-title-togle">
                Edit {{$producer->title}}
           
            <div class="toggle-checkbox">
                <label class="switch">
                    {{Form::hidden('active',0)}}
                    {{Form::checkbox('active', 1, $producer->active, ['id' => 'producer-active'])}}
                    <div class="slider round"></div>
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">


            @if(isset($producer->active) && $producer->active==0)
                <div class="col-md-12  category-main-wrapper box-shadow-default main-div-color innactive-affected-row">
                    @else
                        <div class="col-md-12  category-main-wrapper box-shadow-default main-div-color">
                            @endif
                <div class="row">
                    <div class="category-inner-wrapper">
                        <div class="col-md-6">
                            <div class="row">
                                <label for="title">PRODUCER NAME</label>
                                <input type="text" disabled="disabled" id="producer-title" placeholder="Title" required value="{{$producer->title}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="title">PIC</label>
                            <div id="category-cover" @if(!empty($producer->cover)) style="{{$producer->cover}}"@endif>
                                <input type="file" name="cover"
                                       id="producer-upload"
                                       accept="image/x-png, image/jpeg"/>
                            </div>
                            <br>
                                                         <span>Max Width: 200px | Max Height: 200px</span>
                        </div>
                       
                        <input type="hidden" name="id" id="pro_id" value="{{$producer->id}}">

                        <div class="col-md-10 category-textarea">
                            <div class="row">
                                <label for="description">PRODUCER DESCRIPTION</label> <br>
                                <textarea name="description" cols="95" rows="9" id="producer-desc">{{$producer->description}}</textarea>
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
                <button class="pull-right" id="producer-save">SAVE</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
