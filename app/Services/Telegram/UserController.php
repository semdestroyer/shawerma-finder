<?php


namespace App\Services\Telegram;


use App\Models\TelegramUser;
use App\Services\Telegram\Facades\TeleView;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Update;

class UserController
{
    public function createUser(BotApi $bot,Update $update)
    {

        $id = $update->getMessage()->getChat()->getId();
        try
        {
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
        $view = TeleView::getView("main_menu");
        TeleView::render($view,$bot,$update);
    }
}
