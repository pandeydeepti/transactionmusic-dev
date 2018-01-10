Array.prototype.containsArray = function ( array /*, index, last*/ ) {

    if( arguments[1] ) {
        var index = arguments[1], last = arguments[2];
    } else {
        var index = 0, last = 0; this.sort(); array.sort();
    };

    return index == array.length
        || ( last = this.indexOf( array[index], last ) ) > -1
        && this.containsArray( array, ++index, ++last );

};

Array.prototype.contains = function( object ) {

    var i = this.length;
    while (i--) {
        if (this[i] === object) {
            return true;
        }
    }
    return false;
}

Array.prototype.containsObjectID = function( object ) {

    var i = this.length;
    while (i--) {

        if ( this[i].id === object.id ){
            return true;
        }
    }
    return false;
}

function getParameterByName(name, url) {
    if (!url) {
        url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function toggleActiveFAQ( elem ){

        if( !$(elem).parent().find('.single-faq-content-wrapper').is(":visible") ){
            $(elem).removeClass('fa-caret-up').addClass('fa-caret-right');
        } else{
            $(elem).addClass('fa-caret-up').removeClass('fa-caret-right');
        }
}


$(document).ready(function ($) {
    alertify.set({ labels: {
        ok     : "Cancel",
        cancel : "Delete"
    }});
    //faq start
    $('.single-faq-content-wrapper:first').slideDown(500);
    $('.single-faq-title-wrapper:first').addClass('faq-expand-wrapper');
    $('.single-faq-title-wrapper:first').find('i').addClass('fa-caret-up').removeClass('fa-caret-right');

    $('.single-faq-title-wrapper').on('click', function(){
        $('.fa').removeClass('fa-caret-up').addClass('fa-caret-right');
        $('.single-faq-title-wrapper').removeClass('faq-expand-wrapper');
        $('.single-faq-content-wrapper').not( $(this).find('.single-faq-content-wrapper')).stop().slideUp(500);
        $(this).find('.single-faq-content-wrapper').stop().slideToggle(500, function(){
            toggleActiveFAQ( $(this).parent().find('i.fa') );
        });


        $(this).addClass('faq-expand-wrapper');
    });
    //faq end
    if(typeof lf != 'undefined' && lf.type != null  && lf.message != null){
        alertify[lf.type](lf.message);
    }
    //contact
    var patt = new RegExp(/^([a-zA-Z' ]){3,25}$/);

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    $("#btn-add-contact").on('click', function(e){
        e.preventDefault();
        var error = false;
        var name = $('#contact_name');
        var mail = $('#contact_email');
        var message = $('#contact_message');
        if(!patt.test(name.val())) {
            name.addClass('has-error-border');
            error = true;
            alertify.error('You have entered an invalid name. Please try again');
        } else{
            name.removeClass('has-error-border');
        }
        if(!validateEmail(mail.val())){
            mail.addClass('has-error-border');
            error = true;
            alertify.error('You have entered an invalid e-mail address. Please try again');
        } else {
            mail.removeClass('has-error-border');
        }
        if(message.val().length < 3){
            message.addClass('has-error-border');
            error = true;
            alertify.error('Please fill message');
        } else{
            message.removeClass('has-error-border');
        }
        if(error) {
        } else{
            $('#add_contact').submit();
        }
    });


    $('.chosen-results').slimScroll({
        height: '150px',
        color: '#19cefb',
        railVisible: true,
        railColor: '#a9aeb0',
        alwaysVisible: true,
        opacity: '1'
    });

    $('.songs-wrapper').slimScroll({
        height: '350px',
        color: '#19cefb',
        railVisible: true,
        railColor: '#a9aeb0',
        alwaysVisible: true,
        opacity: '1'
    });

    $('.menu-toggle').on('click', function() {
        $('.main-nav-header-wrapper').toggleClass('menu-active');
    });

    $(window).on("resize load", function () {
        if( $(window).width() <= 767 && $(window).width() > 380 ) {
            var biggest_height = 0;
            jQuery(".beat-single-content-inner-wrapper").each(function(){
                var this_height = jQuery(this).outerHeight();
                if( this_height > biggest_height ){
                    biggest_height = this_height;
                }
            });
            jQuery(".beat-single-content-inner-wrapper").css('height', biggest_height );
        } else {
            jQuery(".beat-single-content-inner-wrapper").css('height', 'auto' );
        }
    });

    $('.lf-select').on('change', function() {
        $(window).trigger('resize');
    });
});