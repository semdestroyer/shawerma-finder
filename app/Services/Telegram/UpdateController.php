<?php


namespace App\Services\Telegram;

use App\Models\TelegramUser;
use App\Services\Telegram\Facades\TeleView;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        $this->bot = $bot;
        $this->update = $update;

        if(!empty($update->getMessage()))
        {
            $id = $update->getMessage()->getChat()->getId();
            $username = $update->getMessage()->getFrom()->getUsername();
        }
        else if(!empty($update->getCallbackQuery()))
        {
            $id = $update->getCallbackQuery()->getFrom()->getId();
            $username = $update->getCallbackQuery()->getFrom()->getUsername();
        }
        try
        {
            $user = TelegramUser::where('telegram_id', $id)->take(1)->firstOrFail();
        }
        catch (ModelNotFoundException $e)
        {

            $user = new TelegramUser();
            $user->telegram_id = $id;
            $user->username = $username;
            $user->role = "user";
            $user->state = "";
            $user->save();
        }
        $state = $user->state;
        if(!empty($state))
        {
            $this->handle_state($user,$update,$bot);
        }
        else
        {
            $this->handle_callback($update,$bot);
        }

    }
    private function handle_callback(Update $update,BotApi $bot)
    {
        $routes = TeleView::getView("routes");
        if(!empty($update->getMessage()))
        {
        if(!empty($update->getMessage()->getText()))
        {
            if (!empty($routes[$update->getMessage()->getText()])) {
                $func = new $routes[$update->getMessage()->getText()][0];
                $f = $routes[$update->getMessage()->getText()][1];
                if (!empty($routes[$update->getMessage()->getText()][2]))
                {
                    $args = $routes[$update->getMessage()->getText()][2];
                    $view = TeleView::getView($args);
                    $func->$f($view,$bot,$update);
                    return;
                }
                $func->$f($bot,$update);
                return;
            }

        }}
        else if (!empty($update->getCallbackQuery()))
        {
            $query = json_decode($update->getCallbackQuery()->getData(),true);
            $route = $query["route"];
            $data = $query["data"];
            if (!empty($route)) {

                $func = new $route[0];
                $f = $routes[1];
                if (!empty($route[2]))
                {
                    //TODO: убрать фасад teleview за ненадобностью и использовать приватный
                    // getView внутри
                    $args = $route[2];
                    $view = TeleView::getView($args);

                    $func->$f($view,$bot,$update);

                    return;
                }
                elseif (!empty($data))
                {
                    $args = $data;
                    $func->$f($args,$bot,$update);
                    return;
                }
                $func->$f($bot,$update);
                return;

            }
        }
    }
    private function handle_state(TelegramUser $user,Update $update,BotApi $bot)
    {
        $routes = TeleView::getView("routes");
        if(!empty($update->getMessage()))
        {
                $func = new $routes[$user->state][0];
                $f = $routes[$user->state][1];
                $func->$f($bot,$update);
                return;
        }
    }

}
