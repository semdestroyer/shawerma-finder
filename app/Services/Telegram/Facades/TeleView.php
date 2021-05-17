<?php


namespace App\Services\Telegram\Facades;



use App\Services\Telegram\UI\ViewController;
use Illuminate\Support\Facades\Facade;

class TeleView extends Facade
{
       protected static function getFacadeAccessor()
       {
         return ViewController::class;
       }
}
