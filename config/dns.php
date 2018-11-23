<?php

return [

    'nameservers' => [

        env('DNS_PRIMARY_NAMESERVER', 'ns1.huytq.me'),
        env('DNS_SECONDARY_NAMESERVER', 'ns2.huytq.me'),

    ],

    'master' => env('DNS_MASTER_IP', '123.30.187.240'),

];
