<!DOCTYPE html>
<html lang="en">
@include('includes.header')
<body>
<div class="frontend-main-div clearfix">
    <div class="clearfix box-shadow-navbar">
        <div class="col-md-12 col-xs-12">
            @include('includes.navbar')
        </div>
    </div>
    @yield('content')
</div>

<!-- Scripts -->
@include('includes.footer')

</body>
</html>
