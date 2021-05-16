<?php


namespace App\Services\Telegram\Facades;
use App\Services\Telegram\Core\TelegramCaching;
use Illuminate\Support\Facades\Facade;

class TeleCache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TelegramCaching::class;
    }

}
