<?php

namespace App\Traits\Providers;

use App\Models\Game;
use Illuminate\Support\Facades\Http;

trait KaGamingTrait
{
    protected static $KAGAMING_PARTNER_NAME  = '';
    protected static $KAGAMING_ACCESS_KEY    = '';
    protected static $KAGAMING_SECRET_KEY    = ''; // Chave secreta compartilhada entre o licenciado e RMP
    protected static $URI                    = 'https://rmpstage.kaga88.com/kaga/';

    /**
     * Sign HMAC
     * @return string
     */
    private static function SignHMAC($requestData)
    {
        return hash_hmac('sha256', json_encode($requestData), self::$KAGAMING_SECRET_KEY);
    }

    /**
     * Game Launch
     *
     * @param $server
     * @param $gameId
     * @return string
     */
    public static function GameLaunchKaGaming($server, $gameId)
    {
        $currency = \Helper::getActiveWallet()['currency'];
        $userId = 1;

        $gameLaunchURL = $server . '?' . http_build_query([
                'g' => $gameId,
                'p' => self::$KAGAMING_PARTNER_NAME,
                'u' => $userId,
                'ak' => self::$KAGAMING_ACCESS_KEY,
                'cr' => $currency,
                't' => uniqid(),
                'loc' => 'pt',
                // add other parameters here as needed
                'l' => url('/kagaming'), // LOBBY_URL
            ]);

        return $gameLaunchURL;
    }

    /**
     * Game List
     *
     * @return \Illuminate\Http\Client\Response|mixed
     * @throws \Illuminate\Http\Client\RequestException
     */
    public static function GameList()
    {
        $gamesKaga = self::GetGameListData();

        if(isset($gamesKaga['games']) && count($gamesKaga['games']) > 0) {
            foreach($gamesKaga['games'] as $game) {

                $data = [
                    'game_server_url'       => $gamesKaga['gameLaunchURL'],
                    'provider_id'           => 14,
                    'category_id'           => 1,
                    'game_id'               => $game['gameId'],
                    'game_code'             => $game['gameId'],
                    'game_type'             => $game['gameType'],
                    'game_name'             => $game['gameName'],
                    'cover'                 => $game['iconURLPrefix'] . '&type=rectangular',
                    'status'                => $game['newGame'],
                    'distribution'          => 'kagaming',
                    'technology'            => 'html5',
                    'rtp'                   => 90,
                ];

                if(Game::create($data)) {
                    echo "Cadastrado com sucesso \n <br/>";
                }
            }
        }
    }


    /**
     * @return \Illuminate\Http\Client\Response|mixed
     * @throws \Illuminate\Http\Client\RequestException
     */
    private static function GetGameListData()
    {
        $requestData = [
            'partnerName' => self::$KAGAMING_PARTNER_NAME,
            'accessKey'   => self::$KAGAMING_ACCESS_KEY,
            'language'    => 'pt',
            'randomId'    => rand(),
        ];

        $response = Http::post(self::$URI . 'gameList?hash='.self::SignHMAC($requestData), $requestData);

        if($response->successful()) {
            $data = $response->json();

            return [
                'games' => $data['games'],
                'gameLaunchURL' => $data['gameLaunchURL']
            ];
        }

        return $response->throw();
    }


    public static function WebhookKaGaming($request)
    {
        \Log::info('DEBUG:' . json_encode($request->all()));
    }

}
