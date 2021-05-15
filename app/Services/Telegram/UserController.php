<?php


namespace App\Services\Telegram;


use App\Models\TelegramUser;
use TelegramBot\Api\Types\Update;

class UserController
{
    public function createUser(Update $update)
    {
        $id = $update->getMessage()->getChat()->getId();
        $user = TelegramUser::where('telegram_id', $id)->take(1)->get();


        if(empty($user))
        {
            $user = new TelegramUser();
            $user->telgram_id = $id;
            $user->role = "user";
            $user->state = "default";
            $user->save();
        }
    }
}
