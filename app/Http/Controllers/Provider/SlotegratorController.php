<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\CasinoGamesSlotgrator;
use App\Traits\Providers\SlotegratorTrait;
use Illuminate\Http\Request;

class SlotegratorController extends Controller
{
    use SlotegratorTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gamesSlotgrator = CasinoGamesSlotgrator::limit(24)->whereActive(1)->orderBy('views', 'desc')->get();
        return response()->json([
            'gamesSlotgrator' => $gamesSlotgrator
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function selfValidationMethod()
    {
        return $this->selfvalidation();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function webhookMethod(Request $request)
    {
        return $this->webhooks($request);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function limitMethod()
    {
        return $this->limits();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = CasinoGamesSlotgrator::whereSlug($id)->first();
        if(!empty($game)) {
            if(auth('api')->check()) {
                $token = '';
                $time = time()-34;

                // FORCANDO A PESSOA IR TELA BANIDO
                if(auth('api')->user()->banned) return redirect()->to('/banned');

                $token = hash('sha256','md5 cassino'.md5(auth('api')->user()->email.'-'.time()));
                //\DB::table('users')->where('email',auth('api')->user()->email)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));

                $gameProvider = null;

                if($game->provider_service == 'slotegrator') {
                    $gameProvider = $this->startGameSlotegrator($game->uuid);
                }

                if(!empty($gameProvider) && $gameProvider['status']) {
                    $game->increment('views', 1);

                    return response()->json([
                        'status' => true,
                        'game' => $game,
                        'token' => $token,
                        'gameUrl' => $gameProvider['game_url'],
                    ], 200);
                }else{
                    return response()->json(['error' => ''], 400);
                }
            }else{
                return response()->json(['action' => 'login'], 400);
            }
        }

        return response()->json(['error' => ''], 400);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
