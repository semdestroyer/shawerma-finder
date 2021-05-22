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
        //TODO подумать над отношениями
        $shawermas = Shawerma::where("telegram_id",
            $update->getMessage()->getFrom()->getId())->get();
        $loc = $update->getMessage()->getLocation();
        foreach ($shawermas as $shawerma)
        {
            if($this->inRadius($shawerma,$loc))
             {
                    $keyboard = new InlineKeyboardMarkup([["text"=>"показать на карте",
                        "callback_data"=>["point"=>$shawerma->id]]]);
                    $bot->sendMessage($update->getMessage()->getFrom()->getId()
                        ,$shawerma->name,null,false,null,$keyboard);
             }
        }
    }
    public function getPoint(BotApi $bot, Update  $update)
    {
        $shawerma = Shawerma::where("telegram_id",
            $update->getMessage()->getFrom()->getId())->take(1)->get();
        $keyboard = new InlineKeyboardMarkup([["text"=>"оценить шаверму",
            "callback_data"=>"rate"]]);
        $bot->sendMessage($update->getMessage()->getFrom()->getId()
            ,$shawerma->name,null,false,null,$keyboard);

    }
    //TODO: сделать нормальный перевод координат
    private function geoToRect()
    {}
    private function inRadius(Shawerma $shawerma, Location $loc)
    {
        if ($shawerma->longtitude + 0.5 > $loc->getLongitude()
            && $shawerma->longtitude + 0.5 < $loc->getLongitude()
            && $shawerma->latitude + 0.5 < $loc->getLatitude()
            && $shawerma->latitude + 0.5 < $loc->getLatitude()
        )
        {
            return true;
        }
        return false;

    }
}
