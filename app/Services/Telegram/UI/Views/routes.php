<?php
return
[
    '/start'=>[\App\Services\Telegram\UserController::class,"createUser"],
    'default'=>['',''],
    'add'=>[\App\Services\Telegram\UI\ViewController::class,'render','shawerma_point'],
    'find'=>[\App\Services\Telegram\UI\ViewController::class,'render','near_shawerma'],
];
