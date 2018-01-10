@extends('layouts.main')
@section('content')
    {!! Form::open(['url' => '/contact', 'id' => 'add_contact']) !!}
    <div class="inner-page-container">
        <div class="dedicated-mobileapp-main-wrapper clearfix">
            <div class="col-md-12">
                <div class="row">
                    <div class="title-page"> GET YOUR DEDICATED MOBILE APP</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <span><i class="fa fa-phone"></i> </span>
                    {!!Form::label('contact_name', '555-55 55 55', ['class' => 'control-label'])!!}
                    {!!Form::text('name', null, ['placeholder' => 'Name', 'id' => 'contact_name'])!!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <span><i class="fa fa-envelope-o"></i></span>
                    {!!Form::label('contact_email', 'transactiongmail.com', ['class' => 'control-label'])!!}
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