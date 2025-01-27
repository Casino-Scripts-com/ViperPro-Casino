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

trait FiversGamesCommandTrait
{
    /**
     * @var string
     */
    protected static $agentCode;
    protected static $agentToken;
    protected static $agentSecretKey;
    protected static $apiEndpoint;

    /**
     * @return void
     */
    public static function getCredentials(): bool
    {
        $setting = GamesKey::first();

        self::$agentCode        = $setting->agent_code;
        self::$agentToken       = $setting->agent_token;
        self::$agentSecretKey   = $setting->agent_secret_key;
        self::$apiEndpoint      = $setting->api_endpoint;

        return true;
    }

    /**
     * Create User
     * Metodo para criar novo usuário
     *
     * @return bool
     */
    public static function getProvider()
    {
        if(self::getCredentials()) {
            $response = Http::post(self::$apiEndpoint, [
                'method' => 'provider_list',
                'agent_code' => '',
                'agent_token' => '',
            ]);

            if($response->successful()) {
                $data = $response->json();

                foreach ($data['providers'] as $provider) {
                    Provider::create($provider);
                }
            }
        }
    }


    /**
     * Create User
     * Metodo para criar novo usuário
     *
     * @return bool
     */
    public static function getGames()
    {
        if(self::getCredentials()) {
            $providers = Provider::get();
            foreach($providers as $provider) {
                $response = Http::post(self::$apiEndpoint, [
                    'method' => 'game_list',
                    'agent_code' => '',
                    'agent_token' => '',
                    'provider_code' => $provider->code
                ]);

                if($response->successful()) {
                    $data = $response->json();

                    if(isset($data['games'])) {
                        foreach ($data['games'] as $game) {
                            $image = self::uploadFromUrl($game['banner'], $game['game_code']);
                            $data = [
                                'provider_id'   => $provider->id,
                                'game_id'       => $game['game_code'],
                                'game_code'     => $game['game_code'],
                                'game_name'     => $game['game_name'],
                                'technology'    => 'html5',
                                'distribution'  => 'games2_api',
                                'rtp'           => 90,
                                'cover'         => $image,
                                'status'        => 1,
                            ];

                            Game::create($data);

                            echo "jogo criado com sucesso \n";
                        }
                    }
                }
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
                $extension = $pathInfo['extension'] ?? 'png'; // Extensão do arquivo

                // Monta o nome do arquivo com o prefixo e a extensão
                $fileName = 'fivers/'.$fileName . '.' . $extension;

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
