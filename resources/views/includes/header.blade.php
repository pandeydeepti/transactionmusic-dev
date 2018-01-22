<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{Html::style('css/reset.css')}}
    {{Html::style('components/bootstrap/dist/css/bootstrap.min.css')}}
    {{Html::style('components/alertify.js/themes/alertify.core.css')}}
    {{Html::style('components/alertify.js/themes/alertify.default.css')}}
    {{Html::style('components/angular-rateit/dist/ng-rateit.css')}}
    {{Html::style('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}
    {{Html::style('plugins/chosen/chosen.min.css')}}
    {{Html::style('plugins/featherlight-1.5.0/release/featherlight.min.css')}}
    {{Html::style('css/front-style.css')}}
    @if( file_exists('css/dynamic_front.css') )
        {{Html::style('css/dynamic_front.css')}}
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{url('/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
