<?php

namespace App\Console\Commands\Games;

use App\Traits\Commands\Games\SalsaGamesCommandTrait;
use App\Traits\Providers\SalsaGamesTrait;
use Illuminate\Console\Command;

class SalsaGameList extends Command
{
    use SalsaGamesCommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salsa:gamelist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        self::getGames();
    }
}
