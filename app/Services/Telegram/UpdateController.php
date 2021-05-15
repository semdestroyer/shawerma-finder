<?php


namespace App\Services\Telegram;




use App\Models\TelegramUser;
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
        $mc = new MenuController();
        $routes = $mc->getView("routes");
        $this->bot = $bot;
        $this->update = $update;

        if(!empty($update->getMessage()))
        {

            if(!empty($routes[$update->getMessage()->getText()]))
            {
                $this->render($routes[$update->getMessage()->getText()]);
            }

        }
        else if (!empty($update->getCallbackQuery()) && !empty($routes[
            $update->getCallbackQuery()->getData()]))
        {
            call_user_func($routes[
            $update->getCallbackQuery()->getData()]);
        }

    }
    private function render($menu_array)
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

            $this->bot->sendMessage($this->update->getMessage()->getChat()->getId(),
                $menu_array["text"],null,null,null,$keyboard);
        }
    }

}
