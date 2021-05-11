<?php


namespace App\Services\Telegram;


class MenuController
{
    public function getView($name)
    {
        return include("UI/Views");
    }
}
