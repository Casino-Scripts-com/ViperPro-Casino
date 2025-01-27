<?php

namespace App\Traits\Commands\Games;

use App\Models\Game;
use App\Models\GamesKey;
use App\Models\Provider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait WorldSlotGamesCommandTrait
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

        self::$agentCode        = $setting->worldslot_agent_code;
        self::$agentToken       = $setting->worldslot_agent_token;
        self::$agentSecretKey   = $setting->worldslot_agent_secret_key;
        self::$apiEndpoint      = $setting->worldslot_api_endpoint;

        return true;
    }

    /**
     * Create User
     * Metodo para criar novo usuário
     *
     * @return bool
     */
    public static function getProvider($param)
    {
        if(self::getCredentials()) {
            $response = Http::post(self::$apiEndpoint.'provider_list', [
                'agent_code' => self::$agentCode,
                'agent_token' => self::$agentToken,
                'game_type' => $param, ///  [slot, casino, pachinko]
            ]);

            if($response->successful()) {
                $data = $response->json();
                dd($data);
                if($data['status'] == 1) {
                    foreach ($data['providers'] as $provider) {
                        dd($provider);
                        $checkProvider = Provider::where('code', $provider['code'])->where('distribution', 'worldslot')->first();
                        if(empty($checkProvider)) {

                            $dataProvider = [
                                'code' => $provider['code'],
                                'name' => $provider['name'],
                                'rtp' => 90,
                                'status' => 1,
                                'distribution' => 'worldslot',
                            ];

                            Provider::create($dataProvider);
                        }
                    }
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
            $providers = Provider::where('distribution', 'worldslot')->get();
            foreach($providers as $provider) {
                $response = Http::post(self::$apiEndpoint.'/game_list', [
                    'agent_code' => self::$agentCode,
                    'agent_token' => self::$agentToken,
                    'provider_code' => $provider->code
                ]);

                if($response->successful()) {
                    $data = $response->json();

                    if(isset($data['games'])) {
                        foreach ($data['games'] as $game) {
                            $checkGame = Game::where('provider_id', $provider->id)->where('game_code', $game['game_code'])->first();
                            if(empty($checkGame)) {
                                $image = self::uploadFromUrl($game['banner'], $game['game_code']);
                                $data = [
                                    'provider_id'   => $provider->id,
                                    'game_id'       => $game['game_code'],
                                    'game_code'     => $game['game_code'],
                                    'game_name'     => $game['game_name'],
                                    'technology'    => 'html5',
                                    'distribution'  => 'worldslot',
                                    'rtp'           => 90,
                                    'cover'         => $image,
                                    'status'        => 1,
                                ];

                                Game::create($data);
                            }
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
