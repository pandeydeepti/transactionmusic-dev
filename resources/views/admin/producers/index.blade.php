@extends('layouts.admin')
@section('content')
    <div class="title-page col-md-12">
        Producers
        <a href="/admin/producers/create"> <button class="pull-right add-new-category" type="button">ADD PRODUCERS</button></a>
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
                @foreach($producers as $producer)
                    <tr @if($producer->active == 0) class="innactive-affected-row" @endif>
                        <td>
                            <div class="category-single-title">{{$producer->Producers }}</div>
                            <div class="category-multiple-taxonomies">Producer</div>
                        </td>
                        <td>
                            <span class="loader-wrapper"><i class="fa fa-spinner fa-pulse fa-fw"></i></span>
                            <div class="active-category-toggle">
                                <div class="toggle-checkbox">
                                    <label class="switch">
                                        {{Form::hidden('active',0)}}
                                        {{Form::checkbox('active', $producer->id, $producer->active,['class' => 'producer-active'])}}
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="/admin/producers/edit/{{$producer->id}}">EDIT</a>
                        </td>
                        <td>
                            <div class="category-single-delete">
                                <a href="/admin/producers/delete/{{$producer->id}}" class="a_element">
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