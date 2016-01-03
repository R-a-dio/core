<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Hanyuu's Config (Python)
    |--------------------------------------------------------------------------
    |
    | Here you may specify the irc bot, afk streamer and request fastcgi server
    | config. It's a simple key-value array that will be translated into raw
    | python code, with dicts and arrays, by using json translation first.
    |
    */
    'hanyuu/config.py' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Loadbalancer Config (JSON)
    |--------------------------------------------------------------------------
    |
    | Here you may specify the loadbalancer's relay config, which will accept
    | requests at http://stream.radio.app/main.mp3 in player of your choice.
    | The default will cause your loadbalancer to stream from production.
    |
    */
    'loadbalancer/relays.json' => [
        'radio' => [
            'active' => false,
            'type' => env('LOADBALANCER_PRIMARY_TYPE', 'https'),
            'name' => env('LOADBALANCER_PRIMARY_NAME', 'R/a/dio Primary'),
            'stream' => env('LOADBALANCER_PRIMARY_STREAM', 'https://stream.r-a-d.io/main.mp3'),
            'max' => env('LOADBALANCER_PRIMARY_MAX', 1200),
            'priority' => env('LOADBALANCER_PRIMARY_PRIORITY', 100),
            'links' => [
                'status' => env('LOADBALANCER_PRIMARY_STREAM', 'https://stream.r-a-d.io/main.mp3') . '.xspf',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | radio.queue Config (JSON)
    |--------------------------------------------------------------------------
    |
    | Here you may specify the queue's config, which will run as a service on
    | port 33999 by default. This is an RPC server that stores the current
    | song queue for the afk streamer, and allows adding/seeding requests.
    |
    */
    'hanyuu/queue_config.json' => [

        env('DB_DRIVER') => [
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('HANYUU_QUEUE_PORT', 33999),
            'db' => env('DB_DATABASE', 'radio'),
            'passwd' => env('DB_PASSWORD', ''),
            'user' => env('DB_USERNAME', 'root'),
            'charset' => 'utf8',
            'use_unicode' => true
        ],

        'music_root' => env('RADIO_MUSIC_PATH', storage_path('app/music')),
    ],

];
