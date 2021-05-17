<?php


namespace App\Services\Telegram;


use App\Models\TelegramUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TelegramBot\Api\Types\Update;

class UserController
{
    public function createUser(Update $update)
    {

        $id = $update->getMessage()->getChat()->getId();
        try {
            $user = TelegramUser::where('telegram_id', $id)->take(1)->firstOrFail();
        }
        catch (ModelNotFoundException $e)
        {

            $user = new TelegramUser();
            $user->telegram_id = $id;
            $user->username = $update->getMessage()->getFrom()->getUsername();
            $user->role = "user";
            $user->state = "default";
            $user->save();
        }
    }
}
