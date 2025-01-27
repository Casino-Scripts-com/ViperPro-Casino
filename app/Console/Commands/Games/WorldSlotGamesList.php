<?php

namespace App\Console\Commands\Games;

use App\Traits\Commands\Games\FiversGamesCommandTrait;
use App\Traits\Commands\Games\WorldSlotGamesCommandTrait;
use Illuminate\Console\Command;

class WorldSlotGamesList extends Command
{
    use WorldSlotGamesCommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'worldslot:games';

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
        return self::getGames();
    }
}
