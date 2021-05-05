<?php

namespace App\Listeners;


use App\Events\OnUpdate;
use App\Services\Telegram\UpdateController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use TelegramBot\Api\Types\Update;

class TelegramUpdateNotify
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Update  $event
     * @return void
     */
    public function handle(OnUpdate $event)
    {
        $handler = new UpdateController();
        $handler->onUpdate($event->update,$event->bot);
    }
}
