@extends('layouts.admin')
@section('content')
    {!! Form::open(['url' => 'admin/categories/update', 'id' => 'update_category', 'files' => true]) !!}
    <div class="title-page col-md-12 top-padding-title">
        <div class="row">
            <div class="checkbox-title-togle">
                Edit {{$category->title}}
            </div>
            <div class="toggle-checkbox">
                <label class="switch">
                    {{Form::hidden('active',0)}}
                    {{Form::checkbox('active', 1, $category->active, ['id' => 'category-active'])}}
                    <div class="slider round"></div>
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">


            @if(isset($category->active) && $category->active==0)
                <div class="col-md-12  category-main-wrapper box-shadow-default main-div-color innactive-affected-row">
                    @else
                        <div class="col-md-12  category-main-wrapper box-shadow-default main-div-color">
                            @endif
                <div class="row">
                    <div class="category-inner-wrapper">
                        <div class="col-md-5">
                            <div class="row">
                                <label for="title">CATEGORY TITLE</label>
                                <input type="text" name="title" id="category-title" placeholder="Title" required value="{{$category->title}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="title">COVER</label>
                            <div id="category-cover" @if(!empty($category->cover)) style="{{$category->cover}}"@endif>
                                <input type="file" name="cover"
                                       id="category-upload"
                                       accept="image/x-png, image/jpeg"/>
                            </div>
                        </div>
                        @if(isset($taxonomies))
                            <select name="taxonomy_id">
                                @foreach($taxonomies as $taxonomy)
                                    @if(in_array($category->taxonomies[0]->id, $taxonomy))
                                        <option value="{{$taxonomy['id']}}" selected>{{$taxonomy['name']}}</option>
                                    @else
                                        <option value="{{$taxonomy['id']}}">{{$taxonomy['name']}}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif

                        <input type="hidden" name="id" id="cat_id" value="{{$category->id}}">

                        <div class="col-md-10 category-textarea">
                            <div class="row">
                                <label for="description">CATEGORY DESCRIPTION</label> <br>
                                <textarea name="description" cols="95" rows="9" id="category-desc">{{$category->description}}</textarea>
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
                <button class="pull-right" id="category-save">SAVE</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
