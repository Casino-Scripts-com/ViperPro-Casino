<?php

namespace App\Traits\Providers;

use App\Models\CasinoGamesSlotgrator;
use App\Models\GamesKey;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletChange;
use Illuminate\Http\Response as ResponseAlias;
use Illuminate\Support\Facades\DB;

trait SlotegratorTrait
{
    /**
     * @var String $merchantUrl
     * @var String $merchantId
     * @var String $merchantKey
     */
    protected string $merchantId, $merchantKey, $merchantUrl;

    /**
     * @return void
     */
    public function getCredentials(): void
    {
        $setting = GamesKey::first();

        $this->merchantUrl  = $setting->getAttributes()['merchant_url'];
        $this->merchantId   = $setting->getAttributes()['merchant_id'];
        $this->merchantKey  = $setting->getAttributes()['merchant_key'];
    }

    /**
     * @param string $gameuuid
     * @return array
     * @throws \Exception
     */
    public function startGameSlotegrator(string $gameuuid): array
    {
        if(auth('api')->check()) {
            $this->getCredentials(); // buscando as crendenciais

            $url = $this->merchantUrl . '/games/init';

            $tokenPlayer = \Helper::MakeToken([
                'player_id' => auth('api')->user()->id,
                'platform' => 'main'
            ]);

            $requestParams = [
                'game_uuid'         => $gameuuid,
                'player_id'         => $tokenPlayer,
                'player_name'       => auth('api')->user()->name,
                'email'             => auth('api')->user()->email,
                'return_url'        => url('/'),
                'currency'          => 'BRL',
                'session_id'        => $this->generateRandomString(),
                'language'          => 'pt',
                'lobby_data'        => $this->getLobby($gameuuid, false),
            ];

            $merchantId     = $this->merchantId;
            $merchantKey    = $this->merchantKey;
            $nonce          = md5(uniqid(mt_rand(), true));
            $time           = time();

            $headers = [
                'X-Merchant-Id' => $merchantId,
                'X-Timestamp' => $time,
                'X-Nonce' => $nonce,
            ];

            $mergedParams = array_merge($requestParams, $headers);
            ksort($mergedParams);
            $hashString = http_build_query($mergedParams);

            $XSign = hash_hmac('sha1', $hashString, $merchantKey);

            ksort($requestParams);
            $postdata = http_build_query($requestParams);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Merchant-Id: '.$merchantId,
                'X-Timestamp: '.$time,
                'X-Nonce: '.$nonce,
                'X-Sign: '.$XSign,
                'Accept: application/json',
                'Enctype: application/x-www-form-urlencoded',
            ));

            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $result = json_decode(curl_exec($ch));

            if (curl_errno($ch)) {
                $error_message = curl_error($ch);
                return [
                    'status' => false,
                    'error' =>  $error_message
                ];
            }

            if(isset($result->url)) {
                $game_url = $result->url;

                return [
                    'status' => true,
                    'game_url' => $game_url
                ];
            }
            return [
                'status' => false,
                'error' =>  $result->message
            ];
        }

        return [
            'status' => false,
            'error' =>  ''
        ];
    }

    /**
     * Self validation
     * @return \Illuminate\Http\JsonResponse
     */
    public function selfvalidation()
    {
        try{
            $this->getCredentials(); // buscando as crendenciais

            $url = $this->merchantUrl . 'self-validate';
            $merchantId = $this->merchantId;
            $merchantKey = $this->merchantKey;

            $nonce = md5(uniqid(mt_rand(), true));
            $time = time();

            $headers = [
                'X-Merchant-Id' => $merchantId,
                'X-Timestamp' => $time,
                'X-Nonce' => $nonce,
            ];

            $requestParams = [];

            $mergedParams = array_merge($requestParams, $headers);
            ksort($mergedParams);
            $hashString = http_build_query($mergedParams);

            $XSign = hash_hmac('sha1', $hashString, $merchantKey);

            ksort($requestParams);
            $postdata = http_build_query($requestParams);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Merchant-Id: '.$merchantId,
                'X-Timestamp: '.$time,
                'X-Nonce: '.$nonce,
                'X-Sign: '.$XSign,
                'Accept: application/json',
                'Enctype: application/x-www-form-urlencoded',
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $curl = curl_exec($ch);
            $response = json_decode($curl);

            return response()->json([
                $response
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * @param $gameuuid
     * @param bool $api
     * @return true
     */
    public function getLobby($gameuuid, bool $api = true)
    {
        $url = $this->merchantUrl . '/games/lobby?game_uuid=' . $gameuuid . '&currency=BRL&technology=HTML5';
        $merchantId     = $this->merchantId;
        $merchantKey    = $this->merchantKey;
        $nonce          = md5(uniqid(mt_rand(), true));
        $time           = time();

        $headers = [
            'X-Merchant-Id' => $merchantId,
            'X-Timestamp' => $time,
            'X-Nonce' => $nonce,
        ];

        $requestParams = [
            'game_uuid' => $gameuuid,
            'currency' => 'BRL',
            'technology' => 'HTML5',
        ];

        $mergedParams = array_merge($requestParams, $headers);
        ksort($mergedParams);
        $hashString = http_build_query($mergedParams);

        $XSign = hash_hmac('sha1', $hashString, $merchantKey);

        ksort($requestParams);
        $postdata = http_build_query($requestParams);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Merchant-Id: '.$merchantId,
            'X-Timestamp: '.$time,
            'X-Nonce: '.$nonce,
            'X-Sign: '.$XSign,
            'Accept: application/json',
            'Enctype: application/x-www-form-urlencoded',
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec($ch));

        if (!$api && isset($result->lobby)) {
            return $result->lobby[0]->lobbyData;
        } else if (!$api) {
            return null;
        }

        return true;
    }

    /**
     * @param array $data
     * @return array
     */
    private function sortArray(array $data): array
    {
        ksort($data);
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->sortArray($value);
            }
        }
        return $data;
    }

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    private function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function webhooks($request)
    {
        try {
            $this->getCredentials();
            $headers = $request->header();
            //\DB::table('debug')->insert(['text' => json_encode($request->header())]);
            //\DB::table('debug')->insert(['text' => json_encode($request->all())]);

            $merchantKey = $this->merchantKey;
            $headers = [
                'X-Merchant-Id' => $request->header('X-Merchant-Id'),
                'X-Timestamp' => $request->header('X-Timestamp'),
                'X-Nonce' => $request->header('X-Nonce'),
            ];

            $XSign = $request->header('X-Sign');
            $mergedParams = array_merge($request->toArray(), $headers);
            ksort($mergedParams);

            $hashString = http_build_query($mergedParams);
            $expectedSign = hash_hmac('sha1', $hashString, $merchantKey);
            if ($XSign !== $expectedSign) {
                return response()->json([
                    'error_code' => 'INTERNAL_ERROR',
                    'error_description' => 'Unauthorized Request'
                ], ResponseAlias::HTTP_OK);
            }

            $request->merge([
                //'amount' => floor($request->amount * 100) / 100
                'amount' => $request->amount
            ]);

            $walletUser = null;
            $playerData = \Helper::DecToken($request->player_id);
            $playerId = $playerData['player_id'];
            $platform = $playerData['platform'];

            $pdo = null;

            if($platform == 'main') {
                $pdo = DB::connection('mysql');
            }

            if(!empty($pdo)) {
                $user = $pdo->table('users')->find($playerId);

                if(!empty($user)) {
                    $walletUser = $pdo->table('wallets')->where('user_id', $user->id)->first();
                }

                if ($request->action == 'refund') {
                    $checkTransaction = $pdo->table('orders')
                        ->where([
                            'transaction_id' => $request->bet_transaction_id,
                            'refunded' => 1,
                        ])->count();
                } else {
                    $checkTransaction = $pdo->table('orders')
                        ->where([
                            'transaction_id' => $request->transaction_id
                        ])->count();
                }

                $nameGame = '';
                if (isset($request->game_uuid)) {
                    $game = $pdo->table('casino_games_slotgrators')
                        ->where('uuid', $request->game_uuid)
                        ->first();
                    $nameGame = $game->name ?? '';
                }

                $action = $request->action;
                if ($checkTransaction == 0 && ($request->action == 'balance' || !empty($nameGame))) {
                    if ($action == 'balance') {
                        if (!isset($user) && empty($walletUser)) {
                            return response()->json([
                                'error_code' => "INTERNAL_ERROR",
                                'error_description' => "This player doesnt exists"
                            ], ResponseAlias::HTTP_OK);
                        }

                        $wallet = $walletUser->balance + $walletUser->balance_bonus;
                        return response()->json([
                            'balance' => $wallet
                        ], ResponseAlias::HTTP_OK);

                    } else if($action == 'bet') { // BET
                        $betAmount = $request->amount;
                        $changeBonus = false;
                        if ($request->amount > ($walletUser->balance + $walletUser->balance_bonus)) {
                            return response()->json([
                                'error_code' => "INSUFFICIENT_FUNDS",
                                'error_description' => "Not enough money to continue playing"
                            ], ResponseAlias::HTTP_OK);
                        }

                        // VERIFICA SE O USUARIO POSSUI WALLET E POSSUI WALLET BONUS
                        if ($request->amount > 0 && ($request->amount <= ($walletUser->balance + $walletUser->balance_bonus))) {
                            $sql = [
                                'balance' => $walletUser->balance - $betAmount,
                                'total_bet' => $walletUser->total_bet + $betAmount,
                            ];

                            if ($walletUser->balance <= 0) {
                                $sql = [
                                    'balance_bonus' => $walletUser->balance_bonus - $betAmount
                                ];
                                $changeBonus = true;
                            }

                            // AQUI, SE O USUARIO TIVER WALLET INFERIOR BETAMOUNT, POREM TEM WALLET BONUS. SISTEMA PERMITE JOGAR, ESGOTANDO WALLET E BONUS
                            if ($walletUser->balance > 0 && $walletUser->balance <= $betAmount && ($walletUser->balance_bonus - $walletUser->balance) >= $betAmount && $walletUser->balance_bonus > 0 ){
                                $sql = [
                                    'balance' => 0,
                                    'balance_bonus' => $walletUser->balance_bonus - $betAmount
                                ];
                                $betAmount = $walletUser->balance - $betAmount;
                                $changeBonus = true;
                            }

                            if ($walletUser) {
                                $pdo->table('wallets')
                                    ->where('user_id', $user->id)
                                    ->update($sql);
                            }

                            $this->generateHistory($pdo, $user->id, $request->amount, $request, 'bet', $nameGame, $request->game_uuid, $changeBonus);
                            $this->generateWalletChange($pdo, $request, $user, $nameGame);
                        }

                        if(!empty($walletUser)) {
                            $wallet = $walletUser->balance + $walletUser->balance_bonus;
                            return response()->json([
                                'balance' => ($wallet),
                                'transaction_id' => $request->transaction_id
                            ], ResponseAlias::HTTP_OK);
                        }else{
                            return response()->json([
                                'error_code' => "INTERNAL_ERROR",
                                'error_description' => "This player doesnt exists"
                            ], ResponseAlias::HTTP_OK);
                        }

                    } else if($action == 'win') { // WIN
                        $winAmount = $request->amount;
                        $historyBet = $pdo->table('orders')
                            ->where([
                                'user_id' => $request->player_id,
                                'session_id' => $request->session_id,
                                'game' => $nameGame,
                                'type' => 'bet'
                            ])
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $sql = [
                            'balance' => $walletUser->balance + $winAmount
                        ];

                        $pdo->table('wallets')
                            ->where('user_id', $user->id)
                            ->update($sql);

                        if (!empty($historyBet)) {

                            if ($request->amount <= 0 || $historyBet->amount >= $request->amount) {
                                if ($request->amount != $historyBet->amount) {

                                    $last_lose = ($request->amount > 0 && $historyBet->amount >= $request->amount) ? $request->amount : $historyBet->amount;

                                    $pdo->table('wallets')
                                        ->where('user_id', $user->id)
                                        ->update([
                                            'total_lose' => $walletUser->total_lose + $last_lose,
                                            'last_lose' => $last_lose,
                                            'last_won' => 0,
                                        ]);
                                }
                            } else {
//                            $last_won = (\Helper::amountPrepare($request->amount) - \Helper::amountPrepare($historyBet->amount));
//
//                            // AQUI VERIFICA SE TEM AFILIADO, ATRIBUI PORCETAGEM PARA referRewards, NGR
//                            if ($user->inviter) {
//                                $afiliadoWallet = Wallet::where('user_id', $user->inviter)->first();
//                                if (!empty($afiliadoWallet)) {
//                                    $reward = (\Helper::amountPrepare($config->ngr_percent) / 100) * $last_won;
//
//                                    \Log::info('Last Won:' . $last_won);
//                                    $afiliadoWallet->update([
//                                        'refer_rewards' => $afiliadoWallet->refer_rewards - \Helper::amountPrepare(floor($reward * 100) / 100)
//                                    ]);
//                                }
//                            }
//
//                            $walletUser->update([
//                                'total_won' => $walletUser->total_won + $last_won,
//                                'last_won' => $last_won,
//                                'last_lose' => 0,
//                            ]);
                            }
                        }

                        if(floatval($winAmount) > 0) {
                            $pdo->table('wallets')
                                ->where('user_id', $user->id)
                                ->update([
                                    'total_won' => $walletUser->total_won + $winAmount,
                                    'last_won' => $winAmount,
                                    'last_lose' => 0
                                ]);

                            $this->generateHistory($pdo, $user->id, $winAmount, $request, 'win', $nameGame, $request->game_uuid);
                        }

                        $this->generateWalletChange($pdo, $request, $user, $nameGame, $historyBet);

                        if(!empty($walletUser)) {
                            $wallet = $walletUser->balance + $walletUser->balance_bonus;
                            return response()->json([
                                'balance' => $wallet,
                                'transaction_id' => $request->transaction_id
                            ], ResponseAlias::HTTP_OK);
                        }else{
                            return response()->json([
                                'error_code' => "INTERNAL_ERROR",
                                'error_description' => "This player doesnt exists"
                            ], ResponseAlias::HTTP_OK);
                        }


                    } else if($action == 'refund') { // REFUND
                        $walletbonus = false;

                        // verifica se o usuario tem wallet, caso n tenha, aumenta no bonus
                        if (!empty($walletUser) && $walletUser->balance <= 0 && $walletUser->balance_bonus > 0 ) {
                            $walletbonus = true;
                        }

                        // verifica se o usuario tem wallet, caso n tenha, aumenta no bonus
                        $checkTransactionBet = $pdo->table('orders')
                            ->where('transaction_id', $request->bet_transaction_id)
                            ->first();

                        if ($checkTransactionBet) {
                            if ($checkTransactionBet->type == 'win') {
                                $wallet = $walletbonus ? $walletUser->balance_bonus : $walletUser->balance;

                                if ($checkTransactionBet->round_id == $request->round_id) {
                                    if ($walletbonus) {
                                        $wallet = $walletUser->balance_bonus - $request->amount;
                                    } else {
                                        $wallet = $walletUser->balance - $request->amount;
                                    }
                                }
                            } else {
                                if ($walletbonus) {
                                    $wallet = $walletUser->balance_bonus + $request->amount;
                                } else {
                                    $wallet = $walletUser->balance + $request->amount;
                                }
                            }
                            if ($walletbonus) {
                                $pdo->table('wallets')
                                    ->where('user_id', $user->id)
                                    ->update([
                                        'balance_bonus' => $wallet
                                    ]);
                            } else {
                                $pdo->table('wallets')
                                    ->where('user_id', $user->id)
                                    ->update([
                                        'balance' => $wallet
                                    ]);
                            }

                            $this->generateHistory($pdo, $user->id, $request->amount, $request, 'refund', $nameGame, $request->game_uuid);
                        }

                        if ($checkTransactionBet != null) {
                            $pdo->table('orders')
                                ->where('transaction_id', $request->bet_transaction_id)
                                ->update([
                                    'refunded' => 1
                                ]);
                        }

                        if(!empty($walletUser)) {
                            $wallet = $walletUser->balance + $walletUser->balance_bonus;
                            return response()->json([
                                'balance' => $wallet,
                                'transaction_id' => $request->transaction_id
                            ], ResponseAlias::HTTP_OK);
                        }else{
                            return response()->json([
                                'error_code' => "INTERNAL_ERROR",
                                'error_description' => "This player doesnt exists"
                            ], ResponseAlias::HTTP_OK);
                        }
                    } else if($action == 'rollback') { // ROLLBACK
                        $walletbonus = false;

                        // verifica se o usuario tem wallet, caso n tenha, aumenta no bonus
                        if ($walletUser->balance <= 0 && $walletUser->balance_bonus > 0 ) {
                            $walletbonus = true;
                        }

                        foreach($request->rollback_transactions as $rollback) {
                            if ($rollback['action'] == 'win') {
                                if ($walletbonus) {
                                    $pdo->table('wallets')
                                        ->where('user_id', $user->id)
                                        ->update([
                                            'balance_bonus' => $walletUser->balance_bonus - $rollback['amount'],
                                        ]);
                                } else {
                                    $pdo->table('wallets')
                                        ->where('user_id', $user->id)
                                        ->update([
                                            'balance' => $walletUser->balance - $rollback['amount'],
                                        ]);
                                }
                            } elseif ($rollback['action'] == 'bet') {
                                if ($walletbonus) {
                                    $pdo->table('wallets')
                                        ->where('user_id', $user->id)
                                        ->update([
                                            'balance_bonus' => $walletUser->balance_bonus + $rollback['amount'],
                                        ]);
                                } else {
                                    if ($walletUser) {
                                        $pdo->table('wallets')
                                            ->where('user_id', $user->id)
                                            ->update([
                                                'balance' => $walletUser->balance + $rollback['amount'],
                                            ]);
                                    }
                                }
                            }
                        }

                        $this->generateHistory($pdo, $user->id, $request->amount, $request, 'rollback', $nameGame, $request->game_uuid);

                        if(!empty($walletUser)) {
                            $wallet = $walletUser->balance + $walletUser->balance_bonus;
                            return response()->json([
                                'balance' => $wallet,
                                'transaction_id' => $request->transaction_id,
                                'rollback_transactions' => collect($request->rollback_transactions)->pluck('transaction_id')->toArray()
                            ], ResponseAlias::HTTP_OK);
                        }else{
                            return response()->json([
                                'error_code' => "INTERNAL_ERROR",
                                'error_description' => "This player doesnt exists"
                            ], ResponseAlias::HTTP_OK);
                        }
                    }
                } else {
                    if ($action == 'rollback') {
                        return response()->json([
                            'balance' => $walletUser->balance +$walletUser->balance_bonus,
                            'transaction_id' => $request->transaction_id,
                            'rollback_transactions' => collect($request->rollback_transactions)->pluck('transaction_id')->toArray()
                        ], ResponseAlias::HTTP_OK);
                    } else {
                        if(!empty($walletUser)) {
                            return response()->json([
                                'balance' => $walletUser->balance + $walletUser->balance_bonus,
                                'transaction_id' => $request->transaction_id,
                            ], ResponseAlias::HTTP_OK);
                        }

                        return response()->json([
                            'error_code' => "INTERNAL_ERROR",
                            'error_description' => "This player doesnt exists"
                        ], ResponseAlias::HTTP_OK);
                    }
                }
            }else{
                return response()->json([
                    'error_code' => "INTERNAL_ERROR",
                    'error_description' => "Conexão não existe"
                ], ResponseAlias::HTTP_OK);
            }
        } catch (\Exception $e) {
            \Log::info('Message error:' .  $e->getMessage());
            \Log::info('Line error:' .  $e->getLine());
            return response()->json(['error' => $e->getMessage(), 'line' => $e->getLine()], 400);
        }
    }

    /**
     * @param $request
     * @param $type
     * @param $nameGame
     * @param $gameId
     * @param bool $changeBonus
     * @return void
     */
    private function generateHistory($pdo, $playerId, $amount, $request, $type, $nameGame, $gameId, bool $changeBonus = false): void
    {
        $pdo->table('orders')->insert([
            'user_id' => $playerId,
            'session_id' => $request->session_id,
            'transaction_id' => $request->transaction_id,
            'type' => $type,
            'type_money' => $changeBonus ? 'balance_bonus' : 'balance',
            'amount' => $amount,
            'providers' => 'SloteGrator',
            'game' => $nameGame,
            'game_uuid' => $gameId,
            'round_id' => $request->round_id,
        ]);
    }

    /**
     * @param $request
     * @param $user
     * @param $nameGame
     * @param $historyBet
     * @return void
     */
    private function generateWalletChange($pdo, $request, $user, $nameGame, $historyBet = null): void
    {
        $title = $request->action == 'bet' ? 'loss' : 'win';

        $hisBet = 0;
        if ($historyBet != null) {
            $hisBet = $historyBet->amount;
        }


        // AQUI VERIFICA SE TEM AFILIADO, ATRIBUI PORCETAGEM PARA referRewards, NGR
        if (!empty($user->inviter) && $title === 'loss') {
            $config         = $pdo->table('settings')->first();
            $afiliado       = $pdo->table('users')->find($user->inviter);
            $afiliadoWallet = $pdo->table('wallets')->where('user_id', $user->inviter)->first();

            if (!empty($afiliadoWallet)) {

                $reward     = \Helper::porcentagem_xn($afiliado->affiliate_revenue_share, $request->amount);
                $rewardNgr  = \Helper::porcentagem_xn($config->ngr_percent, $reward);
                $calcReward = ($reward - $rewardNgr); /// tira a taxa de NGR

                $referRewards = $afiliadoWallet->refer_rewards + $calcReward;

                $pdo->table('wallets')
                    ->where('user_id', $user->inviter)
                    ->update([
                        'refer_rewards' => $referRewards
                    ]);

                /// atualizar o historico de revshare para o afiliado
                $pdo->table('affiliate_histories')
                    ->where('user_id', $user->id)
                    ->update([
                        'commission' => $calcReward,
                        'commission_type' => 'revshare'
                    ]);

                /// incrimentando o count de perda do usuário
                $affiliateHistory =  $pdo->table('affiliate_histories')
                    ->where('user_id', $user->id)
                    ->first();

                if(!empty($affiliateHistory)) {
                    $pdo->table('affiliate_histories')
                        ->where('user_id', $user->id)
                        ->update([
                            'losses' => $affiliateHistory->losses + 1,
                            'losses_amount' => $affiliateHistory->losses_amount + $request->amount
                        ]);
                }
            }
        }

        $pdo->table('wallet_changes')->insert([
            'reason' => $title,
            'change' => $request->action == 'bet' ? -number_format($request->amount, 2, '.', '') : number_format($request->amount, 2, '.', ''),
            'value_bonus' => 0,
            'value_total' => $request->amount,
            'value_roi' => $request->action == 'bet' ? 0 : $request->amount - $hisBet,
            'value_entry' => $request->action == 'bet' ? $request->amount : $hisBet,
            'game' => $nameGame,
            'user_id' => $user->id
        ]);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function limits()
    {
        try{
            $this->getCredentials(); // buscando as crendenciais

            $url            = $this->merchantUrl . '/limits';
            $merchantId     = $this->merchantId;
            $merchantKey    = $this->merchantKey;
            $nonce          = md5(uniqid(mt_rand(), true));
            $time           = time();

            $headers = [
                'X-Merchant-Id' => $merchantId,
                'X-Timestamp' => $time,
                'X-Nonce' => $nonce,
            ];

            $requestParams = [];

            $mergedParams = array_merge($requestParams, $headers);
            ksort($mergedParams);
            $hashString = http_build_query($mergedParams);

            $XSign = hash_hmac('sha1', $hashString, $merchantKey);

            ksort($requestParams);
            $postdata = http_build_query($requestParams);


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Merchant-Id: '.$merchantId,
                'X-Timestamp: '.$time,
                'X-Nonce: '.$nonce,
                'X-Sign: '.$XSign,
                'Accept: application/json',
                'Enctype: application/x-www-form-urlencoded',
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $result = json_decode(curl_exec($ch));

            return response()->json([
                'data' => $result
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
