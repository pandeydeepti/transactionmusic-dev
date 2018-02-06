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

var player = angular.module('myApp', ['ngRateIt', 'angularSoundManager', 'localytics.directives']);
player.config(function($locationProvider) {
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });
});

player.service('cartService', function(){

    var cart = [];

    return {
        getCartItemsNumber: function () {
            return Object.keys(cart).length;
        },
        getCart: function () {
            return cart;
        },
        addToCart: function ( song ) {
            cart.push( song );
        },
        removeFromCart: function ( index ) {
            cart.splice( index, 1 );
        },
        checkIfAnyBought: function( song ){
            var result_array = [];

            for( var i = 0; i < Object.keys(song.files).length; i++ ){

                if( (song.files[ Object.keys(song.files)[i] ].bought == true ) ){
                    result_array.push( true );
                } else {
                    result_array.push( false );
                }

            }

            return result_array;
        },
        getIndexInCart: function( id ){
            for( var i = 0; i < Object.keys(cart).length; i++ ){

                if( cart[i].id == id ){
                    return i;
                }

            }
        },
        getIndexInCartTotal: function(){

            var total = 0;

            for( var i = 0; i < Object.keys(cart).length; i++ ){

                total += this.getItemPriceSum( cart[i] );

            }

            return Math.round(total * 100) / 100;
        },
        getItemPriceSum: function( song ){

            var sum = 0;

            for( var i = 0; i < Object.keys(song.files).length; i++ ){

                if( (song.files[ Object.keys(song.files)[i] ].bought == true ) ){
                    sum += parseFloat(song.files[ Object.keys(song.files)[i]].price);
                }

            }

            return sum;
        }

    };

})
player.service('ratingService', function( $http ){

    return {
        parseRateAmout: function( rateAmountUnparsed ){
            return ( rateAmountUnparsed * 2 ) * 10;
        },
        parseRateAmountBack: function( rateAmountUnparsed ){
            return parseFloat(( rateAmountUnparsed / 2 ) / 10);
        },
        rateSong: function( songs, rateAmount, index ){
            var song = songs[ index ];
            var rateAmount = this.parseRateAmout( rateAmount );


            return $http({
                method: 'POST',
                url: song.instance.url+'/api/rates',
                headers: {
                    'Content-Type' : 'application/x-www-form-urlencoded',
                },
                data: $.param({
                    'beat_id'       : song.beat_id,
                    'amount'        : rateAmount,
                }),
            });

        }
    };

})
player.controller('MainCtrl', function ($scope, angularPlayer, cartService, ratingService, $q ) {
    var ajaxInProgress = false;

    $scope.songs = [];
    $scope.newsongs = [];
    $scope.cart = [];
    $scope.filters = lf.data.filters;
    $scope.soundManager = angularPlayer.getSoundMaster();
    $scope.songProgress = 0;
    $scope.isMouseDownOnSeek = false;
    $scope.itemsSelected = 0;
    $scope.cartTotalPrice = 0;
    $scope.bar = '';
    $scope.volume_level = localStorage.getItem('playerVolume') != null ? localStorage.getItem('playerVolume') : 50;
    $scope.sortByCustom = [
        'title',
        'artist',
        'rating',
        'bpm'
    ];

    $scope.updateIndex = function(){
        var timeout = setTimeout( function(){
            $scope.$apply();
        }, 100);
    }

    angularPlayer.updateVolume( $scope.volume_level );

    $scope.convertTitleToSlug = function( Text ){

        if( Text != undefined ){

            Text = Text
                .replace(/ /g,'-')
                .replace(/[^\w-]+/g,'')
            ;
        }

        return Text
    }

    $scope.setCurrentRatingIndex = function( index, rateAmount ){

        if( ajaxInProgress ) return;

        ajaxInProgress = true;

        var d = $q.defer();

        var response = ratingService.rateSong( $scope.songs, rateAmount, index );

        response.then(function(response) {

            var code = response.data.code;
            var value = response.data.value;
            var result = response.data.result;

            var responseObject = {
                success: false,
                message: result,
                value: ratingService.parseRateAmountBack( value )
            }

            switch ( code ){
                case 200 :
                    responseObject.success = true;
                    break;
                default :
                    responseObject.success = false;
            }

            $scope.songs[ index ].rating = responseObject.value;
            ajaxInProgress = false;
        });

        return d.promise;

    }


    $scope.updateVolume = function(value){
        localStorage.setItem('playerVolume', value);
        angularPlayer.updateVolume( value );
    }

    $scope.$on('track:progress', function(event, args) {
        if( !$scope.isMouseDownOnSeek ){
            $scope.songProgress = args;
        }
    });

    $scope.$on('track:id', function() {
        angularPlayer.updateVolume( $scope.volume_level );
    });

    $scope.$on('angularPlayer:ready', function(event, args) {
        $('.not-ready').animate({opacity: 1});

        //add songs to playlist
        for(var i = 0; i < $scope.songs.length; i++) {
            angularPlayer.addTrack($scope.songs[i]);
        }

         var song_title = getParameterByName('title');

        if( song_title != null ){

            var found = false;

            angular.forEach($scope.songs, function( song, taxtitle ){

                if( song.slug == song_title ){
                    angularPlayer.setCurrentTrack( song.id );
                    angularPlayer.initPlayTrack( song.id, true, true );
                    angularPlayer.play();
                    found = true;
                }
            });

            if( !found ){
                angularPlayer.setCurrentTrack( $scope.songs[0].id );
                angularPlayer.initPlayTrack( $scope.songs[0].id, true, true );
            }

        } else{
            angularPlayer.setCurrentTrack( $scope.songs[0].id );
            angularPlayer.initPlayTrack( $scope.songs[0].id, true, true );
        }

    });


    $scope.setSeek = function(){

        $(document).on('input mousedown', ".seekLoad", function(){
            $scope.isMouseDownOnSeek = true;
        });

        $(document).on('mouseup', ".seekLoad", function(){
            $scope.isMouseDownOnSeek = false;

            var seekTime = $(".seekLoad").val();
            var sound = $scope.soundManager.getSoundById(angularPlayer.getCurrentTrack());


            if (angularPlayer.getCurrentTrack() === null) {
                console.log('no track loaded');
                return;
            }

            sound.setPosition((seekTime / 100) * sound.durationEstimate);
        });
    }

    for (var i = 0; i < Object.keys(lf.data.beats).length; i++) {

        $scope.songs.push({
            index: i + 1,
            id: i + 1,
            slug: $scope.convertTitleToSlug(lf.data.beats[i].beat_title),
            beat_id: lf.data.beats[i].beat_id,
            title: lf.data.beats[i].beat_title,
            bpm: lf.data.beats[i].bpm,
            cover: lf.data.beats[i].beat_cover,
            rating: ratingService.parseRateAmountBack(lf.data.beats[i].rate),
            url: lf.data.beats[i].beat_files.mp3.file_path,
            country_code: lf.data.beats[i].country_code,
            categories: {
                names: lf.data.beats[i].category_list,
                covers: lf.data.beats[i].category_cover
            },
            sounds_like: {
                names: lf.data.beats[i].sounds_like,
            },
            producer: {
                names: lf.data.beats[i].producer,
            },
            artist: lf.data.beats[i].producer.join(', '),
            instance: {
                name: lf.data.beats[i].instance.name,
                url: lf.data.beats[i].instance.url,
                email: lf.data.beats[i].paypal_email,
            },
            files: {
                mp3: {
                    price: lf.data.beats[i].beat_files.mp3.file_price,
                    bought: false
                },
                wav: {
                    price: lf.data.beats[i].beat_files.wav.file_price,
                    bought: false
                },
                tracked_out: {
                    price: lf.data.beats[i].beat_files.tracked_out.file_price,
                    bought: false
                },
                exclusive: {
                    price: lf.data.beats[i].beat_files.exclusive.file_price,
                    bought: false
                },
            }
        });
    }
    angular.forEach($scope.filters, function( element, taxtitle ){

         //TODO: Beat controller change JSON return type
        var tax_object = {
            id      : 0,
            title   : taxtitle.toUpperCase(),
            cover   : element.cover
        };
        if( !element.categories.containsObjectID( tax_object )  )
            element.categories.unshift( tax_object );

    });
    
    
    for (var i = 0; i < Object.keys(lf.newdata.beats).length; i++) {

        $scope.newsongs.push({
            index: i + 1,
            id: i + 1,
            slug: $scope.convertTitleToSlug(lf.newdata.beats[i].beat_title),
            beat_id: lf.newdata.beats[i].beat_id,
            title: lf.newdata.beats[i].beat_title,
            bpm: lf.newdata.beats[i].bpm,
            genre: lf.newdata.beats[i].genre.join(', '),
            added:lf.newdata.beats[i].beat_created_at,
            cover: lf.newdata.beats[i].beat_cover,
            rating: ratingService.parseRateAmountBack(lf.newdata.beats[i].rate),
            url: lf.newdata.beats[i].beat_files.mp3.file_path,
            country_code: lf.newdata.beats[i].country_code,
            categories: {
                names: lf.newdata.beats[i].category_list,
                covers: lf.newdata.beats[i].category_cover
            },
            sounds_like: {
                names: lf.newdata.beats[i].sounds_like,
            },
            producer: {
                names: lf.newdata.beats[i].producer,
            },
            artist: lf.newdata.beats[i].producer.join(', '),
            instance: {
                name: lf.newdata.beats[i].instance.name,
                url: lf.newdata.beats[i].instance.url,
                email: lf.newdata.beats[i].paypal_email,
            },
            files: {
                mp3: {
                    price: lf.newdata.beats[i].beat_files.mp3.file_price,
                    bought: false
                },
                wav: {
                    price: lf.newdata.beats[i].beat_files.wav.file_price,
                    bought: false
                },
                tracked_out: {
                    price: lf.newdata.beats[i].beat_files.tracked_out.file_price,
                    bought: false
                },
                exclusive: {
                    price: lf.newdata.beats[i].beat_files.exclusive.file_price,
                    bought: false
                },
            }
        });
    }

    /* Update cart data */
    $scope.updateCartPrice = function( fileType, song ){

        song.files[fileType].bought = !song.files[fileType].bought;

        if( fileType == 'exclusive' ){

            angular.forEach(song.files, function( item, type ){
                if( type != 'exclusive' ){
                    item.bought = false;
                }
            });
        }

        var anyBought = cartService.checkIfAnyBought( song ).contains(true);

        if( cartService.getCart().contains( song ) ){

            cartService.removeFromCart( cartService.getIndexInCart( song.id ) );

            if( anyBought ){
                cartService.addToCart( song );
            }

        } else {
            cartService.addToCart( song );
        }

        $scope.itemsSelected = cartService.getCartItemsNumber();
        $scope.cartTotalPrice = cartService.getIndexInCartTotal();
        $scope.cart = cartService.getCart();
    }

    $scope.copyToClipboard = function(element) {
        var $temp = $("<input>");
        $temp.hide(0);
        console.log($temp);
        $("body").append($temp);
        $temp.val($(element).val()).select();

        document.execCommand("copy");
        $temp.remove();
    }

    $scope.share_window = function( currentPlaying, type, shop_url ){

        var w = 626;
        var h = 436;

        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;

        var href = '';
        if( type == 'facebook' ){
            href = "https://www.facebook.com/sharer/sharer.php?u=" + shop_url + "?title="+ currentPlaying.slug +"&picture="+ currentPlaying.cover +"&title="+ currentPlaying.title +"&summary="+ currentPlaying.title + '<p>'+ currentPlaying.artist +'</p>';
        } else if( type == 'twitter' ){
            href = "http://twitter.com/share?text="+ currentPlaying.title +"&url=" + shop_url + "?title="+ currentPlaying.slug +"&hashtags="+ currentPlaying.artist;
        }

        window.open(href, 'Post to '+ type.toUpperCase() +': ' + currentPlaying.slug, 'toolbar=0,status=0,width=' + w + ',height=' + h + ', top=' + top + ', left=' + left);

    }

    $scope.get_file_types_bought = function( item ){
        var file_types_string = [];

        for( var i = 0; i < Object.keys(item.files).length; i++ ){
            if( item.files[ Object.keys(item.files)[i] ].bought ){
                file_types_string.push( Object.keys(item.files)[i].replace("_", " ") );
            }
        }


        return file_types_string.join(", ").toUpperCase();
    }

});


player.filter('customFilter', function () {

    return function (items, filterData) {

        var filter_array = [];
        var return_items = [];

        if( filterData != undefined ){
            for( var key in filterData ){

                if( filterData[ key ] != key.replace('_', ' ').toUpperCase() )
                    filter_array.push(filterData[ key ]);
            }
        }

        if( filterData == undefined ) return items;

        angular.forEach(items, function(value1, key1) {

            if (value1.categories.names.containsArray(filter_array) || value1.sounds_like.names.containsArray(filter_array) || value1.producer.names.containsArray(filter_array)) {
                if( return_items.indexOf(value1) == -1 ){
                    return_items.push(value1);
                }
            }

        });

        return return_items;

    };
});
player.filter('capitalize', function() {
    return function(input) {
        return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});
player.filter('bootify', function() {
    return function(input) {
        var bootify = (!!input) ? input.toUpperCase() : '';
        bootify = bootify.replace('_', ' ');
        return bootify
    }
});
player.filter('calculate_bought_beats', function () {
    return function (array) {

        var total = 0;

        for( var i = 0; i < Object.keys(array).length; i++ ){
            if( array[ Object.keys(array)[i] ].bought ){
                total += array[ Object.keys(array)[i] ].price;
            }
        }
        return Math.round( total * 100 ) / 100;
    };
});
player.filter('implodeFiletypes', function () {
    return function (array) {

        var file_types_string = [];

        for( var i = 0; i < Object.keys(array).length; i++ ){
            if( array[ Object.keys(array)[i] ].bought ){
                file_types_string.push( Object.keys(array)[i].replace("_", " ") );
            }
        }

        return file_types_string.join(", ").toUpperCase();
    };
});


