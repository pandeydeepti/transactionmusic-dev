<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaction music | Coming soon page</title>
    <!--bootstarp-css-->
    {{Html::style('components/bootstrap/dist/css/bootstrap.min.css')}}
    <!--/bootstarp-css -->
    <!--css-->
    {{Html::style('css/style.css')}}
    {{Html::style('css/jquery.countdown.css')}}
    <!--/css-->
    <!--fonts-->
    <link href='http://fonts.googleapis.com/css?family=Raleway:500,600,700,100,400,200,300' rel='stylesheet'
          type='text/css'><!--/fonts-->
    <!--js-->
    {{Html::script('components/jquery/dist/jquery.min.js')}}
    {{Html::script('js/countdown.js')}}
    {{Html::script('js/script.js')}}
    <!--/js-->
</head>
<script>
    $(function() {
        $("button").click(function() {
                var error = 0;
                var name = document.getElementById("name").value;
                var vname = document.getElementById("name");
                var email = document.getElementById("email").value;
                var vemail = document.getElementById("email");

                if (name == ''){
                    vname.className += vname.className ? ' error-class': '.error-class';
                    error = 1;
                }
                if (email == ''){
                    vemail.className += vemail.className ? ' error-class': '.error-class';
                    error = 1;
                }

            console.log(error);

                var data = {
                    name: name,
                    email: email
                }

            if (error == 0){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: data,
                url: "/sendmail",
                success: function(){
                    $('.success').fadeIn(1000);
                }
            });
            }
            return false;
        });

    });


</script>
<body>
<div class="header">
    <div class="container">
        <div class="logo">
            {{Html::image('images/logo.png')}}
        </div>
        <h1 id="comingsoon">Coming soon</h1>

        <div class="countdown">
            <ul id="countdown">
                <span class="timer">DAY</span>
                <span class="timer-1">HOURS</span>
                <span class="timer-2">MINUTES</span>
                <span class="timer-3">SECONDS</span>
            </ul>
        </div>
        <div class="form">

                <input class="comingsoon" type="text" id="name" placeholder="Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'"/>
                <input class="comingsoon" type="text" id="email" placeholder="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'email'"/>
                <button id="submit" class="comingsoon button">PRE ORDER NOW</button>

        </div>
    </div>
    <div class="footer">
       <p>Copyrights &copy; 2017 TransactionMusic.com is designed and maintained by
        <a href="http://elwci.com/" target="_blank"> <img src="images/elwc1.gif" alt=""></a>
        </p>

        <div class="logo2 pull-right">
            <a href="https://transactioncity.com/" target="_blank"><img
                    src="images/transactioncitylogolonglightoldstyle.png" width="200px"></a>
        </div>
    </div>
</div>
<!--/header-->
</body>
</html>