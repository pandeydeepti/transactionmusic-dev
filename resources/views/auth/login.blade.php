@include('includes.admin.header')
        <body id="logo">
        <div class="login-form login">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                @if(!empty($logo))
                    <img src="{{$logo}}" alt="" id="login-logo">
                @else
                    <img src="images/login_logo.png" alt="" id="login-logo">
                @endif
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="Username">
                @if ($errors->has('email'))
                    <script>
                        $('#email').addClass('has-error-border');
                    </script>
                @endif
                <br>
                <input id="password" type="password" name="password" required placeholder="Password">
                @if ($errors->has('password'))
                    <script>
                        $('#password').addClass('has-error-border');
                    </script>
                @endif
                <br>
                <button type="submit" class="">
                    LOG IN
                </button>
            </form>
            <a href="" class="forgot-pw-link">Forgot password?</a>
        </div>
        <div class="forgot-password-form hidden login">
            <form class="form-horizontal" role="form" method="POST">
                {{ csrf_field() }}

                <input id="email_reset_pw" type="email" name="email_reset_pw" required autofocus
                       placeholder="Email">

                <button type="submit" class="reset-pw-btn">
                    RESET PASSWORD
                </button>
            </form>
            <a href="" class="forgot-pw-link">Return to login</a>
        </div>
        </body>
    @include('includes.admin.footer')

