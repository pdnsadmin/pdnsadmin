<?php
/*created by Ha Ngo*/
return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'apiconnect' => [
        'api_key'       => '',
        'api_server'    => '',
        'ns1'           =>  'ns1.novaweb.vn',
        'ns2'           =>  'ns2.novaweb.vn',
        'hostmaster'    =>  'powerapi.devhub.vn',
        'serial'        =>  date("Ymd").'00',
        'text'          =>  '28800 7200 604800 86400',
        'ttl'           =>  '86400',


    ],
    'debug' =>[
        'turnon'=>1,
        'write'=>1,
    ]  
    ];
?>