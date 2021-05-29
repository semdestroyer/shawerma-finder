<?php
namespace App\Services\Telegram;


use CURLFile;
use Illuminate\Support\Facades\Storage;
use Prophecy\Doubler\ClassPatch\SplFileInfoPatch;
use SplFileInfo;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Update;

class TelegramFileController
{
    public function savePhoto(Update $update, BotApi $bot)
    {
        $path = $update->getMessage()->getPhoto()["id"];
        $content = $bot->downloadFile($path);
        $spl = new SplFileInfo($path);
        $save_path = $spl->getFilename() . $spl->getExtension();
        $user_id = $update->getMessage()->getFrom()->getId();
        Storage::put("telegram/" . $user_id . $save_path,$content);

    }
    public function loadPhoto(String $path,Update $update, BotApi $bot)
    {
        return new CURLFile($path,"");
    }

}
