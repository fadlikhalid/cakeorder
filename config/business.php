<?php

return [
    'phone' => env('BUSINESS_PHONE', '010-2199 724'),
    'email' => env('BUSINESS_EMAIL', 'Vi\'s Baking'),
    'address' => env('BUSINESS_ADDRESS', '60-2, Jalan Putra Impiana 1, Taman Putra Impiana, 47120 Puchong, Selangor'),
    'hours' => [
        'open' => '09:00',
        'close' => '18:00',
        'days' => [
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ],
        'closed' => ['Monday']
    ]
]; 