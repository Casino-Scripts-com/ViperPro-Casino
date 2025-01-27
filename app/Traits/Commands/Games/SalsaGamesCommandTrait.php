<?php

namespace App\Traits\Commands\Games;

use App\Models\FiversGame;
use App\Models\Game;
use App\Models\GameProvider;
use App\Models\GamesKey;
use App\Models\Provider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait SalsaGamesCommandTrait
{

    /**
     * Create User
     * Metodo para criar novo usuário
     *
     * @return bool
     */
    public static function getGames()
    {
        $games = \DB::table('cassino_games')->get();
        foreach($games as $game) {
            //$image = self::uploadFromUrl($game->image, $game->game_id);
            $data = [
                'provider_id'   => 15,
                'game_id'       => $game->game_id,
                'game_code'     => $game->game_id,
                'game_name'     => $game->game_name,
                'technology'    => 'html5',
                'distribution'  => 'salsa',
                'rtp'           => 90,
                //'cover'         => $image,
                'status'        => 1,
            ];


            $gameFind = Game::where('game_id', $game->game_id)->first();
            if(!empty($gameFind)) {
                $gameFind->update(['cover' => $game->image]);
            }
        }
    }


    /**
     * @param $url
     * @return string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private static function uploadFromUrl($url, $name = null)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url);

            if ($response->getStatusCode() === 200) {
                $fileContent = $response->getBody();

                // Extrai o nome do arquivo e a extensão da URL
                $parsedUrl = parse_url($url);
                $pathInfo = pathinfo($parsedUrl['path']);

                //$fileName = $pathInfo['filename'] ?? 'file_' . time(); // Nome do arquivo
                $fileName  = $name ?? $pathInfo['filename'] ;
                $extension = 'png'; // Extensão do arquivo

                // Monta o nome do arquivo com o prefixo e a extensão
                $fileName = 'salsa/'.$fileName . '.' . $extension;

                // Salva o arquivo usando o nome extraído da URL
                Storage::disk('public')->put($fileName, $fileContent);

                return $fileName;
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
