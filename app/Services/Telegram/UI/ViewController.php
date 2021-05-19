<?php


namespace App\Services\Telegram\UI;


use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;
use TelegramBot\Api\Types\Update;

class ViewController
{
    public function render($menu_array, BotApi $bot, Update $update)
    {
        if($menu_array["type"] == "text") {
            if ($menu_array["reply_type"] == "keyboard") {
                $keyboard = new ReplyKeyboardRemove();
                if (!empty($menu_array["keys"])) {
                    $keyboard = new ReplyKeyboardMarkup($menu_array["keys"]);
                }
            }
            if ($menu_array["reply_type"] == "buttons") {
                $keyboard = new ReplyKeyboardRemove();
                if (!empty($menu_array["buttons"])) {
                    $keyboard = new InlineKeyboardMarkup($menu_array["buttons"]);
                }
            }
            if (!empty($update->getMessage())) {
                $bot->sendMessage($update->getMessage()->getChat()->getId(),
                    $menu_array["text"], null, null, null, $keyboard);
            }
            else
            {
                $bot->sendMessage($update->getCallbackQuery()->getFrom()->getId(),
                    $menu_array["text"], null, null, null, $keyboard);
            }
        }
    }
    public function getView($name)
    {
        return include("Views/".$name.'.php');
    }


}
