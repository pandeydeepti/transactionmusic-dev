@extends('layouts.admin')
@section('content')
    <div class="title-page col-md-12">
        Categories
        <a href="/admin/categories/create"> <button class="pull-right add-new-category" type="button">ADD CATEGORY</button></a>
    </div>
    <div class="col-md-12">
        <div class="category-index-main-wrapper table-opacity-zero main_datatable">
            <table id="categoryTable" class="hover" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr class="{{$category->active == 0 ? 'innactive-affected-row' : ''}}">
                        <td>
                            <div class="category-single-title">{{$category->Category }}</div>
                            <div class="category-multiple-taxonomies">{{$category->Taxonomies}}</div>
                        </td>
                        <td>
                            <span class="loader-wrapper"><i class="fa fa-spinner fa-pulse fa-fw"></i></span>
                            <div class="active-category-toggle">
                                <div class="toggle-checkbox">
                                    <label class="switch">
                                        {{Form::hidden('active',0)}}
                                        {{Form::checkbox('active', $category->id, $category->active,['class' => 'category-active'])}}
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="/admin/categories/edit/{{$category->id}}">EDIT</a>
                        </td>
                        <td>
                            <div class="category-single-delete">
                                <a href="/admin/categories/delete/{{$category->id}}" class="a_element">
                                    <button id="delete_cat" type="button">X</button>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
