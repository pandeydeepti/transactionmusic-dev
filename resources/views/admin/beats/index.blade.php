@extends('layouts.admin')
@section('content')
<div class="title-page col-md-8">
        Beats
    <a href="/admin/beats/create"> <button class="pull-right add-new-beat" type="button">ADD BEAT</button></a>
</div>
    <div class="col-md-8">
        <div class="beats-index table-opacity-zero main_datatable">
            <table id="myTable" class="hover" cellspacing="0" width="100%">
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
                    @foreach($beats as $beat)
                        <tr @if($beat->active == 0) class="innactive-affected-row" @endif>
                            <td>
                                <div class="beat-single-title">{{$beat->Beat }}</div>
                                <div class="beat-single-producer">{{$beat->Producers}}</div>
                            </td>
                            <td>
                                <span class="loader-wrapper"><i class="fa fa-spinner fa-pulse fa-fw"></i></span>
                                <div class="toggle-checkbox">
                                    <label class="switch">
                                        {{Form::checkbox('active', $beat->id, $beat->active, ['class' => 'beat-active'])}}
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </td>
                            <td>
                              @if(isset($beat->exclusive_active) && $beat->exclusive_active == 1)  <div class="exclusive-content">EXCLUSIVE</div> @endif
                            </td>
                            <td>
                                <a href="{{'/admin/beats/create/'.$beat->id}}">EDIT</a>
                            </td>
                            <td>
                                <div class="beat-single-delete">
                                    <a href="/admin/beats/delete/{{$beat->id}}" class="a_element">
                                        <button id="delete_beat" type="button">X</button>
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