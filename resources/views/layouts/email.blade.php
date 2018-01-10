<!DOCTYPE html>
<html lang="en">
@include('includes.header')
<body>
<div class="row">
    <div class="email-main-wrapper">
        <div class="email-inner-wrapper">
            @if ($logo != null)
                {{Html::image($logo, 'logo', ['width' => '100'])}}
            @else
                {{Html::image('images/transactionlogo.png')}}
            @endif
        </div>
        <div class="email-content-wrapper">
            @yield('content')
        </div>
    </div>
</div>
<!-- Scripts -->
@include('includes.email.footer')
</body>
</html>
