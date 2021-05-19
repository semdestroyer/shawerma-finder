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
                if (!empty($routes[$update->getMessage()->getText()])) {

                    $func = new $routes[$update->getMessage()->getText()][0];
                    $f = $routes[$update->getMessage()->getText()][1];
                    if (!empty($routes[$update->getMessage()->getText()][2]))
                    {
                        $args = !empty($routes[$update->getMessage()->getText()][2]);
                        $func->$f($args,$update,$bot);
                        return;
                    }
                    $func->$f($bot,$update);
                    return;


                }

        }
        else if (!empty($update->getCallbackQuery()))
        {

            if (!empty($routes[$update->getCallbackQuery()->getData()])) {

                $func = new $routes[$update->getCallbackQuery()->getData()][0];
                $f = $routes[$update->getCallbackQuery()->getData()][1];
                if (!empty($routes[$update->getCallbackQuery()->getData()][2]))
                {
                    //TODO: убрать фасад teleview за ненадобностью и использовать приватный
                    // getView внутри
                    $args = $routes[$update->getCallbackQuery()->getData()][2];
                    $view = TeleView::getView($args);

                    $func->$f($view,$bot,$update);

                    return;
                }
                $func->$f($bot,$update);
                return;


            }
        }

    }

}
