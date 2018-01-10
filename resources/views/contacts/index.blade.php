@extends('layouts.main')
@section('content')
    {!! Form::open(['url' => '/contact', 'id' => 'add_contact']) !!}
    <div class="inner-page-container">
        <div class="contact-main-wrapper clearfix">
            <div class="col-md-12">
                <div class="row">
                    <div class="title-page"> CONTACT</div>
                </div>
            </div>
            <div>
                <span><i class="fa fa-envelope"></i></span>
                {!!Form::label('contact_email', !empty( $contact_mail ) ? $contact_mail : '', ['class' => 'control-label'])!!}
            </div>
            <div class="col-md-6">
                <div class="row">
                    {{--<span><i class="fa fa-phone-square"></i> </span>--}}
                    {{--                    {!!Form::label('contact_name', '555-55 55 55', ['class' => 'control-label'])!!}--}}
                    {!!Form::text('name', null, ['placeholder' => 'Name', 'id' => 'contact_name'])!!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    {!!Form::text('email', null, ['placeholder' => 'email', 'id' => 'contact_email'])!!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <textarea name="message" id="contact_message" placeholder="Message" rows="10"></textarea>
                    {!!Form::submit('SUBMIT', ['id' => 'btn-add-contact'])!!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection