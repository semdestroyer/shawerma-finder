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
            foreach ($routes as $route)
            {
                if (!empty($route[$update->getMessage()->getText()]))
                {
                 //   $this->render($route[$update->getMessage()->getText()]);
                }
            }
        }
        else if (!empty($update->getCallbackQuery()))
        {
            foreach ($routes as $route)
            {
                if (!empty($route[$update->getCallbackQuery()->getData()])) {
                    call_user_func($route[$update->getCallbackQuery()->getData()]);
                }
            }
        }

    }

}
