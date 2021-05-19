<?php


namespace App\Services\Telegram\UI;


use App\Models\TelegramUser;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;
use TelegramBot\Api\Types\Update;

class ViewController
{
    public function render($menu_array, BotApi $bot, Update $update)
    {
        if($menu_array["clear_previous_reply"] == true)
        {
            //TODO make trick with message
        }
        if($menu_array["type"] == "text") {
            if ($menu_array["reply_type"] == "keyboard") {
                $keyboard = new ReplyKeyboardRemove();
                if (!empty($menu_array["keys"])) {
                    $keyboard = new ReplyKeyboardMarkup($menu_array["keys"]);
                    if($menu_array["set_one_time"] == true)
                    {
                        $keyboard->setOneTimeKeyboard(true);
                    }
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


            $id = $update->getMessage()->getChat()->getId();
            try
            {
                $user = TelegramUser::where('telegram_id', $id)->take(1)->firstOrFail();
                $user->state = $menu_array["state"];
                $user->save();
            }
            catch (ModelNotFoundException $e)
            {}
        }

    }
    public function getView($name)
    {
        return include("Views/".$name.'.php');
    }


}
