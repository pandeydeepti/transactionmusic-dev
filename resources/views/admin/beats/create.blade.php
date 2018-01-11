@extends('layouts.admin')
@section('content')
    <div class="title-page col-sm-12 top-padding-title">
        @if(!empty($beat->title))
            {!! Form::open(['url' => 'admin/beats/update', 'id'=>'add_beat', 'files' => true]) !!}
            <div class="row">
                <div class="checkbox-title-togle">
                    {{$beat->title}}
                </div>
                <div class="toggle-checkbox">
                    <label class="switch">
                        {{Form::hidden('active',0)}}
                        {{Form::checkbox('active', 1, $beat->active,['id' => 'beat-active'])}}
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
        @else
            {!! Form::open(['url' => 'admin/beats', 'id'=>'add_beat', 'files' => true]) !!}
            <div class="checkbox-title-togle"> Add Beat</div>
            <div class="toggle-checkbox">
                <label class="switch">
                    {{Form::hidden('active',0)}}
                    {{Form::checkbox('active', 1, true, ['id' => 'beat-active'])}}
                    <div class="slider round"></div>
                </label>
            </div>
        @endif
    </div>
    @if(isset($beat->active) && $beat->active==0)
        <div id="opacity-wrapper" class="innactive-affected-row">
            @else
                <div id="opacity-wrapper" class="clearfix">
                    @endif
                    @if(!empty($beat->id))
                        <div class="beat-update-div">
                            @else
                                <div class="beat-create-div clearfix">
                                    @endif
                                    <div class="col-sm-6">
                                        <div class="row add-beat-main-wrapper box-shadow-default main-div-color">

                                            <div class="col-sm-12">
                                                <div class="add-beat-inner-wrapper clearfix">
                                                    <div class="col-sm-8">
                                                        <div class="row">
                                                            <div class="col-sm-12 bottom-spacing">
                                                                <label for="song-title" id="label-song">SONG
                                                                    TITLE</label>
                                                                <input class="fullwidth maxfullwidth" type="text"
                                                                       name="title"
                                                                       data-minlength='3' placeholder="Title"
                                                                       id="song-title"
                                                                       value="@if(!empty($beat->title)){{$beat->title}} @endif">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="rate">RATING</label>
                                                                <input
                                                                        class="fullwidth"
                                                                        type="number"
                                                                        min="1"
                                                                        max="100"
                                                                        data-type="number"
                                                                        name="rate" id="rate"
                                                                        @if(!empty($beat->rate)) value="{{$beat->rate}}" @endif>

                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="bpm">BPM</label>
                                                                <input type="number" data-type="number"
                                                                       name="bpm" id="bpm"
                                                                       @if(!empty($beat->bpm)) value="{{$beat->bpm}}" @endif>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="cover-content-wrapper">
                                                            <label for="title">COVER</label>

                                                            <div id="beat-cover"
                                                                 @if(!empty($beat->cover)) style="{{$beat->cover}}"@endif>
                                                                <input type="file" name="cover"
                                                                       id="image-upload"
                                                                       accept="image/x-png, image/jpeg"/>
                                                            </div>
                                                            <input type="hidden" id="cover_validator"
                                                                   name="cover_validator">
                                                        </div>
                                                        <br>
                                                         <span>Max Width: 200px | Max Height: 200px</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="song-inner-wrapper">
                                                    <label for="song_type">FILE TYPES</label>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="col-sm-12"> <!-- file-types-wrapper -->
                                                <div class="row">
                                                    <div class="file-types-wrapper clearfix">
                                                        <div class="col-xs-12">
                                                            <div class="row">
                                                                <div class="file-types-single-row clearfix"> <!-- file-types-single-row 1-->
                                                                    <div class="col-sm-3">
                                                                        <div class="file-name-wrapper">
                                                                            <label for="mp3">MP3</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <div class="row">
                                                                            <div id="mp3div"></div>
                                                                            <input type="text" data-type="file" name="mp3"
                                                                                   id="mp3" hidden/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="row">
                                                                            <div class="file-price-wrapper">
                                                                                <label for="mp3_price">Price &#36;</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="row">
                                                                            <div class="file-price-wrapper">
                                                                                <input type="number" data-type="number"
                                                                                       name="mp3_price" id="mp3_price"
                                                                                       @if(!empty($beat->mp3_price)) value="{{$beat->mp3_price}}" @endif>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> <!-- file-types-single-row 1-->
                                                                <div class="file-types-single-row clearfix"> <!-- file-types-single-row 2-->
                                                                    <div class="col-sm-3">
                                                                        <div class="file-name-wrapper">
                                                                            <label for="wav">WAV</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <div class="row">
                                                                            <div id="wavdiv"></div>
                                                                            <input type="text" data-type="file"
                                                                                   name="wav" id="wav"
                                                                                   hidden/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="row">
                                                                            <div class="file-price-wrapper">
                                                                                <label for="wav_price">Price &#36;</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="row">
                                                                            <div class="file-price-wrapper">
                                                                                <input type="number" data-type="number"
                                                                                       name="wav_price" id="wav_price"
                                                                                       @if(!empty($beat->wav_price))value="{{$beat->wav_price}}"@endif>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> <!-- file-types-single-row 2-->
                                                                <div class="file-types-single-row clearfix"> <!-- file-types-single-row 3-->
                                                                    <div class="col-sm-3">
                                                                        <div class="file-name-wrapper">
                                                                            <label for="tracked_out">TRACKED OUT</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <div class="row">
                                                                            <div id="tracked-outdiv"></div>
                                                                            <input type="text" data-type="file"
                                                                                   name="tracked_out" id="tracked-out"
                                                                                   hidden/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="row">
                                                                            <div class="file-price-wrapper">
                                                                                <label for="tracked_out_price">Price
                                                                                    &#36;</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="row">
                                                                            <div class="file-price-wrapper">
                                                                                <input type="number" data-type="number"
                                                                                       name="tracked_out_price"
                                                                                       id="tracked_out_price"
                                                                                       @if(!empty($beat->tracked_out_price)) value="{{$beat->tracked_out_price}}">@endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> <!-- file-types-single-row 3-->


                                                            <div class="file-types-single-row clearfix"> <!-- file-types-single-row 4-->
                                                                <div class="col-sm-3">
                                                                    <div class="file-name-wrapper">
                                                                        <label for="exclusive">EXCLUSIVE</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <div class="row">
                                                                        <div class="toggle-exclusive-checkbox">
                                                                            <label class="switch">
                                                                                {{Form::hidden('exclusive_active',0)}}
                                                                                @if(!empty($beat->exclusive_active))
                                                                                    {{Form::checkbox('exclusive_active', 1, $beat->exclusive_active, ['id' => 'exclusive'])}}
                                                                                @else
                                                                                    {{Form::checkbox('exclusive_active', 1,true, ['id' => 'exclusive'])}}
                                                                                @endif
                                                                                <div class="slider round"></div>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="row">
                                                                        <div class="file-price-wrapper">
                                                                            <label for="exclusive_price">Price &#36;</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="row">
                                                                        <div class="file-price-wrapper">
                                                                            <input type="number" data-type="number"
                                                                                   name="exclusive_price"
                                                                                   id="exclusive_price"
                                                                                   @if(!empty($beat->exclusive_price)) value="{{$beat->exclusive_price}}"@endif>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- file-types-single-row 4-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- file-types-wrapper -->
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-sm-6">
                                        <div class="add-category-main-wrapper box-shadow-default clearfix">
                                            <label for="categories" class="categories-title-label">CATEGORIES</label>
                                            @if(isset($categories))
                                                @foreach($categories as $key => $value)

                                                    <div class="col-sm-6 category-box">
                                                        <label for="genre"
                                                               class="categories-title-label">{{$key}}</label>

                                                        <div class="genre-category-inner-wrapper add-category-inner-wrapper">
                                                            @foreach($value as $catKey => $catValue)
                                                                <div class="category-single-item">
                                                                    <label for="{{$catValue['id']}}">{{$catValue['category']}}</label>
                                                                    <input type="checkbox"
                                                                           @if(!empty($beat) && in_array(  $catValue['id'], $beat->cat_id) ) {{"checked"}}  @endif class="categories"
                                                                           name="categories[]"
                                                                           id="{{$catValue['id']}}"
                                                                           value="{{$catValue['id']}}"/>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="col-sm-12">
                                                <a href="/admin/categories/create" target="_blank">
                                                    <button type="button">ADD CATEGORY</button>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                  <div style="clear:both;padding-top:20px;"></div>
                                   <div class="col-sm-6">
                                        <div class="add-category-main-wrapper box-shadow-default clearfix sound-like">
                                            <label for="producers" class="producers-title-label">PRODUCERS</label>
<div class="row"><div class="col-sm-6">
                                               <div class="genre-category-inner-wrapper add-category-inner-wrapper">
                                                   <select name="producers[]" class="col-sm-6 category-single-item">
                                            @if(isset($producers))
                                                @foreach($producers as $key => $value)
                                                            <option value="{{ $value->id }}" {{ @$beat->pro_id['0'] == $value->id ? 'selected="selected"' : '' }}>{{ $value->producers }}</option>
                                                @endforeach
                                            @endif
                                             </select>
                                               </div></div>
             
                                            <div class="col-sm-6">
                                                <a href="/admin/producers/create" target="_blank">
                                                    <button type="button">ADD PRODUCER</button>
                                                </a>
                                            </div>  </div>
                                        </div>

                                    </div>  
                                    
                                    <div class="col-sm-6 nopadding-new">
                                        <div class="row add-category-main-wrapper box-shadow-default clearfix sound-like">
                                            <label for="sound_likes" class="sound_likes-title-label">SOUNDS LIKE</label>
                                            <div class="row">
<div class="col-sm-6">
                                               <div class="genre-category-inner-wrapper add-category-inner-wrapper ">
                                                   <select name="sound_likes[]" class="col-sm-6 category-single-item">
                                            @if(isset($sound_likes))
                                                @foreach($sound_likes as $key => $value)
                                                            <option value="{{ $value->id }}" {{ @$beat->snd_id['0'] == $value->id ? 'selected="selected"' : '' }}>{{ $value->sound_likes }}</option>
                                                @endforeach
                                            @endif
                                             </select>
                                               </div>
             </div>
                                            <div class="col-sm-6">
                                                <a href="/admin/sounds_like/create" target="_blank">
                                                    <button type="button">ADD SOUNDS LIKE</button>
                                                </a>
                                            </div></div>
                                        </div>

                                    </div>  
                                    
                                </div>

                        <div class="col-sm-6">
                            <input type="hidden" name="id"
                                   @if(!empty($beat->id)) value="{{$beat->id}}"@endif>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="beat-active-wrapper clearfix">
                                    <div class="btn-save" id="btn-save-beat">
                                        <button class="pull-right">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
        </div>
        {!! Form::close() !!}
@endsection
