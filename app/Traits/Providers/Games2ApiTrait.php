<?php

namespace App\Traits\Providers;

use App\Helpers\Core as Helper;
use App\Models\Game;
use App\Models\GamesKey;
use App\Models\GGRGamesFiver;
use App\Models\Order;
use App\Models\Provider;
use App\Models\User;
use App\Models\Wallet;
use App\Traits\Missions\MissionTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

trait Games2ApiTrait
{
    use MissionTrait;

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @var string
     */
    protected static $agentCode;
    protected static $agentToken;
    protected static $agentSecretKey;
    protected static $apiEndpoint;

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return void
     */
    public static function getCredentialsGames2Api(): bool
    {
        $setting = GamesKey::first();

        self::$agentCode        = $setting->getAttributes()['games2_agent_code'];
        self::$agentToken       = $setting->getAttributes()['games2_agent_token'];
        self::$agentSecretKey   = $setting->getAttributes()['games2_agent_secret_key'];
        self::$apiEndpoint      = $setting->getAttributes()['games2_api_endpoint'];

        return true;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return \Illuminate\Http\JsonResponse|void
     */
    public static function GetAllProvidersGames2Api()
    {
        if(self::getCredentialsGames2Api()) {
            $dataArray = [
                "method"        => "provider_list",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
            ];

            $response = Http::post(self::$apiEndpoint, $dataArray);
            if($response->successful()) {
                $allProviders = $response->json();
                foreach($allProviders['providers'] as $provider) {

                    $data = [
                        'code'          => $provider['code'],
                        'name'          => $provider['name'],
                        'rtp'           => 80,
                        'status'        => 1,
                        'distribution'  => 'games2_api',
                    ];

                    $providerCheck = Provider::where('code', $provider['code'])->where('distribution', 'games2_api')->first();
                    if(empty($providerCheck)) {
                        Provider::create($data);
                        echo "provedor salvo com sucesso \n";
                    }
                }
            }else{
                return response()->json(['status' => false, 'errors' => ['Erro ao carregar os jogos']]);
            }
        }else{
            dd('NÂO AUTENTICADO');
        }
    }

    /**
     * @return false|int|mixed|void
     */
    public static function GetAllGamesGames2Api()
    {
        if(self::getCredentialsGames2Api()) {
            $providers = Provider::where('distribution', 'games2_api')->get();

            if(count($providers) > 0) {
                foreach($providers as $provider) {
                    $dataArray = [
                        "method"        => "game_list",
                        "agent_code"    => self::$agentCode,
                        "agent_token"   => self::$agentToken,
                        "provider_code" => $provider->code
                    ];

                    $response = Http::post(self::$apiEndpoint, $dataArray);

                    if($response->successful()) {
                        $allGames = $response->json();
                        foreach($allGames['games'] as $game) {
                            $image = self::uploadFromUrl($game['banner'], $game['game_code']);
                            $data = [
                                'provider_id'   => $provider->id,
                                'game_id'       => $game['id'],
                                'game_code'     => $game['game_code'],
                                'game_name'     => $game['game_name'],
                                'technology'    => 'html5',
                                'distribution'  => 'games2_api',
                                'rtp'           => 80,
                                'cover'         => $image,
                                'status'        => 1,
                            ];

                            Game::create($data);
                            sleep(2);

                            echo "jogo criado com sucesso \n";
                        }
                    }else{
                        return response()->json(['status' => false, 'errors' => ['Erro ao carregar os jogos']]);
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

    /**
     * Create User
     * Metodo para criar novo usuário
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     *
     * @return bool
     */
    public static function createUserGames2()
    {
        if(self::getCredentialsGames2Api()) {
            $postArray = [
                "method"        => "user_create",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
                "user_code"     => auth('api')->id() . '',
            ];

            $response = Http::post(self::$apiEndpoint, $postArray);

            if($response->successful()) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Iniciar Jogo
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Metodo responsavel para iniciar o jogo
     *
     */
    public static function GameLaunchGames2($provider_code, $game_code, $lang, $userId)
    {
        if(self::getCredentialsGames2Api()) {

            $postArray = [
                "method"        => "game_launch",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
                "user_code"     => $userId.'',
                "provider_code" => $provider_code,
                "game_code"     => $game_code,
                "lang"          => $lang
            ];

            //\DB::table('debug')->insert(['text' => json_encode($postArray)]);
            $response = Http::post(self::$apiEndpoint, $postArray);

            if($response->successful()) {
                $data = $response->json();

                if($data['status'] == 0) {
                    if($data['msg'] == 'Invalid User') {
                        if(self::createUserGames2()) {
                            return self::GameLaunchGames2($provider_code, $game_code, $lang, $userId);
                        }
                    }
                }else{
                    return $data;
                }
            }else{
                return false;
            }
        }

    }

    /**
     * Get FIvers Balance
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return false|void
     */
    public static function getUserDetailGames2()
    {
        if(self::getCredentialsGames2Api()) {
            $dataArray = [
                "method"        => "call_players",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
            ];

            $response = Http::post(self::$apiEndpoint, $dataArray);

            if($response->successful()) {
                $data = $response->json();

                dd($data);
            }else{
                return false;
            }
        }

    }

    /**
     * Get FIvers Balance
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $provider_code
     * @param $game_code
     * @param $lang
     * @param $userId
     * @return false|void
     */
    public static function getBalanceGames2()
    {
        if(self::getCredentialsGames2Api()) {
            $dataArray = [
                "method"        => "money_info",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
            ];

            $response = Http::post(self::$apiEndpoint, $dataArray);

            if($response->successful()) {
                $data = $response->json();

                return $data['agent']['balance'] ?? 0;
            }else{
                return false;
            }
        }

    }


    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private static function GetBalanceInfoGames2($request)
    {
        $wallet = Wallet::where('user_id', $request->user_code)->where('active', 1)->first();
        if(!empty($wallet) && $wallet->total_balance > 0) {
            return response()->json([
                'status' => 1,
                'user_balance' => $wallet->total_balance
            ]);
        }

        return response()->json([
            'status' => 0,
            'user_balance' => 0,
            'msg' => "INSUFFICIENT_USER_FUNDS"
        ]);
    }

    /**
     * Set Transactions
     *
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private static function SetTransactionGames2($request)
    {
        $data = $request->all();
        $wallet = Wallet::where('user_id', $request->user_code)->where('active', 1)->first();

        if(!empty($wallet)) {
            if($data['game_type'] == 'slot' && isset($data['slot'])) {

                $game = Game::where('game_code', $data['slot']['game_code'])->first();

                /// verificar se usuário tem desafio ativo
                self::CheckMissionExist($request->user_code, $game, 'fivers');

                $winMoney = (floatval($data['slot']['win_money']) - floatval($data['slot']['bet_money']));
                $transactions = self::PrepareTransactionsGames2($wallet, $request->user_code, $data['slot']['txn_id'], $data['slot']['bet_money'], $winMoney, $data['slot']['game_code'], $data['slot']['provider_code']);

                if($transactions) {
                    return response()->json([
                        'status' => 1,
                    ]);
                }else{
                    return response()->json([
                        'status' => 0,
                        'msg' => 'INSUFFICIENT_USER_FUNDS'
                    ]);
                }
            }

            if($data['game_type'] == 'live' &&  isset($data['live'])) {
                $game = Game::where('game_code', $data['live']['game_code'])->first();

                /// verificar se usuário tem desafio ativo
                self::CheckMissionExist($request->user_code, $game, 'fivers');

                $transactions = self::PrepareTransactionsGames2($wallet, $request->user_code, $data['live']['txn_id'], $data['live']['bet_money'], $data['live']['win_money'], $data['live']['game_code'], $data['live']['provider_code']);
                if($transactions) {
                    return response()->json([
                        'status' => 1,
                    ]);
                }else{
                    return response()->json([
                        'status' => 0,
                        'msg' => 'INSUFFICIENT_USER_FUNDS'
                    ]);
                }
            }
        }
    }

    /**
     * Prepare Transaction
     * Metodo responsavel por preparar a transação
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     *
     * @param $wallet
     * @param $userCode
     * @param $txnId
     * @param $betMoney
     * @param $winMoney
     * @param $gameCode
     * @return \Illuminate\Http\JsonResponse|void
     */
    private static function PrepareTransactionsGames2($wallet, $userCode, $txnId, $betMoney, $winMoney, $gameCode, $providerCode)
    {
        $user = User::find($wallet->user_id);

        $typeAction  = 'bet';
        $changeBonus = 'balance';
        $bet = floatval($betMoney);

        /// deduz o saldo apostado
        if($wallet->balance_bonus > $bet) {
            $wallet->decrement('balance_bonus', $bet); /// retira do bonus
            $changeBonus = 'balance_bonus'; /// define o tipo de transação
        }elseif($wallet->balance >= $bet) {
            $wallet->decrement('balance', $bet); /// retira do saldo depositado
            $changeBonus = 'balance'; /// define o tipo de transação
        }elseif($wallet->balance_withdrawal >= $bet) {
            $wallet->decrement('balance_withdrawal', $bet); /// retira do saldo liberado pra saque
            $changeBonus = 'balance_withdrawal'; /// define o tipo de transação
        }else{
            return false;
        }

        if(floatval($winMoney) > $bet) {
            $typeAction = 'win';
            $transaction = self::CreateTransactionsGames2($userCode, time(), $txnId, $typeAction, $changeBonus, $betMoney, $gameCode, $gameCode);

            if(!empty($transaction)) {
                /// salvar transação GGR
                GGRGamesFiver::create([
                    'user_id' => $userCode,
                    'provider' => $providerCode,
                    'game' => $gameCode,
                    'balance_bet' => $betMoney,
                    'balance_win' => $winMoney,
                    'currency' => $wallet->currency
                ]);

                /// pagar afiliado
                Helper::generateGameHistory($user->id, $typeAction, $winMoney, $betMoney, $changeBonus, $txnId);

                return response()->json([
                    'status' => 1,
                    'user_balance' => $wallet->total_balance
                ]);
            }


        }

        /// criar uma transação
        $checkTransaction = Order::where('transaction_id', $txnId)->first();
        if(empty($checkTransaction)) {
            $checkTransaction = self::CreateTransactionsGames2($userCode, time(), $txnId, $typeAction, $changeBonus, $betMoney, $gameCode, $gameCode);
        }

        /// salvar transação GGR
        GGRGamesFiver::create([
            'user_id' => $userCode,
            'provider' => $providerCode,
            'game' => $gameCode,
            'balance_bet' => $betMoney,
            'balance_win' => 0,
            'currency' => $wallet->currencyS
        ]);

        Helper::lossRollover($wallet, $betMoney);

        /// pagar afiliado
        Helper::generateGameHistory($user->id, 'loss', $winMoney, $betMoney, $changeBonus, $checkTransaction->transaction_id);

        return response()->json([
            'status' => 1,
            'user_balance' => $wallet->total_balance
        ]);

    }

    private static function SetGameStartGames2($request)
    {

    }

    private static function SetGameEndGames2($request)
    {

    }

    /**
     * @param $request
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return \Illuminate\Http\JsonResponse|null
     */
    public static function WebhooksGames2($request)
    {
        switch ($request->method) {
            case "user_balance":
                return self::GetBalanceInfoGames2($request);
            case "transaction":
                return self::SetTransactionGames2($request);
            case "game_start":
                return self::SetGameStartGames2($request);
            case "game_end":
                return self::SetGameEndGames2($request);
            default:
                return response()->json(['status' => 0]);
        }
    }


    /**
     * Create Transactions
     * Metodo para criar uma transação
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     *
     * @return false
     */
    private static function CreateTransactionsGames2($playerId, $betReferenceNum, $transactionID, $type, $changeBonus, $amount, $game, $pn)
    {

        $order = Order::create([
            'user_id'       => $playerId,
            'session_id'    => $betReferenceNum,
            'transaction_id'=> $transactionID,
            'type'          => $type,
            'type_money'    => $changeBonus,
            'amount'        => $amount,
            'providers'     => 'Games2Api',
            'game'          => $game,
            'game_uuid'     => $pn,
            'round_id'      => 1,
        ]);

        if($order) {
            return $order;
        }

        return false;
    }
}


?>
