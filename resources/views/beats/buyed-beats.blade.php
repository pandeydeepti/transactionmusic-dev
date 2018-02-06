@extends('layouts.main')
@section('content')
    <div class="buyed-beats-main-wrapper">
        @if(!empty($state ) && ($state == 'success' || $state == 'error') )
            {!! sprintf($shop, $customer_mail) !!}
            @if( !empty($inactive_beats) )
                <div class="inactive-beats">
                    <div class="inactive-text-wrapp">You have error with following beats, please contact us at <span class="inactive-contact-mail">{{@$contact_mail}}</span></div>
                    @foreach($inactive_beats as $inactive_beat)
                        <div class="inactive-beats-inner-wrap clearfix">
                            {{$inactive_beat->beat_title}} <div class="inline-block float-right">{{$inactive_beat->beat_types}} </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            Payment error
        @endif
    </div>
@endsection