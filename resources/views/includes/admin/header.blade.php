<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{Html::style('css/reset.css')}}
    {{Html::style('components/bootstrap/dist/css/bootstrap.min.css')}}
    {{Html::style('components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}
    {{Html::style('components/bootstrap-daterangepicker/daterangepicker.css')}}
    {{Html::style('plugins/jquery-upload-audio/css/uploadfile.css')}}
    {{Html::style('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}
    {{Html::style('plugins/data-tables/css/jquery.dataTables.min.css')}}
    {{Html::style('plugins/data-tables/css/buttons.dataTables.min.css')}}
    {{Html::style('css/circle.css')}}

    {{Html::style('plugins/select2-4.0.3/dist/css/select2.min.css')}}
    {{Html::style('https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css')}}


    {{Html::style('components/alertify.js/themes/alertify.core.css')}}
    {{Html::style('components/alertify.js/themes/alertify.default.css')}}
    {{Html::style('css/app.css')}}
    {{Html::style('css/admin-style.css')}}
    @if( file_exists('css/dynamic_admin.css') )
        {{Html::style('css/dynamic_admin.css')}}
    @endif
            <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>