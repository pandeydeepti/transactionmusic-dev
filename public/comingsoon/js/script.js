$(function () {

    var global_message = '';
    $(function () {

        function validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

        $("button").click(function (e) {
            e.preventDefault();
            var $response_wrapper = $(".response-div");

            var name = $("#name").val();
            var email = $("#email").val();

            if( name.length < 2 ){
                $response_wrapper.html('Please enter a valid name');
                $response_wrapper.animate({
                    left: 0
                }, 700, function(){
                    var timeout = setTimeout( function(){
                        $response_wrapper.animate({
                            left: '-25%'
                        });
                    }, 3000);

                });

                return;
            }

            if( email.length < 5 || !validateEmail(email)){
                $response_wrapper.html('Please enter a valid email');
                $response_wrapper.animate({
                    left: 0
                }, 700, function(){
                    var timeout = setTimeout( function(){
                        $response_wrapper.animate({
                            left: '-25%'
                        });
                    }, 3000);

                });

                return;
            }

            $(".loader").fadeIn();

            var data = {
                name: name,
                email: email
            };

            $.ajax({
                type: "POST",
                url: "check.php",
                data: data,
                dataType: "json",
                success: function (responsecode) {
                    $(".loader").fadeOut();
                    $("#name").val('');
                    $("#email").val('');

                    var responseText = '';

                    if( responsecode.result == 'success' ){
                        responseText = 'Thank you for your interest.  In the next upcoming weeks we will be contacting you for account creation!';
                    } else {
                        responseText = responsecode.result;
                    }
                    $response_wrapper.html(responseText).animate({
                        left: 0
                    }, 700, function(){

                        var timeout = setTimeout( function(){
                            $response_wrapper.animate({
                                left: '-25%'
                            });
                        }, 5000);

                    });
                }
            });

            return false;
        });
    });

    Date.prototype.addDays = function (days) {
        this.setDate(this.getDate() + parseInt(days));
        return this;
    };

    var note = $('#note'),
        ts = new Date(2017, 01, 02),
        newYear = true;

    if ((new Date()) > ts) {
        // The new year is here! Count towards something else.
        // Notice the *1000 at the end - time must be in milliseconds
        ts = (new Date()).getTime() + 10 * 24 * 60 * 60 * 1000;
        newYear = false;
    }
    $('#countdown').countdown({
        timestamp: new Date('2017-01-02').getTime(),
        callback: function (days, hours, minutes, seconds) {

            var message = "";

            message += days + " day" + ( days == 1 ? '' : 's' ) + ", ";
            message += hours + " hour" + ( hours == 1 ? '' : 's' ) + ", ";
            message += minutes + " minute" + ( minutes == 1 ? '' : 's' ) + " and ";
            message += seconds + " second" + ( seconds == 1 ? '' : 's' ) + " <br />";

            global_message = message;
            if (newYear) {
                message += "left until the new year!";
            }
            else {
                message += "left to 10 days from now!";
            }

            note.html(message);
        }
    });

});
