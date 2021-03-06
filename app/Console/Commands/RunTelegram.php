<?php

namespace App\Console\Commands;

use App\Services\Telegram\Core\Updater;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;


class RunTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Updater $update)
    {
        $update->handleUpdates(Config::get("telegram.token"));
        return 0;
    }
}
