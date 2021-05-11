<?php


namespace App\Services\Telegram;




use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;
use TelegramBot\Api\Types\Update;
class UpdateController
{
    public function onUpdate(Update $update,BotApi $bot)
    {
//        $bot->sendMessage($update->getMessage()->getChat()->getId(),"ля ты крыса");
        $main = include("UI/Views/main_menu.php");
        $shawerma =   include("UI/Views/near_shawerma.php");
        $shawermapoint =  include("UI/Views/shawerma_point.php");
        $view = $main;
        if(!empty($update->getMessage()))
        {
            $this->render($view, $bot, $update);
        }
        else if (!empty($update->getCallbackQuery()))
        {

        }

    }
    private function render($menu_array, BotApi $bot, Update $update)
    {
        if($menu_array["type"] == "text")
        {
            if ($menu_array["reply_type"] == "keyboard")
            {
                $keyboard = new ReplyKeyboardRemove();
                if (!empty($menu_array["keys"]))
                {
                    $keyboard = new ReplyKeyboardMarkup($menu_array["keys"]);
                }
            }
            if ($menu_array["reply_type"] == "buttons")
            {
                $keyboard = new ReplyKeyboardRemove();
                if (!empty($menu_array["buttons"]))
                {
                    $keyboard = new InlineKeyboardMarkup($menu_array["buttons"]);
                }
            }

            $bot->sendMessage($update->getMessage()->getChat()->getId(),
                $menu_array["text"],null,null,null,$keyboard);
        }
    }
}
