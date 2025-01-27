<?php

namespace App\Traits\Providers;

use App\Helpers\Core as Helper;
use App\Models\Game;
use App\Models\GamesKey;
use App\Models\GGRGamesFiver;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Traits\Missions\MissionTrait;
use Illuminate\Support\Facades\Http;

trait FiversTrait
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
    public static function getCredentials(): bool
    {
        $setting = GamesKey::first();

        self::$agentCode        = $setting->getAttributes()['agent_code'];
        self::$agentToken       = $setting->getAttributes()['agent_token'];
        self::$agentSecretKey   = $setting->getAttributes()['agent_secret_key'];
        self::$apiEndpoint      = $setting->getAttributes()['api_endpoint'];

        return true;
    }

    public static function GetAllGames()
    {
        if(self::getCredentials()) {


        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $rtp
     * @param $provider
     * @return void
     */
    public static function UpdateRTP($rtp, $provider)
    {
        if(self::getCredentials()) {
            $postArray = [
                "method"        => "control_rtp",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
                "provider_code" => $provider,
                "user_code"     => auth('api')->id() . '',
                "rtp"           => $rtp
            ];

            $response = Http::post(self::$apiEndpoint, $postArray);

            if($response->successful()) {

            }
        }
    }

    /**
     * Create User
     * Metodo para criar novo usuário
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     *
     * @return bool
     */
    public static function createUser()
    {
        if(self::getCredentials()) {
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
    public static function GameLaunchFivers($provider_code, $game_code, $lang, $userId)
    {
        if(self::getCredentials()) {
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
                        if(self::createUser()) {
                            return self::GameLaunchFivers($provider_code, $game_code, $lang, $userId);
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
    public static function getFiversUserDetail()
    {
        if(self::getCredentials()) {
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
    public static function getFiversBalance()
    {
        if(self::getCredentials()) {
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
    private static function GetBalanceInfo($request)
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
    private static function SetTransaction($request)
    {
        $data = $request->all();
        $wallet = Wallet::where('user_id', $request->user_code)->where('active', 1)->first();

        if(!empty($wallet) && isset($data['slot'])) {
            if($data['game_type'] == 'slot' && isset($data['slot'])) {

                $game = Game::where('game_code', $data['slot']['game_code'])->first();

                /// verificar se usuário tem desafio ativo
                self::CheckMissionExist($request->user_code, $game, 'fivers');
                $transaction = self::PrepareTransactions(
                    $wallet,
                    $request->user_code,
                    $data['slot']['txn_id'],
                    $data['slot']['bet_money'],
                    $data['slot']['win_money'],
                    $data['slot']['game_code'],
                    $data['slot']['provider_code']
                );
                if($transaction) {

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
                $transaction =  self::PrepareTransactions(
                    $wallet,
                    $request->user_code,
                    $data['live']['txn_id'],
                    $data['live']['bet_money'],
                    $data['live']['win_money'],
                    $data['live']['game_code'],
                    $data['live']['provider_code']
                );

                if($transaction) {

                }else{
                    return response()->json([
                        'status' => 0,
                        'msg' => 'INSUFFICIENT_USER_FUNDS'
                    ]);
                }
            }
        }

        if(!empty($wallet) && isset($data['msg']) && $data['msg'] == 'Money change during the game.') {
            return response()->json([
                'status' => 1,
                'user_balance' => $wallet->total_balance
            ]);
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
    private static function PrepareTransactions($wallet, $userCode, $txnId, $betMoney, $winMoney, $gameCode, $providerCode)
    {
        $user = User::find($wallet->user_id);

        if(!empty($user)) {
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
                $transaction = self::CreateTransactions($userCode, time(), $txnId, $typeAction, $changeBonus, $bet, 'fivers', $gameCode, $gameCode);

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
                    Helper::generateGameHistory($user->id, $typeAction, $winMoney, $bet, $changeBonus, $txnId);

                    return response()->json([
                        'status' => 1,
                        'user_balance' => $wallet->total_balance
                    ]);
                }
            }

            /// criar uma transação
            $checkTransaction = Order::where('transaction_id', $txnId)->first();
            if(empty($checkTransaction)) {
                $checkTransaction = self::CreateTransactions($userCode, time(), $txnId, $typeAction, $changeBonus, $bet, 'fivers', $gameCode, $gameCode);
            }

            /// salvar transação GGR
            GGRGamesFiver::create([
                'user_id' => $userCode,
                'provider' => $providerCode,
                'game' => $gameCode,
                'balance_bet' => $bet,
                'balance_win' => 0,
                'currency' => $wallet->currencyS
            ]);

            Helper::lossRollover($wallet, $bet);
            Helper::generateGameHistory($user->id, $typeAction, $winMoney, $bet, $changeBonus, $checkTransaction->transaction_id);

            return response()->json([
                'status' => 1,
                'user_balance' => $wallet->total_balance
            ]);
        }
    }

    /**
     * @param $request
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return \Illuminate\Http\JsonResponse|null
     */
    public static function WebhooksFivers($request)
    {
        switch ($request->method) {
            case "user_balance":
                return self::GetBalanceInfo($request);
            case "transaction":
                return self::SetTransaction($request);
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
    private static function CreateTransactions($playerId, $betReferenceNum, $transactionID, $type, $changeBonus, $amount, $providers, $game, $pn)
    {

        $order = Order::create([
            'user_id'       => $playerId,
            'session_id'    => $betReferenceNum,
            'transaction_id'=> $transactionID,
            'type'          => $type,
            'type_money'    => $changeBonus,
            'amount'        => $amount,
            'providers'     => $providers,
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
