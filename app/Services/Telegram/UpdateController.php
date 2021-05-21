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
        $routes = TeleView::getView("routes");
        $this->bot = $bot;
        $this->update = $update;
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
        if($user->state != "default")
        {
            $this->handle_callback($update,$bot);
        }
        else
        {
            $this->handle_state();
        }

    }
    private function handle_callback(Update $update,BotApi $bot)
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
    private function handle_state()
    {

    }

}
