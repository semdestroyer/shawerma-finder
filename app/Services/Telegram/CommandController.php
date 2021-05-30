<?php


namespace App\Services\Telegram;


use App\Models\TelegramUser;
use App\Services\Telegram\Facades\TeleView;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Update;

class CommandController
{
    public function start(BotApi $bot,Update $update)
    {
        $view = TeleView::getView("main_menu");
        TeleView::render($view,$bot,$update);
    }
}
