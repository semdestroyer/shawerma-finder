<?php
return
[
    '/start'=>[\App\Services\Telegram\CommandController::class,"start"],
    'Вернуться'=>[\App\Services\Telegram\UI\ViewController::class,'render','main_menu'],
    'default'=>['',''],
    'add'=>[\App\Services\Telegram\UI\ViewController::class,'render','shawerma_point'],
    'find'=>[\App\Services\Telegram\UI\ViewController::class,'render','near_shawerma'],
    'wait_location_near'=>[\App\Services\Telegram\GeoController::class,'addPoint'],
    'wait_location_create'=>[\App\Services\Telegram\GeoController::class,'addPoint'],

];
