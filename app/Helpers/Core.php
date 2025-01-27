<?php


namespace App\Helpers;

use App\Helpers\Core as Helper;
use App\Models\AffiliateHistory;
use App\Models\CustomLayout;
use App\Models\SpinConfigs;
use App\Models\Order;
use App\Models\Setting;
use App\Models\SubAffiliate;
use App\Models\User;
use App\Models\Vip;
use App\Models\VipUser;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use NumberFormatter;
use Illuminate\Support\Facades\Http;

class Core
{

    /**
     * Paga e atualiza o bonus vip
     *
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param Wallet $wallet
     * @param $price
     * @return void
     */
    public static function payBonusVip(Wallet $wallet, $price)
    {
        $setting = Setting::first();

        if($setting->activate_vip_bonus) {
            $wallet->increment('vip_points', $price * $setting->bonus_vip);

            /// verificar se subiu de level
            $vip = Vip::where('bet_required', '<=', $wallet->vip_points)->first();
            if(!empty($vip)) {

                /// verificar se já subiu pra esse nivel
                $checkVip = VipUser::where('user_id', $wallet->user_id)->where('vip_id', $vip->id)->where('status', 1)->first();
                if(empty($checkVip)) {
                    VipUser::create([
                        'user_id' => $wallet->user_id,
                        'vip_id' => $vip->id,
                        'status' => 1
                    ]);

                    /// atualiza o level vip
                    $wallet->increment('vip_level', 1);
                }
            }
        }
    }


    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $wallet
     * @param $balance
     * @return void
     */
    public static function lossRollover($wallet, $balance): void
    {
        if($wallet->balance_deposit_rollover > 0 && !empty($wallet->balance_deposit_rollover)) {
            $wallet->decrement('balance_deposit_rollover', $balance);
        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $userId
     * @param $changeBonus
     * @param $WinAmount
     * @return void
     */
    public static function payWithRollover($userId, $changeBonus, $WinAmount): void
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        if(!empty($wallet)) {

            /// verificar se é bonus ou balance
            if($changeBonus == 'balance_bonus') {
                /// verificar a quantidade de rollover
                if($wallet->balance_bonus_rollover <= 0 || empty($wallet->balance_bonus_rollover)) {
                    $wallet->increment('balance_withdrawal', $WinAmount);
                }else{
                    /// verifica se o valor do rollover é maior que o ganho, se sim, decrementa o valor
                    if($wallet->balance_bonus_rollover > $WinAmount) {
                        $wallet->decrement('balance_bonus_rollover', $WinAmount);
                        $wallet->increment('balance_bonus', $WinAmount);
                    }else{
                        /// caso contrario define como zero.
                        $wallet->update(['balance_bonus_rollover' => 0]);

                        /// converte em saldo real
                        $wallet->increment('balance_withdrawal', $WinAmount);
                    }
                }
            }else{
                if(empty($wallet->balance_deposit_rollover) || $wallet->balance_deposit_rollover <= 0) {
                    /// pagando o ganhos na carteira de saque
                    $wallet->increment('balance_withdrawal', $WinAmount);
                }else{
                    /// verifica se o valor do rollover é maior que o ganho, se sim, decrementa o valor
                    if($wallet->balance_deposit_rollover >= $WinAmount) {
                        $wallet->decrement('balance_deposit_rollover', $WinAmount);

                        // volta com o dinheiro para jogar
                        $wallet->increment('balance', $WinAmount);
                    }else{
                        /// caso contrario define como zero.
                        $wallet->update(['balance_deposit_rollover' => 0]);

                        /// converte em saldo real
                        $wallet->increment('balance_withdrawal', $WinAmount);
                    }
                }
            }
        }
    }

    /**
     * Distribuições
     *
     * Pega todas as distribuições
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return string[]
     */
    public static function getDistribution(): array
    {
        return [
            'source' => 'Código Fonte',
            'slotegrator' => 'Slotegrator',
            'salsa' => 'Salsa',
            'fivers' => 'Fivers',
            'kagaming' => 'KaGaming',
            'vibra_gaming' => 'Vibra Gaming',
            'worldslot' => 'Worldslot',
            'games2_api' => 'Games2Api'
        ];
    }


    /**
     * @param $order
     * @return string
     */
    public static function getTypeTransactionOrder($order)
    {
        switch ($order) {
            case 'balance_bonus':
                return 'Saldo Bônus';

            case 'balance':
                return 'Saldo Depósito';

            case 'balance_withdrawal':
                return 'Saldo de Saque';

        }
    }

    /**
     * @param $order
     * @return string
     */
    public static function getTypeOrder($order)
    {
        if($order == 'win') {
            return 'Vitória';
        }

        return 'Perda';
    }

    /**
     * Get Ative Wallet
     * Pegar uma carteira ativa
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return null
     */
    public static function getActiveWallet()
    {
        if(auth('api')->check()) {
            return Wallet::where('user_id', auth('api')->id())->where('active', 1)->first();
        }

        return null;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return void
     */
    public static function getGoogleFonts()
    {
        $response = Http::get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDQCZFgODu0jw7Ez00jgQU04SUsuncY3yQ');
        if($response->successful()) {

        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $tamanhoCodigo
     * @return string
     */
    public static function generateCode($tamanhoCodigo)
    {
        $caracteresPermitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $codigo = '';

        for ($i = 0; $i < $tamanhoCodigo; $i++) {
            $codigo .= $caracteresPermitidos[rand(0, strlen($caracteresPermitidos) - 1)];
        }

        return $codigo;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $odds
     * @return float|int
     */
    public static function calculateProbability($odds)
    {
        $odds = abs($odds);

        $probabilidade = 1 / $odds;
        return $probabilidade;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $golsCasa
     * @param $golsVisitante
     * @param $oddsCasa
     * @param $oddsVisitante
     * @param float $multi
     * @return float|int
     */
    public static function calculateResultOdds($golsCasa, $golsVisitante, $oddsCasa, $oddsVisitante, float $multi = 2): float|int
    {
        // Calcula a média de gols esperada usando uma média ponderada
        $mediaGols = ($golsCasa * $oddsCasa + $golsVisitante * $oddsVisitante) / ($oddsCasa + $oddsVisitante);

        // Calcula a probabilidade de não haver gols
        $probabilidadeZeroGols = exp(-$mediaGols);

        // Calcula o novo odds para 0 gols
        $novoOdds = 1 / $probabilidadeZeroGols;

        return $novoOdds;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $data
     * @return string|void
     */
    public static function getMatcheResult($data)
    {
        switch ($data) {
            case 0:
                return 'Pendente';
            case 1:
                return 'Finalizado';
        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $key
     * @return string
     */
    public static function checkPixKeyType($key)
    {
        switch ($key) {
            case self::isCPF($key):
            case self::isCNPJ($key):
                return 'document';
            case self::isTelefone($key):
                return 'phoneNumber';
            default:
                return 'randomKey';
        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $key
     * @return string|void
     */
    public static function formatPixType($key)
    {
        switch ($key) {
            case 'document':
                return 'Documento';
            case 'phoneNumber':
                return 'Telefone';
            case 'email':
                return 'E-mail';
            case 'randomKey':
                return 'Chave Aleatória';
            default:
                return $key;
        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $string
     * @return bool
     */
    private static function isTelefone($valor)
    {
        //processa a string mantendo apenas números no valor de entrada.
        $valor = preg_replace("/[^0-9]/", "", $valor);

        $lenValor = strlen($valor);

        //validando a quantidade de caracteres de telefone fixo ou celular.
        if($lenValor != 10 && $lenValor != 11) {
            return false;
        }


        //DD e número de telefone não podem começar com zero.
        if($valor[0] == "0" || $valor[2] == "0") {
            return false;
        }


        return true;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $string
     * @return bool
     */
    private static function isCNPJ($string)
    {
        // Remove caracteres não numéricos
        $cnpj = preg_replace('/[^0-9]/', '', $string);

        // Verifica se a string tem 14 caracteres numéricos
        if (strlen($cnpj) !== 14) {
            return false;
        }

        return true; // Retorne true se for um CNPJ válido
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $string
     * @return bool
     */
    private static function isCPF($cpf)
    {
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $nomeCompleto
     * @return string
     *
     */
    public static function hideString($nomeCompleto)
    {
        $primeiraParteNome = substr($nomeCompleto, 0, 2);
        $asteriscos = str_repeat('*', 4);
        $nomeOculto = $primeiraParteNome . $asteriscos;  // Neste caso, "Vic******"

        return $nomeOculto;
    }


    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $controllerName
     * @return mixed
     * @throws \Exception
     */
    public static function createController($controllerName)
    {
        $fullControllerName = "App\Http\Controllers\Games\\" . ucfirst($controllerName) . "Controller";

        if (class_exists($fullControllerName)) {
            return new $fullControllerName();
        } else {
            // Caso a classe não exista, você pode lidar com isso aqui
            throw new \Exception("Controller não encontrado: $fullControllerName");
        }
    }

    /**
     * Generate Game History
     * Metodo responsavel pelo historico dos jogos, e também controle de  ganhos de afiliados
     * Como revshare e CPA.
     *
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $userId
     * @param $type
     * @param $amount
     * @param $nameGame
     * @param $gameId
     * @param $changeBonus
     * @return mixed
     */
    public static function generateGameHistory($userId, $type, $win, $bet, $changeBonus, $tx)
    {
        $user       = User::find($userId);
        $affiliate  = User::find($user->inviter);

        /// pagar afiliado
        if($type == 'loss' && !empty($user->inviter)) {
            $affiliate = User::find($user->inviter);
            self::PayLoss($user, $affiliate, $bet, $changeBonus);
        }

        self::PayWin($user, $affiliate, $type, $win, $changeBonus);

        /// pagando o premio
        if (!$user->is_demo_agent) {
            if(floatval($win) > 0) {

                /// atualiza os ganhos da vitoria
                self::payWithRollover($userId, $changeBonus, $win); /// verifica o rollover
            }
        }

        if($type == 'win') {
            $transaction = Order::where('transaction_id', $tx)->first();
            if(!empty($transaction)) {
                if($transaction->update(['status' => 1, 'type' => $type])) {
                    return true;
                }

                return false;
            }
        }else{
            $transaction = Order::where('transaction_id', $tx)->first();
            if(!empty($transaction)) {
                if($transaction->update(['status' => 1, 'type' => $type])) {
                    return false;
                }

                return false;
            }
        }
    }

    /**
     * PayLoss
     *
     * @param $user
     * @param $affiliate
     * @param $bet
     * @param $changeBonus
     * @return float|int
     */
    private static function PayLoss($user, $affiliate, $bet, $changeBonus)
    {
        $setting    = self::getSetting();

        if(!empty($affiliate)) {
            $affHistoryRevshare = AffiliateHistory::where('user_id', $user->id)
                ->where('commission_type', 'revshare')
                //->where('deposited', 1)
                ->where('status', 0)
                ->first();

            if(!empty($affHistoryRevshare) && in_array($changeBonus, ['balance', 'balance_withdrawal'])) {

                /// verificar qual revshare pagar, o fake ou o padrão
                $revshare = $affiliate->affiliate_revenue_share_fake ?? $affiliate->affiliate_revenue_share;

                $lossPercentage = self::porcentagem_xn($revshare, $bet); /// calcula a porcentagem da perda, com o valor apostado na variavel $bet
                $ngr = self::porcentagem_xn($setting->ngr_percent, $lossPercentage); /// calcula a porcentagem do ngr

                $commissionPay = ($lossPercentage - $ngr); /// subtrai o ngr

                /// salva o historico de perdas
                $affHistoryRevshare->increment('losses', 1);
                $affHistoryRevshare->increment('losses_amount', $commissionPay);

                /// verificar a arvore de subafiliados

                /// level 1
                if(!empty($affiliate->inviter)) {
                    $affiliatelv1 = User::find($affiliate->inviter);
                    if(!empty($affiliatelv1)) {

                        /// pagando lvl1
                        $percentageLvl1 = self::porcentagem_xn($setting->perc_sub_lv1, $commissionPay); /// calcula a porcentagem da perda, com o valor apostado na variavel $bet
                        $affiliatelv1->wallet->increment('refer_rewards', $percentageLvl1);


                        $commissionPay = ($commissionPay - $percentageLvl1);

                        /// level 2
                        if(!empty($affiliatelv1->inviter)) {
                            $affiliatelv2 = User::find($affiliatelv1->inviter);
                            if(!empty($affiliatelv2)) {
                                /// pagando lvl2
                                $percentageLvl2 = self::porcentagem_xn($setting->perc_sub_lv2, $commissionPay); /// calcula a porcentagem da perda, com o valor apostado na variavel $bet
                                $affiliatelv2->wallet->increment('refer_rewards', $percentageLvl2);

                                $commissionPay = ($commissionPay - $percentageLvl2);

                                /// level 3
                                $affiliatelv3 = User::find($affiliatelv2->inviter);
                                if(!empty($affiliatelv3)) {
                                    /// pagando lvl3
                                    $percentageLvl3 = self::porcentagem_xn($setting->perc_sub_lv3, $commissionPay); /// calcula a porcentagem da perda, com o valor apostado na variavel $bet
                                    $affiliatelv3->wallet->increment('refer_rewards', $percentageLvl3);

                                    $commissionPay = ($commissionPay - $percentageLvl3);
                                }
                            }
                        }
                    }
                }

                /// Pagando o afiliado principal
                $affiliate->wallet->increment('refer_rewards', $commissionPay); /// afiliado ganha a comissão
                $affHistoryRevshare->increment('commission', $commissionPay); /// valor pago de comissão
                $affHistoryRevshare->increment('commission_paid', $commissionPay); /// valor pago de comissão historico

                return ($bet - $commissionPay);
            }
        }
    }

    /**
     * @param $user
     * @param $affiliate
     * @param $type
     * @param $amount
     * @param $changeBonus
     * @return float|int|void
     */
    private static function PayWin($user, $affiliate, $type, $amount, $changeBonus)
    {

        $wallet     = Wallet::where('user_id', $user->inviter)->where('active', 1)->first();
        $setting    = self::getSetting();

        /// subtrair afiliado ganhos
        if($setting->revshare_reverse) {
            if($type == 'win' && !empty($user->inviter) && in_array($changeBonus, ['balance', 'balance_withdrawal'])) {
                \Log::info('REVSHARE NEGATIVO AQUI');

                if(!empty($affiliate)) {
                    $affHistoryRevshare = AffiliateHistory::where('user_id', $user->id)
                        ->where('commission_type', 'revshare')
                        //->where('deposited', 1)
                        ->where('status', 0)
                        ->first();

                    if(!empty($affHistoryRevshare)) {
                        /// verificar qual revshare pagar, o fake ou o padrão
                        $revshare = $affiliate->affiliate_revenue_share_fake ?? $affiliate->affiliate_revenue_share;


                        $commissionSub = self::porcentagem_xn($revshare, $amount); /// calcula a porcentagem da perda, com o valor ganhado na variavel $amount
                        $wallet->decrement('refer_rewards', $commissionSub); /// remove do afiliado o valor perdido pelo apostador

                        \Log::info('REVSHARE NEGATIVO DECREMENTADO: '.($amount - $commissionSub));
                        return $amount;
                    }
                    return $amount;
                }
                return $amount;
            }
            return $amount;
        }
        return $amount;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $arr
     * @return int|mixed
     */
    public static function CountScatter($arr)
    {
        $count_scarter = array_count_values($arr);

        if (isset($count_scarter['Symbol_1'])) {
            return $count_scarter['Symbol_1'];
        }

        return 0;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $drops
     * @return int[]
     */
    public static function MultiplyCount($drops)
    {
        global $multiples;
        if ($drops > 3) {
            $drops = 3;
        }
        return $multiples[$drops] ?? null;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $val
     * @param $digits
     * @return float
     */
    public static function ToFloat($val, $digits = 2) {
        return (float)number_format($val, $digits, '.', '');
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $lines
     * @return float|int|mixed
     */
    public static function CalcWinActiveLine($lines) {
        $aux = 0;

        if (sizeof($lines) > 0) {
            foreach($lines as $line) {
                $aux = $aux + ($line['payout'] * $line['multiply']);
            }
        }

        return $aux;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $drops
     * @param $mult
     * @return array
     */
    public static function CalcWinDropLine($drops, $mult) {
        $total = 0;
        foreach($drops as $drop) {
            $amout = self::CalcWinActiveLine($drop['ActiveLines']);
            $total = $total + $amout;
            // $drop['ActiveLines']['win_amount'] = $amout;
        }
        $total = $total * $mult;
        return compact(['drops', 'total']);
    }


    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $data
     */
    public static function arrayToObject($data)
    {
        $collection = collect($data);

        $objects = $collection->map(function ($item) {
            return array_combine(range(1, count($item)), $item);
        });

        return $objects;
    }


    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return null
     */
    public static function getToken()
    {
        if(auth()->check()) {
            $token = \Helper::MakeToken([
                'id' => auth()->id()
            ]);

            return $token;
        }

        return null;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return float
     */
    public static function getBalance()
    {
        if(auth()->check()) {
            return self::amountFormatDecimal(auth()->user()->wallet->balance + auth()->user()->wallet->balance_bonus);
        }else{
            return self::amountFormatDecimal(0.00);
        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Get Settings
     * @return \Illuminate\Cache\
     */
    public static function getCustom()
    {
        $custom = null;
        if(Cache::has('custom')) {
            $custom = Cache::get('custom');
        }else{
            $custom = CustomLayout::first();
            Cache::put('custom', $custom);
        }

        return $custom;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Get Settings
     * @return \Illuminate\Cache\
     */
    public static function getSetting()
    {
        $setting = null;
        if(Cache::has('setting')) {
            $setting = Cache::get('setting');
        }else{
            $setting = Setting::select(
                'software_name',
                'software_description',
                'software_logo_white',
                'software_logo_black',
                'currency_code',
                'decimal_format',
                'currency_position',
                'prefix',
                'storage',
                'min_deposit',
                'max_deposit',
                'min_withdrawal',
                'max_withdrawal',
                'initial_bonus',
                'suitpay_is_enable',
                'stripe_is_enable',
                'disable_spin',
            )->first();

            Cache::put('setting', $setting);
        }

        return $setting;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $bytes
     * @return string
     */
    public static function bytesToHuman($bytes)
    {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Amount Format Decimal
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     *
     * @param $value
     * @return string
     */
    public static function amountFormatDecimalAdmin($value)
    {
        if(auth()->check()) {
            $wallet = Wallet::whereUserId(auth()->user()->id)->first();

            $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);
            return $formatter->formatCurrency(floatval($value), $wallet->currency);
        }

        return 0;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Amount Format Decimal
     *
     * @param $value
     * @return string
     */
    public static function amountFormatApi($value)
    {
        if(auth('api')->check()) {
            $wallet = Wallet::whereUserId(auth('api')->user()->id)->first();

            $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);
            return $formatter->formatCurrency(floatval($value), $wallet->currency);
        }

        return 0;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Amount Format Decimal
     *
     * @param $value
     * @return string
     */
    public static function amountFormatDecimal($value)
    {
        $settings = self::getSetting();

        if ($settings->currency_code == 'JPY') {
            return $settings->currency_symbol.number_format($value);
        }

        if ($settings->decimal_format == 'dot') {
            $decimalDot = ',';
            $decimalComma = '.';
        } else {
            $decimalDot = '.';
            $decimalComma = ',';

        }

        if ($settings->currency_position == 'left') {
            $amount = ($settings->prefix ?? 'R$').number_format(floatval($value), 2, $decimalDot, $decimalComma);
        } elseif ($settings->currency_position == 'right') {
            $amount = number_format(floatval($value), 2, $decimalDot, $decimalComma).($settings->prefix ?? 'R$');
        } else {
            $amount = $settings->prefix.number_format(floatval($value), 2, $decimalDot, $decimalComma);
        }

        return $amount;
    }

    /**
     * Days In Month
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     *
     * @param $month
     * @param $year
     * @return int
     */
    public static function daysInMonth($month, $year)
    {
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $date
     * @return array|string|string[]
     */
    public static function formatDateToHumman($date)
    {
        $created_at = Carbon::parse($date)->diffForHumans();
        $created_at = str_replace([' seconds', ' second'], ' sec', $created_at);
        $created_at = str_replace([' minutes', ' minute'], ' min', $created_at);
        $created_at = str_replace([' hours', ' hour'], ' h', $created_at);
        $created_at = str_replace([' months', ' month'], ' m', $created_at);

        if(preg_match('(years|year)', $created_at)){
            $created_at = Carbon::parse($date)->toFormattedDateString();
        }

        return $created_at;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $string
     * @return mixed
     */
    public static function getFirstUrl($string)
    {
        preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $string, $_matches);
        $firstURL = $_matches[0][0] ?? false;
        if ($firstURL) {
            return $firstURL;
        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $url
     * @return string
     */
    public static function videoUrl($url)
    {
        $urlValid = filter_var($url, FILTER_VALIDATE_URL) ? true : false;

        if ($urlValid) {
            $parse = parse_url($url);
            $host  = strtolower($parse['host']);

            if ($host) {
                if (in_array($host, array(
                    'youtube.com',
                    'www.youtube.com',
                    'youtu.be',
                    'www.youtu.be',
                    'vimeo.com',
                    'player.vimeo.com'))) {
                    return $host;
                }
            }
        }
    }


    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Upload
     *
     * @param $file
     * @return array
     */
    public static function upload($file)
    {
        $extension  = $file->extension();
        $size       = $file->getSize();
        $path       = Storage::disk('public')->putFile('uploads', $file, 'public');
        $name       = explode('uploads/', $path);

        if($path && isset($name[1])) {
            return [
                'path'      => $path,
                'name'      => $name[1],
                'extension' => $extension,
                'size'      => $size
            ];
        }else{
            return false;
        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Format Number
     *
     * @param $number
     * @return mixed|string
     */
    public static function formatNumber( $number )
    {
        if( $number >= 1000 &&  $number < 1000000 ) {
            return number_format( $number/1000, 1 ). "k";
        } else if( $number >= 1000000 ) {
            return number_format( $number/1000000, 1 ). "M";
        } else {
            return $number;
        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Check Text
     */
    public static function checkText($str, $url = null)
    {
        if(mb_strlen($str, 'utf8') < 1) {
            return false;
        }

        $str = str_replace($url, '', $str);

        $str = trim($str);
        $str = nl2br(e($str));
        $str = str_replace(array(chr(10), chr(13) ), '' , $str);
        $url = preg_replace('#^https?://#', '', url('').'/');

        $regex = "~([@])([^\s@!\"\$\%&\'\(\)\*\+\,\-./\:\;\<\=\>?\[/\/\/\\]\^\`\{\|\}\~]+)~";
        $str = preg_replace($regex, '<a href="//'.$url.'$2">$0</a>', $str);

        $str = stripslashes($str);
        return $str;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $path
     * @return string
     */
    public static function getFile($path)
    {
        return url($path);
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Prepare Fields Array
     *
     * @param $data
     * @return array
     */
    public static function prepareFieldsArray($data)
    {
        return array_filter($data);
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $bytes
     * @param int $precision
     * @return string
     */
    public static function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $extension
     * @return string|null
     */
    public static function fileTypeUpload($extension)
    {
        switch ($extension) {
            case 'jpeg':
            case 'bmp':
            case 'png':
            case 'gif':
            case 'jfif':
            case 'jpg':
            case 'svg':
                return 'image';
                break;

            case 'doc':
            case 'pdf':
            case 'docx':
            case 'txt':
                return 'document';
                break;

            case 'mp3':
            case 'wav':
                return 'audio';
                break;

            case 'rar':
            case 'zip':
                return 'file';
                break;

            case 'mov':
            case 'ts':
            case 'm3u8':
            case 'flv':
            case '3gp':
            case 'ogg':
            case 'mp4':
            case 'avi':
                return 'video';
                break;
            default:
                return 'image';
                break;
        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $country
     * @return bool
     */
    public static function getCountry($country)
    {
        if(!is_null($country)) {
            $country = \DB::table('countries')->where('iso', strtoupper($country))->first();
            if(!is_null($country)) {
                return $country->name;
            }

            return $country;
        }
        return 'US';
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $country
     * @return bool
     */
    public static function getCountryByCode($country)
    {
        if(!is_null($country)) {
            $country = \DB::table('countries')->where('iso', strtoupper($country))->first();
            if(!is_null($country)) {
                return $country->name;
            }

            return $country;
        }
        return 'US';
    }


    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Format Checkbox
     * @param $value
     * @return int
     */
    public static function formatCheckBox($value)
    {
        return ($value == 'yes' ? 1 : 0);
    }

    /**
     *
     * Função de porcentagem: Quanto é X% de N?
     * // Utilização
    echo "Quanto é 11% de 22: <b>" . porcentagem_xn(11, 22) . "</b> rn <br>";
    echo "Quanto é 22% de 11: <b>" . porcentagem_xn(22, 11) . "</b> rn <br>";
    echo "Quanto é 99% de 100: <b>" . porcentagem_xn(99, 100) . "</b> rn <br>";
    echo "Quanto é 99% de 105: <b>" . porcentagem_xn(99, 105) . "</b> rn <br>";
    echo "Quanto é 201% de 105: <b>" . porcentagem_xn(201, 105) . "</b> rn <br>";
     * @param $porcentagem
     * @param $total
     * @return float|int
     */
    public static function porcentagem_xn( $porcentagem, $total )
    {
        \Log::info('porcentagem' . json_encode($porcentagem));
        \Log::info('total' . json_encode($total));

        return ( $porcentagem / 100 ) * $total;
    }

    /**
     * Função de porcentagem: N é X% de N
     *
    echo "2.42 é <b>" . porcentagem_nx(2.42, 22) . "%</b> de 22.rn <br>";
    echo "2.42 é <b>" . porcentagem_nx(2.42, 11) . "%</b> de 11.rn <br>";
    echo "99 é <b>" . porcentagem_nx(99, 100) . "%</b> de 100.rn <br>";
    echo "103.95 é <b>" . porcentagem_nx(103.95, 105) . "%</b> de 105.rn <br>";
    echo "211.05 é <b>" . porcentagem_nx(211.05, 105) . "%</b> de 105.rn <br>";
     * @param $parcial
     * @param $total
     * @return float|int
     */
    public static function porcentagem_nx( $parcial, $total ) {
        if(!empty($parcial) && !empty($total)) {
            return ( $parcial * 100 ) / $total;
        }else{
            return 0;
        }
    }

    /**
     * Função de porcentagem: N é N% de X
     * // Utilização
    echo "2.42 é 11% de <b>" . porcentagem_nnx ( 2.42, 11 ) . "</b></b>.rn <br>";
    echo "2.42 é  22% de <b>" . porcentagem_nnx ( 2.42, 22 ) . "</b></b>.rn <br>";
    echo "99 é 100% de <b>" . porcentagem_nnx ( 99, 100 ) . "</b></b>.rn <br>";
    echo "103.95 é  99% de <b>" . porcentagem_nnx ( 103.95, 99 ) . "</b></b>.rn <br>";
    echo "2.42 é 11% de <b>" . porcentagem_nnx ( 211.05, 201 ) . "</b></b>.rn <br>";
    echo "337799 é 70% de <b>" . porcentagem_nnx ( 337799, 70 ) . "</b></b>.rn <br>";
     * @param $parcial
     * @param $porcentagem
     * @return float|int
     */
    function  porcentagem_nnx( $parcial, $porcentagem ) {
        return ( $parcial / $porcentagem ) * 100;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $value
     * @return mixed
     */
    public static function formatCurrencyByRegion($amount, $currency = 'BRL'): mixed
    {
        $locale = str_replace('_', '-', app()->getLocale()); // Substitua pelo código do país/região desejado

        // Crie um objeto NumberFormatter para a região desejada
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        // Formate o valor da moeda usando o NumberFormatter
        $formattedCurrency = $formatter->formatCurrency($amount, $currency); // Substitua 'BRL' pelo código da moeda desejada

        // Retorne o valor formatado
        return $formattedCurrency;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $str
     * @return null|string|string[]
     */
    public static function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * Amount Prepare
     * @param $float_dollar_amount
     * @return string
     */
    public static function amountPrepare($float_dollar_amount)
    {
        $separators_only = preg_filter( '/[^,\.]/i', '', $float_dollar_amount );

        if ( strlen( $separators_only ) > 1 ) {
            if ( substr( $separators_only, 0, 1) == '.' ) {
                $float_dollar_amount = str_replace( '.', '', $float_dollar_amount );
                $float_dollar_amount = str_replace( ',', '.', $float_dollar_amount );

            } else if ( substr( $separators_only, 0, 1) == ',' ) {
                $float_dollar_amount = str_replace( ',', '', $float_dollar_amount );
            }

        } else if ( strlen( $separators_only ) == 1 && $separators_only == ',' ) {
            $float_dollar_amount = str_replace( ',', '.', $float_dollar_amount );
        }

        return $float_dollar_amount;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $currency
     * @return string
     */
    public static function checkPrefixCurrency($currency)
    {
        switch ($currency) {
            case '$':
                return 'USD';
                break;
            case 'R$':
                return 'BRL';
                break;
            default:
                return 'USD';
        }
    }


    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $array
     * @return mixed
     */
    public static function MakeToken($array){
        if(is_array($array)){
            $output =  '{"status": true';
            $interacao = 0;
            foreach ($array as $key => $value){
                $output .=  ',"' .$key . '"' . ': "' . $value . '"';
            }
            $output .= "}";
        }else{
            $er_txt = self::Decode('QVakfW0DwcOie2aD9kog9oRx81VtX73oY1Vn91o7YVamZVa2eVaxYkwofGadZGadfGope2aB9zJgbVapYXJgX5R6YWJgeGgg9h');
            $output = str_replace('_', '&nbsp;', $er_txt);
            exit($output);
        }
        return self::Encode($output);
    }


    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $token
     * @return mixed|string
     */
    public static function DecToken($token){
        $json = self::Decode($token);
        if(is_numeric($json)){
            return $token;
        }else if(self::isJson($json)){
            $json = str_replace("{\"email", "{\"status\":true ,\"email", $json);
            return json_decode($json, true);
        }else{
            return array("status"=>false, "messase"=>"invalid token");
        }
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $string
     * @return bool
     */
    private static function isJson($string){
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $texto
     * @return string
     */
    public static function Encode($texto){
        $retorno = "";
        $saidaSubs = "";
        $texto = base64_encode($texto);
        $busca0 = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","x","w","y","z","0","1","2","3","4","5","6","7","8","9","=");
        $subti0 = array("8","e","9","f","b","d","h","g","j","i","m","o","k","z","l","w","4","s","r","u","t","x","v","p","6","n","7","2","1","5","q","3","y","0","c","a","");

        for($i=0;$i<strlen($texto);$i++){
            $ti = array_search($texto[$i], $busca0);
            if($busca0[$ti] == $texto[$i]){
                $saidaSubs .= $subti0[$ti];
            }else{
                $saidaSubs .= $texto[$i];
            }
        }
        $retorno = $saidaSubs;

        return $retorno;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @param $texto
     * @return string
     */
    public static function Decode($texto){
        $retorno = "";
        $saidaSubs = "";
        $busca0 = array("8","e","9","f","b","d","h","g","j","i","m","o","k","z","l","w","4","s","r","u","t","x","v","p","6","n","7","2","1","5","q","3","y","0","c","a");
        $subti0 = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","x","w","y","z","0","1","2","3","4","5","6","7","8","9");

        for($i=0;$i<strlen($texto);$i++){
            $ti = array_search($texto[$i], $busca0);
            if($busca0[$ti] == $texto[$i]){
                $saidaSubs .= $subti0[$ti];
            }else{
                $saidaSubs .= $texto[$i];
            }
        }

        $retorno = base64_decode($saidaSubs);

        return $retorno;
    }

    /**
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * @return mixed
     */
    public static function WheelPrizes() {
        $key = 'spin:config:prizes';
        $cached = Cache::get($key);
        $config = NULL;

        if(!$cached) {
            $c = SpinConfigs::latest()->first();
            $str = $c->prizes;
            Cache::set($key, $str);
            $config = json_decode($str);
        } else {
            $config = json_decode($cached);
        }

        return $config;
    }
}
?>
