<?php
return array(
   
   // set your paypal credential
    'client_id' => 'AQ0resocCpzc1Ft9Ca9TgOQ5Zt6Y-hrmmNyFEn1jyEMwJttmz2JcYosn6sQXDibyCun57s_IhBNiUdXy',
    'secret' => 'ED6A1LNGktXblaBN6lNXrJeTKzJworO_DUFsf0KuHeV2G1RBv9cndi8P5a3W4IQUnz_fxi3qVQFhHmhH',


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
