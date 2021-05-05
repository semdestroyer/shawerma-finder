<?php


namespace App\Services\Telegram\Core;


use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Redis;
use TelegramBot\Api\Types\Update;

 class TelegramCaching
{
    public function loadUpdates()
    {
        $updates = Redis::get("updates");
        return json_decode($updates,true);
    }
    public function saveUpdates($updates)
    {
        $updates = Redis::set("updates", json_encode($updates));
    }
    public function clearCache()
    {

        $updates = Redis::get("updates");
        if($updates['time'] ==  time()+86400)
        {
            Redis::del($updates);
        }
    }

}
