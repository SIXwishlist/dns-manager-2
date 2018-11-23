<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'bind' => [
            'driver' => 'local',
            // 'host' => env('DNS_MASTER_IP', '123.30.187.240'),
            // 'port' => 22,
            // 'username' => 'root',
            // 'privateKey' => base_path('id_rsa'),
            'root' => env('BIND_CONFIG_DIR', '/etc/bind'),
            // 'timeout' => 10,
            // 'directoryPerm' => 0755,
        ],

        'bind_slave' => [
            'driver' => 'sftp',
            'host' => env('DNS_SLAVE_IP', '123.30.187.202'),
            'port' => 22,
            'username' => 'root',
            'privateKey' => base_path('id_rsa'),
            'root' => env('BIND_CONFIG_DIR', '/etc/bind'),
            'timeout' => 10,
            'directoryPerm' => 0755,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => 'your-key',
            'secret' => 'your-secret',
            'region' => 'your-region',
            'bucket' => 'your-bucket',
        ],

    ],

];
