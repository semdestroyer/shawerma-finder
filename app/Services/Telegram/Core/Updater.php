<?php


namespace App\Services\Telegram\Core;
use App\Events\OnUpdate;
use App\Services\Telegram\Facades\TeleCache;
use Illuminate\Support\Facades\Redis;
use TelegramBot\Api\BotApi;
use EvPeriodic;
class Updater
{

    public function handleUpdates(string $token)
    {
        $bot = new BotApi($token);


        while (true)
        {
            $updates = $bot->getUpdates();

            $savedups = TeleCache::loadUpdates();
            foreach ($updates as $update)
            {
                if (empty($savedups))
                {$savedups = [];}

                if (!in_array($update->getUpdateId(),$savedups))
                {
                    $savedups[] = $update->getUpdateId();
                    TeleCache::saveUpdates($savedups);
                    event(new OnUpdate($update, $bot));

                }
            }
            sleep(1);

        }
    }


}
