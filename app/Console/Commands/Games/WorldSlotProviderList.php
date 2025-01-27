<?php

namespace App\Console\Commands\Games;

use App\Traits\Commands\Games\FiversGamesCommandTrait;
use App\Traits\Commands\Games\WorldSlotGamesCommandTrait;
use Illuminate\Console\Command;

class WorldSlotProviderList extends Command
{
    use WorldSlotGamesCommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'worldslot:providers {param?}';

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
        $param = $this->argument('param');
        return self::getProvider($param);
    }
}
