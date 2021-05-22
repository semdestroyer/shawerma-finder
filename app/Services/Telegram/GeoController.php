<?php


namespace App\Services\Telegram;

use App\Models\Shawerma;
use App\Models\TelegramUser;
use App\Services\Telegram\Facades\TeleView;
use App\User;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\Location;
use TelegramBot\Api\Types\ReplyKeyboardRemove;
use TelegramBot\Api\Types\Update;

class GeoController
{
    public function addPointGeo(BotApi $bot, Update  $update)
    {
        $user = TelegramUser::where("telegram_id",$update->getMessage()->getFrom()->getId())->first();
        $shawerma = New Shawerma();
        $shawerma->author_telegram_id = $update->getMessage()->getFrom()->getId();
        $shawerma->longtitude = $update->getMessage()->getLocation()->getLongitude();
        $shawerma->latitude = $update->getMessage()->getLocation()->getLatitude();
        $shawerma->save();
        $bot->sendMessage($update->getMessage()->getFrom()->getId()
            ,"Пришлите название шавермы(текстом)",null,false,null,new ReplyKeyboardRemove());
        $user->state = "wait_name";
        $user->save();
    }

    public function addPointName(BotApi $bot, Update  $update)
    {
        $user = TelegramUser::where("telegram_id",$update->getMessage()->getFrom()->getId())->first();
        $shawerma = Shawerma::where("author_telegram_id",$update->getMessage()->getFrom()->getId())->first();
        $shawerma->name = $update->getMessage()->getText();
        $shawerma->save();
        $bot->sendMessage($update->getMessage()->getFrom()->getId()
            ,"Пришлите описание шавермы(текстом)",null,false,null,new ReplyKeyboardRemove());
        $user->state = "wait_description";
        $user->save();
    }

    public function addPointDesc(BotApi $bot, Update  $update)
    {
        $user = TelegramUser::where("telegram_id",$update->getMessage()->getFrom()->getId())->first();
        $shawerma = Shawerma::where("author_telegram_id",$update->getMessage()->getFrom()->getId())->first();
        $shawerma->description = $update->getMessage()->getText();
        $shawerma->save();
        $bot->sendMessage($update->getMessage()->getFrom()->getId()
            ,"Пришлите фото шавермы",null,false,null,new ReplyKeyboardRemove());
        $user->state = "wait_photo";
        $user->save();
    }
    public function addPointPhoto(BotApi $bot, Update  $update)
    {
        $user = TelegramUser::where("telegram_id",$update->getMessage()->getFrom()->getId())->first();
        $shawerma = Shawerma::where("author_telegram_id",$update->getMessage()->getFrom()->getId())->first();
        $shawerma->cover_photo = $update->getMessage()->getPhoto();
        $shawerma->save();
        $view = Teleview::getView("main_menu");
        Teleview::render($view,$bot,$update);
        $user->state = "";
        $user->save();
    }
    public function getNearPoints(BotApi $bot, Update  $update)
    {
        $count = 0;
        //TODO подумать над отношениями
        $shawermas = Shawerma::where("author_telegram_id",
            $update->getMessage()->getFrom()->getId())->get();
        $loc = $update->getMessage()->getLocation();
        foreach ($shawermas as $shawerma)
        {
            if($this->inRadius($shawerma,$loc))
             {
                    $count++;
                    $keyboard = new InlineKeyboardMarkup([[["text"=>"показать на карте",
                        "callback_data"=>json_encode(["route"
                        =>"point", "data"=>$shawerma->id])]]]);
                    $bot->sendMessage($update->getMessage()->getFrom()->getId()
                        ,$shawerma->name,null,false,null,$keyboard);
             }
        }
        if($count == 0)
        {
            $bot->sendMessage($update->getMessage()->getFrom()->getId()
                ,"Поблизости нет шавермы😒",null,false,null,new ReplyKeyboardRemove());
        }
    }
    public function getPoint(int $id,BotApi $bot, Update  $update)
    {
        $chatId= $update->getMessage()->getFrom()->getId();
        $shawerma = Shawerma::where("id",$id)->first();
        $keyboard = new InlineKeyboardMarkup([[["text"=>"оценить шаверму",
            "callback_data"=>json_encode(["route"=>"rate"])]]]);
        $reply = $bot->sendMessage($chatId
            ,$shawerma->name,null,false,null,$keyboard);
        $bot->sendLocation($chatId,$shawerma->latitude,$shawerma->longtitude,$reply->getMessageId());

    }
    //TODO: сделать нормальный перевод координат
    private function geoToRect()
    {}
    private function inRadius(Shawerma $shawerma, Location $loc)
    {
        if ($shawerma->longtitude + 0.5 > $loc->getLongitude()
            && $shawerma->longtitude - 0.5 < $loc->getLongitude()
            && $shawerma->latitude + 0.5 > $loc->getLatitude()
            && $shawerma->latitude - 0.5 < $loc->getLatitude()
        )
        {
            return true;
        }
        return false;

    }
}
