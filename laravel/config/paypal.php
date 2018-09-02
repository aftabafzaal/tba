<?php

return [
    'express' => [
        'client_id' => 'AZczC1AYlUuYuZTwbnVjd1FE0qc_yEcM-KqNsLLCJEA334Gimm27bwq7-WkpGjHy6CEp6kvfknGoeH6q',
        'secret' => 'EDTX4LK-oEEfm3Lh-lbNPX_u34awHNn9gPVhWiPEq4XuZLoB7lBvFXTbwpaR2s2bCLlfjzE7QvnAeaLF',
        'success' => 'Payments\PaypalController@success',
        'cancel' => 'Payments\PaypalController@cancel',
        'config' =>
        [
            'mode' => 'sandbox',
            'service.EndPoint' => 'https://api.sandbox.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ]
    ],
    'mode' => 'sandbox',
    'sandbox' => [
        'username' => 'aftab.golpik-facilitator_api1.gmail.com', // Api Username
        'password' => 'ZC78JJW76MKGEFQH', // Api Password
        'secret' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AmI.TwmaKtJkNzeEDVZX-NrsHQY.', // This refers to api signature
        'certificate' => '', // Link to paypals cert file, storage_path('cert_key_pem.txt')
    ],
    'live' => [
        'username' => '', // Api Username
        'password' => '', // Api Password
        'secret' => '', // This refers to api signature
        'certificate' => '', // Link to paypals cert file, storage_path('cert_key_pem.txt')
    ],
    'payment_action' => 'Sale', // Can Only Be 'Sale', 'Authorization', 'Order'
    'currency' => 'USD',
    'notify_url' => '',
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
];
