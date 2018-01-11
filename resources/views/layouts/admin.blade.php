<!DOCTYPE html>
<html lang="en">

<?php
if (!str_contains(Request::path(), 'admin/shop_options')){
    $paypal_email == '' ? header('Location: /admin/shop_options/') : '';
}
?>
@include('includes.admin.header')
<body>
<div id="app" class="clearfix main-admin-wrapper">
    <div class="col-md-12 position-fixed header-main-div">
        <div class="row">
            @include('includes.admin.navbar')
        </div>
    </div>

    @include('includes.admin.sidebar')

    <div class="col-md-10 pull-right">
        <div class="yield-content">
            <div class="right-main">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
@include('includes.admin.footer')

</body>
</html>
