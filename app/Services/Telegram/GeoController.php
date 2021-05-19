<?php


namespace App\Services\Telegram;


use App\Models\Shawerma;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Update;

class GeoController
{
    public function addPoint(Update  $update, BotApi $bot)
    {
        $shawerma = New Shawerma();
        $shawerma->longtitude = $update->getMessage()->getLocation()->getLongitude();
        $shawerma->latitude = $update->getMessage()->getLocation()->getLatitude();
        $shawerma->save();
    }
    public function getPoints(Update  $update, BotApi $bot)
    {
        $shawerma = New Shawerma();
        $shawerma->save();
    }
}
