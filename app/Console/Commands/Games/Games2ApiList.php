<?php

namespace App\Console\Commands\Games;

use App\Traits\Commands\Games\FiversGamesCommandTrait;
use App\Traits\Commands\Games\WorldSlotGamesCommandTrait;
use App\Traits\Providers\Games2ApiTrait;
use Illuminate\Console\Command;

class Games2ApiList extends Command
{
    use Games2ApiTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games2api:games';

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
        return self::GetAllGamesGames2Api();
    }
}
