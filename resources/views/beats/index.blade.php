@extends('layouts.main')
@section('content')
    <body ng-app="myApp"  ng-controller="MainCtrl" >
    <div class="beats-player-main-wrapper">
        <div class="container not-ready">
            <div class="row">
                <div class="player-inner-wrapper clearfix">
                    <div class="col-md-6">
                        <div class="inner-img-title-wrapper">
                            <div class="inner-img-rate-wrapper player-img-title-wrap">
                                <img ng-src="@{{ currentPlaying.cover }}" alt="">
                            </div>
                            <div class="inner-title-bpm-wrapper player-img-title-wrap">
                                <div class="beat-player-title">@{{ currentPlaying.title }}</div>
                                <div class="beat-producer-title">@{{ currentPlaying.artist }}</div>
                                <div class="beat-player-bpm">@{{ currentPlaying.bpm }} bpm</div>
                            </div>
                        </div>
                        <div ng-rate-it star-width="16" star-height="16" class="custom rate-single-preview"
                             ng-model="songs[currentPlaying.index].rating"
                             ng-click="setCurrentRatingIndex( currentPlaying.index, songs[currentPlaying.index].rating )"
                             min="0.1"
                             max="5"
                             step="0.1"
                             resetable="false">
                        </div>
                    </div>
                    <div class="col-md-6 instance-name-absolute">
                        <div class="instance-player-wrapper">
                            <div class="share-icons">
                                <span ng-click="share_window( currentPlaying, 'facebook', '{{url('/')}}' );">
                                    <i class="fa fa-facebook"></i>
                                </span>
                                <span ng-click="share_window( currentPlaying, 'twitter', '{{url('/')}}' );">
                                    <i class="fa fa-twitter"></i>
                                </span>
                                <span ng-click="copyToClipboard('#share-text')">
                                    <input type="text" value="{{url('/')}}?title=@{{ currentPlaying.slug }}" class="hidden" id="share-text">
                                    <i class="fa fa-share-alt"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <sound-manager></sound-manager>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="setting-player-bar">
                        <div class="seconds-preview"> @{{ currentPostion }}</div>
                        <div class="preview-progres-bar">
                            <div class="seekBase" seek-track>
                                <div class="seekLoadDone" ng-style="{width : ( songProgress + '%' ) }"></div>
                                <input type="range" min='0' max='100' step="0.1" class="seekLoad"
                                       ng-model="songProgress" ng-init="setSeek(progress)"/>
                            </div>
                        </div>
                        <div class="seconds-preview">  @{{ currentDuration }}</div>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="player-function-wrapper">
                                    <button prev-track class="fa fa-fast-backward" aria-hidden="true"></button>
                                    <span class="play-pause-wrapper">
                                        <button ng-hide="!isPlaying"
                                                pause-music
                                                class="play-controll fa fa-pause"
                                                aria-hidden="true">

                                        </button>
                                        <button ng-hide="isPlaying"
                                                play-music
                                                class="play-controll fa fa-play"
                                                aria-hidden="true"
                                        ></button>
                                    </span>
                                    <button next-track class="fa fa-fast-forward fa-6" aria-hidden="true"></button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="volume-controll-wrapper pull-right">
                                    <div class="seekLoadDone" ng-style="{width : ( volume_level + '%' ) }"></div>
                                    <input type="range" name="range" ng-model="volume_level"
                                           ng-change="updateVolume(volume_level)" class="seekLoadVolume" min="0" max="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="not-ready beats-main-wrapper clearfix" @if( !empty($main_color) ) style="background-color: {!! $main_color !!} @endif">
        <div class="beats-inner-wrapper clearfix">
            <div class="beat-sort-by-inner-wrapper clearfix">
                <div class="sortby-select-inner-wrapper clearfix">
                    <div class="select-wrapper pull-left">
                        <select
                                chosen
                                width="100%"
                                disable-search="true"
                                name="sortby"
                                class="lf-select"
                                placeholder-text-single="SORT BY"
                                ng-model="selectedOrder"
                                ng-change="updateIndex()"
                                id="firstselect"
                                ng-options="option for option in sortByCustom"
                        >
                            <option>
                            </option>
                        </select>
                    </div>
                    <div class="select-wrapper pull-left">
                        <select
                                placeholder-text-single="PRODUCER"
                                chosen
                                width="100%"
                                disable-search="true"
                                class="lf-select"
                                ng-model="searchFilter.producer"
                                ng-options="value.title as value.title for value in filters['producer'].categories"
                        >
                            <option>
                            </option>
                        </select>
                    </div>
                    <div class="select-wrapper pull-left">
                        <select
                                chosen
                                width="100%"
                                disable-search="true"
                                class="lf-select"
                                id=""
                                placeholder-text-single="GENRE"
                                ng-model="searchFilter.genre"
                                ng-options="value.title as value.title for value in filters['genre'].categories">
                            <option>
                            </option>
                        </select>
                    </div>
                    <div class="select-wrapper pull-left">
                        <select
                                chosen
                                width="100%"
                                disable-search="true"
                                class="lf-select"
                                id=""
                                placeholder-text-single="SOUNDS LIKE"
                                ng-model="searchFilter.sounds_like"
                                ng-options="value.title as value.title for value in filters['sounds like'].categories">
                            <option>
                            <option>
                        </select>
                    </div>
                    <div class="select-wrapper pull-left">
                        <select
                                chosen
                                width="100%"
                                disable-search="true"
                                class="lf-select"
                                id=""
                                placeholder-text-single="INSTRUMENTS"
                                ng-model="searchFilter.instruments"
                                ng-options="value.title as value.title for value in filters['instruments'].categories">
                            <option>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="player-search-wrapper pull-right position-relative">
                    <input type="text" ng-model="textSearchFilter" name="search" placeholder="Search beats">
                </div>
            </div>
            @{{trackLoaded}}
            <div class="beat-title-option-inner-wrapper clearfix">
                <div class="pull-left single-content">BEAT TITLE</div>
                <div class="pull-left second-content">PRODUCER</div>
                <div class="pull-left third-content">RATING</div>
                <div class="pull-left _3-content">MP3 FILE</div>
                <div class="pull-left _4-content">WAV FILE</div>
                <div class="pull-left _5-content">TRACKED OUT</div>
                <div class="pull-left _6-content">EXCLUSIVE</div>
            </div>
            <div class="songs-wrapper clearfix">
                <div class="beat-single-content-inner-wrapper"
                     ng-class="{beat_row_hover: currentPlaying.id == song.id}"
                     ng-repeat="song in songs | customFilter:searchFilter | filter:textSearchFilter | orderBy:selectedOrder">
                    <div music-player="play" add-song="song" ng-click="togglePauseShow();"
                         class="beat-title single-content pull-left">
                        <span class="mobile-title-appear">BEAT TITLE</span>
                        @{{ song.title }}
                    </div>
                    <div class="producer-title second-content pull-left"><span class="mobile-title-appear">PRODUCER</span> @{{ song.artist }}</div>
                    <div class="rating-content third-content pull-left">
                        <span class="mobile-title-appear">RATING</span>
                        <div
                                ng-rate-it
                                star-width="16"
                                star-height="16"
                                ng-click="setCurrentRatingIndex( $index, song.rating )"
                                class="custom"
                                ng-model="song.rating"
                                min="0.1"
                                max="5"
                                step="0.1"
                                resetable="false"
                        >
                        </div>
                    </div>
                    <div ng-repeat="(filetype, file) in song.files"
                         class="_@{{ $index + 3 }}-content pull-left _@{{ $index + 3 }}beats-padding-right">
                        <span class="mobile-title-appear"> @{{ filetype|bootify }}</span>
                        <label for="checkbox_@{{ filetype }}-@{{ song.id }}_toggle">
                            &#36; @{{ file.price }}
                        </label>
                        <input type="checkbox" id="checkbox_@{{ filetype }}-@{{ song.id }}_toggle"
                               ng-click="updateCartPrice(filetype, song)"
                               ng-checked="song.files[filetype]['bought']"
                               ng-disabled="filetype != 'exclusive' ? song.files['exclusive']['bought'] : ''"
                        >
                    </div>
                </div>
            </div>
            <div class="bottom-item-wrapper">
                <span class="">ITEMS SELECTED:</span>
                <span class="">@{{ itemsSelected }} beats (&#36;@{{ cartTotalPrice }})</span>
                <button ng-disabled="itemsSelected == 0" data-featherlight="#popup-payment">BUY NOW</button>
            </div>
        </div>
    </div>
    <div class="container position-relative popup-div" id="popup-payment">
        {{Form::open(['url' => 'payment', 'method' => 'post', 'id' => 'paypal-form'])}}
        <div class="paypal-main-wrapper">
            <i class="fa fa-times featherlight-close-icon featherlight-close" aria-hidden="true"></i>
            <div class="paypal-inner-wrapper position-relative">
                <div class="paypal-title-inner-wrapper clearfix">
                    <div class="col-xs-3 no-padding">BEAT TITLE</div>
                    <div class="col-xs-3">PRODUCER</div>
                    <div class="col-xs-3">FORMAT</div>
                    <div class="col-xs-3"><span class="float-right">PRICE&nbsp;</span></div>
                </div>
                <div class="paypal-content-wrapper clearfix" ng-repeat="item in cart">
                    <input type="hidden" name="beat_id[]" value="@{{ item.beat_id }}">
                    <div class="col-xs-3 no-padding"><span class="mobile-popup-title-visible">BEAT TITLE</span>@{{ item.title }}</div>
                    <div class="col-xs-3"><span class="mobile-popup-title-visible">PRODUCER</span>@{{ item.artist }}</div>
                    <div class="col-xs-4">
                        <span class="mobile-popup-title-visible">FORMAT</span>
                        <input type="hidden" name="file_type[]" value="@{{ item.files | implodeFiletypes }}">
                        @{{ item.files | implodeFiletypes }}
                    </div>
                    <div class="col-xs-2"><span class="mobile-popup-title-visible price-content">PRICE</span><span class="float-right paypal-currency-span">&#36; @{{ item.files | calculate_bought_beats }}</span></div>
                </div>
            </div>
            <div class="paypal-submit-wrapper">
                <input type="submit" id="paypal_submit">
            </div>
        </div>
        {{Form::close()}}


        <form action="https://www.sandbox.paypal.com/webapps/adaptivepayment/flow/pay" target="PPDGFrame" class="standard" style="display: none">

            <label for="buy">Buy Now:</label>
            <input type="image" id="submitBtn" value="Pay with PayPal" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif">
            <input id="type" type="hidden" name="expType" value="mini">
            <input id="paykey" type="hidden" name="paykey" value="">
        </form>

    </div>
    @if(!empty($banners))
        <div class="banners-beat-main-wrapper clearfix">
            @foreach($banners as $banner)
                <div class="col-md-6">
                    <a href="{{$banner->url}}" target="_blank"> <img src="{{$banner->file_path}}" alt="" width="100%"> </a>
                </div>
            @endforeach
        </div>
    @endif
    <div class="newest-beats-main-wrapper">
        @if(!empty($newest_beats))
            <h2 class="newest-beats-padding-left">NEWEST BEATS</h2>
            <div class="newest-beats-title-inner-wrapper newest-beats-padding-left clearfix">
                <div class="newest-title pull-left">TITLE</div>
                <div class="newest-producer pull-left">PRODUCER</div>
                <div class="newest-genre pull-left">GENRE</div>
                <div class="newest-bpm pull-left">BPM</div>
                <div class="newest-added pull-left">ADDED</div>
            </div>
            @foreach($newest_beats as $newest_beat)
                <div class="newest-beats-single-inner-wrapper newest-beats-padding-left clearfix">
                    <div class="newest-title pull-left"><span class="newest-mobile-devices-wisible main-color">TITLE</span> {{$newest_beat->beat_title}}</div>
                    <div class="newest-producer pull-left"><span class="newest-mobile-devices-wisible main-color">PRODUCER</span>{{$newest_beat->producer}}</div>
                    <div class="newest-genre pull-left"><span class="newest-mobile-devices-wisible main-color">GENRE</span>{{$newest_beat->genre }}</div>
                    <div class="newest-bpm pull-left"><span class="newest-mobile-devices-wisible main-color">BPM</span>{{$newest_beat->beat_bpm}}</div>
                    <div class="newest-added pull-left"><span class="newest-mobile-devices-wisible main-color">ADDED</span>{{$newest_beat->beat_created_at}} ago</div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="beats-producers-main-wrapper clearfix">
        @if(!empty($producers))
            @foreach($producers as $producer)
                <div class="col-md-6">
                    <div class="beats-producers-inner-wrapper">
                        <div>
                            <img src="{{$producer->file_path}}" alt="{{$producer->title}}">
                        </div>
                        <div class="beats-producer-title-wrapper">
                            {{$producer->title}}
                        </div>
                        <div>
                            {{$producer->description}}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    </body>
@endsection