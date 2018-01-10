<?php
return array(
    // set your paypal credential
    'client_id' => 'AZI8AivWZSccbXBmJwdeV2tXQQdAAyFxt4WstjQpdoVbNnPItNOme0B_kCM14_KUfmuzQL-SFQF7GU85',
    'secret' => 'EA922kt5j2K9rWMK_IRWngC3sQK5OohkrTBrHHTM1wFn7vIwUBkOCyYeP3aXkw3edsTGjpQo8CJJUjXn',

    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);