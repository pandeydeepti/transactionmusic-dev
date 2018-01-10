<!DOCTYPE html>
<html lang="en">
@include('includes.header')
<body>
<div class="frontend-main-div clearfix">
    <body ng-app="myApp"  ng-controller="MainCtrl" >
    <div class="beats-player-main-wrapper">
        <div class="container not-ready">
            <div class="row">
                <div class="player-inner-wrapper clearfix">
                    <div class="col-md-6">
                        <div class="inner-img-title-wrapper">
                            <div class="inner-img-rate-wrapper">
                                <img ng-src="@{{ currentPlaying.cover }}" alt="">
                            </div>
                            <div class="inner-title-bpm-wrapper">
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
                            <div class="instance-name-link-wrapper">
                                <span class="instance-name-span">@{{ currentPlaying.instance.name  }}</span>
                                <span class="instance-link-span"><a href="@{{ currentPlaying.instance.url }}">@{{ currentPlaying.instance.url }}</a></span>
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
    <div class="not-ready beats-main-wrapper clearfix">
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
                            <option>
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
                                ng-options="value.id as value.title for value in filters['producer']"
                        >
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
                                placeholder-text-single="GENRE"
                                ng-model="searchFilter.genre"
                                ng-options="value.id as value.title for value in filters['genre']">
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
                                placeholder-text-single="SOUNDS LIKE"
                                ng-model="searchFilter.sounds_like"
                                ng-options="value.id as value.title for value in filters['sounds like']">
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
                                ng-options="value.id as value.title for value in filters['instruments']">
                            <option>
                            <option>
                        </select>
                    </div>
                </div>
                <input type="text" ng-model="textSearchFilter" name="search" placeholder="&#xf002; Search beats">
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
                <div class="beat-single-content-inner-wrapper" ng-class="{beat_row_hover: currentPlaying.id == song.id}"
                     ng-repeat="song in songs | customFilter:searchFilter | filter:textSearchFilter | orderBy:selectedOrder">
                    <div music-player="play" add-song="song" ng-click="togglePauseShow();"
                         class="beat-title single-content pull-left">
                        @{{ song.title }}
                    </div>
                    <div class="producer-title second-content pull-left">@{{ song.artist }}</div>
                    <div class="rating-content third-content pull-left">
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
                        <label for="checkbox_@{{ filetype }}-@{{ song.id }}_toggle">
                            &#36; @{{ file.price }}
                        </label>
                        <input type="checkbox" id="checkbox_@{{ filetype }}-@{{ song.id }}_toggle"
                               ng-click="updateCartPrice(filetype, song)"
                               ng-checked="song.files[filetype]['bought']"
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
        {{Form::open(['url' => 'payment', 'method' => 'post'])}}
        <div class="paypal-main-wrapper">
            <i class="fa fa-times featherlight-close-icon featherlight-close" aria-hidden="true"></i>
            <div class="paypal-inner-wrapper position-relative">
                <div class="paypal-title-inner-wrapper clearfix">
                    <div class="col-md-3 no-padding">BEAT TITLE</div>
                    <div class="col-md-3">PRODUCER</div>
                    <div class="col-md-3">FORMAT</div>
                    <div class="col-md-3"><span class="float-right">PRICE&nbsp;</span></div>
                </div>
                <div class="paypal-content-wrapper clearfix" ng-repeat="item in cart">
                    <input type="hidden" name="beat_id[]" value="@{{ item.id }}">
                    <div class="col-md-3 no-padding">@{{ item.title }}</div>
                    <div class="col-md-3">@{{ item.artist }}</div>
                    <div class="col-md-4">
                        <input type="hidden" name="file_type[]" value="@{{ item.files | implodeFiletypes }}">
                        @{{ item.files | implodeFiletypes }}
                    </div>
                    <div class="col-md-2"><span class="float-right paypal-currency-span">&#36; @{{ item.files | calculate_bought_beats }}</span></div>
                </div>
            </div>
            <div class="paypal-submit-wrapper">
                {{Form::submit()}}
            </div>
            {{Form::hidden('paypal_mail', $paypal_mail)}}
        </div>
        {{Form::close()}}
    </div>

    </body>

</div>

<!-- Scripts -->
{{Html::script('components/alertify.js/lib/alertify.js')}}
{{Html::script('components/jquery/dist/jquery.js')}}
{{Html::script('components/angular/angular.min.js')}}
{{Html::script('components/angular-soundmanager2/dist/angular-soundmanager2.js')}}
{{Html::script('js/angular.js')}}
{{Html::script('components/angular-rateit/dist/ng-rateit.js')}}
{{Html::script('components/jquery-slimscroll/jquery.slimscroll.js')}}

{{Html::script('plugins/chosen/chosen.jquery.js')}}
{{Html::script('components/angular-chosen-localytics/dist/angular-chosen.js')}}
{{Html::script('plugins/featherlight-1.5.0/release/featherlight.min.js')}}
{{Html::script('js/front-main.js')}}

</body>
</html>