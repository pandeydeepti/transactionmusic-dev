<?php
return array(
   
   // set your paypal credential
    'client_id' => 'ATOQp9Nup9kNXpU-rU_EKbBnV95jIMf1SWMuENFOpcNKv7UFeq5WkeXfqYcGpVlfXLUHRQ_swWZjmplj',
    'secret' => ' ECIf-pPdobpDxD92jZzXEaHGgaK3HIvRSxGKTH7-uWy2Td0YqvVGclLaxwigKjJRycNFhnzx384ylq0t',


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
