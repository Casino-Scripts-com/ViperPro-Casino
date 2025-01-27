<?php


namespace App\Traits\Gateways;

use App\Models\Gateway;
use App\Models\User;

trait StripeTrait
{
    /**
     * @var
     */
    protected static $stripe;


    /**
     * @param $gateway
     * @return \Stripe\StripeClient
     */
    private static function getAuth()
    {
        try {
            $gateway = Gateway::first();

            if(!empty($gateway)) {
                self::$stripe = new \Stripe\StripeClient( $gateway->getAttributes()['stripe_secret_key']);
                return self::$stripe;
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'erros' => $e->getMessage()], 400);
        }
    }


    /**
     * @param $price
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public static function stripeSession($price, $currency)
    {
        try {
            if(self::getAuth()) {
                $checkout = self::$stripe->checkout->sessions->create([
                    'client_reference_id' => auth('api')->id(),
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => strtolower($currency),
                                'unit_amount' => intval($price) * 100,
                                'product_data' => [
                                    'name' => trans('Recharge'),
                                    'description' => 'Recharge',
                                ],
                            ],
                            'quantity' => 1,
                        ]
                    ],
                    'mode' => 'payment',
                    'success_url'=> url('/stripe/success'),
                    'cancel_url' => url('/stripe/cancel'),
                ]);

                return $checkout;
            }

            return response()->json(['error' => 'Erro ao criar sessão'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Sessão não criada'], 500);
        }
    }

    /**
     * @param $card
     * @return \Stripe\Token
     * @throws \Stripe\Exception\ApiErrorException
     */
    public static function createTokenStripe($card)
    {
        try {
            if(self::getAuth()) {
                $response = self::$stripe->tokens->create([
                    'card' => [
                        'number'    => $card['cardNumber'],
                        'exp_month' => $card['cardMonth'],
                        'exp_year'  => $card['cardYear'],
                        'cvc'       => $card['cardCvv'],
                    ],
                ]);

                return $response;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Create Payment Method Id
     *
     * @param $card
     * @return mixed
     * @throws \Exception
     */
    public static function createPaymentMethod($card)
    {
        try {
            $response = self::$stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number'    => $card['cardNumber'],
                    'exp_month' => $card['cardMonth'],
                    'exp_year'  => $card['cardYear'],
                    'cvc'       => $card['cardCvv'],
                ],
            ]);

            return $response;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Delete Credit Card By User
     *
     * @param $customer_id
     * @param $token
     * @return mixed
     * @throws \Exception
     */
    public static function deleteCreditCardStripe($customer_id, $token)
    {
        try {
            if(self::getAuth()) {
                $response = self::$stripe->customers->deleteSource(
                    $customer_id,
                    $token,
                    []
                );

                return $response;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $email
     * @param $token
     * @return bool
     */
    public static function createCustomer($email, $token)
    {
        try {
            if(self::getAuth()) {
                $response = self::$stripe->customers->create([
                    'email' => $email,
                    'source' => $token
                ]);

                return $response;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $customer_id
     * @param $plan
     * @param null $stripe_account_id
     * @param null $fee_commission_platform
     * @return bool|\Stripe\Subscription
     */
    public static function createSubscription($customer_id, $plan, $stripe_account_id = null, $fee_commission_platform = null)
    {
        try {
            if(self::getAuth()) {
                if(empty($stripe_account_id) && empty($fee_commission_platform)) {
                    $subscription = self::$stripe->subscriptions->create([
                        'customer' => $customer_id,
                        'items' => [
                            ['plan' => $plan],
                        ],
                    ]);
                }else{
                    $subscription = self::$stripe->subscriptions->create([
                        'customer' => $customer_id,
                        'items' => [
                            ['plan' => $plan],
                        ],
                        'transfer_data' => [
                            'destination' => $stripe_account_id,
                            'amount_percent' => (100 - $fee_commission_platform)
                        ]
                    ]);
                }

                return $subscription;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $customer_id
     * @param $amount
     * @return
     * @throws \Exception
     */
    public static function createPayment($customer_id, $amount)
    {
        try {
            if(self::getAuth()) {
                $payment_methods = self::$stripe->paymentMethods->all([
                    'customer' => $customer_id,
                    'type' => 'card',
                ]);

                if(isset($payment_methods->data[0]->id)) {
                    $payment_method_id = $payment_methods->data[0]->id;

                    $intent = self::$stripe->paymentIntents->create([
                        'payment_method'        => $payment_method_id,
                        'amount'                => \Helper::amountPrepare($amount * 100),
                        'currency'              => 'usd',
                        'customer'              => $customer_id,
                        'payment_method_types'  => ['card'],
                        'confirmation_method'   => 'manual',
                        'confirm' => true
                    ]);

                    if(isset($intent->id)) {
                        $retrive = self::$stripe->paymentIntents->retrieve(
                            $intent->id
                        );

                        //$intent->confirm();

                        if($retrive->status == "succeeded") {

                            return $intent;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }


    }

    /**
     * @param $id
     * @return bool
     */
    public static function cancelSubscriptionStripe($id)
    {
        try {
            if(self::getAuth()) {
                $subscription = self::$stripe->subscriptions->cancel(
                    $id,
                    []
                );

                return $subscription;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $plan_id
     * @param $gateway
     * @param $price
     * @param $period
     */
    private static function createPlanStripe($plan_id, $price, $period)
    {

    }
}
