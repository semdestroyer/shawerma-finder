<?php


namespace App\Services\Telegram\Core;


use Illuminate\Support\Facades\Facade;

class TeleCache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TelegramCaching::class;
    }

}
