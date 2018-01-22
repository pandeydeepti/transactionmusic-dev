@extends('layouts.admin')
@section('content')
    <div class="title-page col-md-12">
        Pages
        <a href="/admin/pages/create"> <button class="pull-right add-new-page" type="button">ADD PAGE</button></a>

    </div>
    <div class="col-md-12">
        <div class="page-index-main-wrapper table-opacity-zero main_datatable">
            <table id="pageTable" class="hover" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr @if($faqs == 0) class="innactive-affected-row" @endif id="opacity-wrapper">
                    <td>
                        <div class="page-single-title">
                            <a href="{{url('/admin/pages/edit/faq')}}"> FAQ </a>
                        </div>
                    </td>
                    <td>
                        <a href="{{url('/faq')}}" target="_blank"><button class="page-view-btn">view</button></a>
                    </td>
                    <td class="checkbox-align-right">
                        <span class="loader-wrapper"><i class="fa fa-spinner fa-pulse fa-fw"></i></span>
                        <div class="toggle-checkbox">
                            <label class="switch">
                                {{Form::checkbox('active', true, $faqs, ['id' => 'faqs-active'])}}
                                <div class="slider round"></div>
                            </label>
                        </div>
                    </td>
                    <td>
                        <a href="/admin/pages/edit/faq" class="float-right">EDIT</a>
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="page-single-title">
                            <a href="{{url('/admin/pages/edit/producer')}}"> HOME </a>
                        </div>
                    </td>
                    <td>
                        <a href="{{url('/')}}" target="_blank"><button class="page-view-btn">view</button></a>
                    </td>
                    <td class="checkbox-align-right">
                        {{--<span class="loader-wrapper"><i class="fa fa-spinner fa-pulse fa-fw"></i></span>--}}
                        {{--<div class="toggle-checkbox">--}}
                        {{--<label class="switch">--}}
                        {{--{{Form::checkbox('active', true, $faqs, ['id' => 'faqs-active'])}}--}}
                        {{--<div class="slider round"></div>--}}
                        {{--</label>--}}
                        {{--</div>--}}
                    </td>
                    <td>
                        <a href="/admin/pages/edit/producer" class="float-right">EDIT</a>
                    </td>
                    <td>

                    </td>
                </tr>

                @foreach($pages as $page)
                    <tr @if($page->active == 0) class="innactive-affected-row" @endif>
                        <td>
                            <div class="page-single-title">
                                @if($page->slug != 'policies-terms')
                                <a href="{{url('/admin/pages/edit/'.$page->id)}}">{{$page->title }}</a>
                                @endif
                                <a>{{$page->title }}</a>
                            </div>
                        </td>
                        <td>
                            <a href="{{url('/'.$page->slug)}}" target="_blank"><button class="page-view-btn">view</button></a>
                        </td>
                        <td class="checkbox-align-right">
                            <span class="loader-wrapper"><i class="fa fa-spinner fa-pulse fa-fw"></i></span>
                            <div class="toggle-checkbox">
                                <label class="switch">
                                    {{Form::checkbox('active', $page->id, $page->active, ['class' => 'page-active'])}}
                                    <div class="slider round"></div>
                                </label>
                            </div>
                        </td>
                        <td>
                             @if($page->slug != 'policies-terms')
                            <a href="/admin/pages/edit/{{$page->id}}" class="float-right">EDIT</a>
                             @endif
                            <a href="" class="float-right"></a>
                        </td>
                        <td>
                            <div class="page-single-delete">
                                <a href="/admin/pages/delete/{{$page->id}}" class="a_element">
                                    <button id="delete_beat" type="button">X</button>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="col-md-12">
                <div class="row">
                </div>
            </div>
        </div>
    </div>
@endsection
