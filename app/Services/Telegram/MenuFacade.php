<?php


namespace App\Services\Telegram;


use Illuminate\Support\Facades\Facade;

class MenuFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MenuController::class;
    }
}
