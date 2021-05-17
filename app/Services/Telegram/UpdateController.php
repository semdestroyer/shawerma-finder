<?php


namespace App\Services\Telegram;




use App\Models\TelegramUser;
use App\Services\Telegram\Facades\TeleView;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;
use TelegramBot\Api\Types\Update;
class UpdateController
{
    private $bot;
    private $update;
    public function onUpdate(Update $update,BotApi $bot)
    {
        $routes = TeleView::getView("routes");
        $this->bot = $bot;
        $this->update = $update;

        if(!empty($update->getMessage()))
        {
                if (!empty($routes[$update->getMessage()->getText()]))
                {
                 //   $this->render($route[$update->getMessage()->getText()]);


                    $func = new $routes[$update->getMessage()->getText()][0];
                 // error_log(json_encode($routes[$update->getMessage()->getText()][1]));
                    $f = $routes[$update->getMessage()->getText()][1];

                    $func->$f($update);

                }

        }
        else if (!empty($update->getCallbackQuery()))
        {


                if (!empty($routes[$update->getCallbackQuery()->getData()])) {
                    call_user_func($routes[$update->getCallbackQuery()->getData()]);
                }

        }

    }

}
