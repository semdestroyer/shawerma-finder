<?php


namespace App\Services\Telegram\Core;
use TelegramBot\Api\BotApi;
use EvPeriodic;
class Updater
{
    public function handleUpdates(string $token)
    {
        $bot = new BotApi($token);
        $updates = $bot->getUpdates();
        if($updates)
        {
           $update = new Update();
           $update->setChatID($updates[]);
           $update->setData($updates[]);
        };
    }


}
