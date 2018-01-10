<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Download beats</title>
</head>
<body>
<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat');
</style>
<table style="border-collapse: collapse;border-spacing: 0; margin: auto;table-layout: fixed;font-family: 'Montserrat', sans-serif;"
       align="center"
       width="750px">
    <tr>
        <td align="center" colspan="3">
            @if( !empty($website_logo) )
                {{Html::image($website_logo, 'logo', ['width' => '100'])}}
            @else
                {{Html::image('images/transactionlogo.png')}}
            @endif
        </td>
    </tr>
    <tr>
        <td style="line-height: 27px;margin-bottom: 50px;padding-top: 50px" align="center" colspan="3">
            <h1 style="font-size: 24px;color: #19cefb;font-weight: 700;margin-bottom: 50px;">ORDER CONFIRMATION</h1>
            {!! $email_content !!}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="center" style="padding-top: 50px">
            <a href="{{url('/').'/zips/beats/'.$beat_route}}"
               style="width: 100%;display: block;background-color: #19cefb;height: 40px;line-height: 40px;text-decoration: none;color:white;">
                DOWNLOAD
            </a>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>
{{--<div class="email-text-wrapper">--}}
{{--@if(!empty($email_content))--}}

{{--@else--}}
{{--Lorem ipsum dolor sit amet, consectetur adipisicing elit.--}}
{{--Adipisci aliquid at blanditiis commodi consequatur deserunt--}}
{{--eius illo officiis sint soluta. Adipisci facilis iste libero optio reiciendis--}}
{{--repellat saepe temporibus vitae?--}}
{{--@endif--}}
{{--</div>--}}

{{--<a href="{{url('/').'/beat/'.$beat_route}}" style=""><button>DOWNLOAD BEATS</button></a>--}}
