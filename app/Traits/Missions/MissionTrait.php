<?php

namespace App\Traits\Missions;

use App\Models\Mission;
use App\Models\MissionUser;
use App\Models\User;
use App\Models\Wallet;

trait MissionTrait
{
    /**
     * Verificar Missões
     *
     * @param $userId
     * @param $game
     * @param $provider
     * @return true|void
     */
    protected static function CheckMissionExist($userId, $game, $provider)
    {
        $user = User::find($userId);
        if(!empty($user)) {

            // verificar se tem desatio para este usuário
            $missions = MissionUser::with(['mission'])->where('user_id', $userId)->where('status', 0)->get();
            if(count($missions) > 0) {
                foreach($missions as $mission) {
                    if(!empty($mission->mission->challenge_provider)) {
                        if($mission->mission->challenge_total > $mission->rounds) {
                            /// verificar se existe desafio em provedor
                            switch ($provider) {
                                case 'fivers':
                                    /// verifica se é o mesmo provider do jogo
                                    if($mission->mission->challenge_provider == $game->game_provider_id) {
                                        $mission->increment('rounds', 1);
                                        self::checkFinishMission($mission->mission->id, $mission->id);
                                        return true;
                                    }
                            }
                        }

                    } elseif(!empty($mission->mission->challenge_gameid) && $mission->mission->challenge_total > $mission->rounds) {
                        /// verificar se existe desafio em gameid
                        switch ($provider) {
                            case 'fivers':
                                /// verifica se é o mesmo provider do jogo
                                if($mission->mission->challenge_gameid == $game->game_code) {
                                    $mission->increment('rounds', 1);
                                    self::checkFinishMission($mission->mission->id, $mission->id);
                                    return true;
                                }
                        }

                    } elseif(!empty($mission->mission->challenge_type) && $mission->mission->challenge_type == 'game' && $mission->mission->challenge_total > $mission->rounds) {
                        /// desafio só para jogaar um jogo
                        switch ($provider) {
                            case 'fivers':
                                /// verifica se é o mesmo provider do jogo
                                $mission->increment('rounds', 1);
                                self::checkFinishMission($mission->mission->id, $mission->id);
                                return true;
                        }

                    }
                }
            }
        }
    }

    /**
     * Finish Mission
     * Esse metodo verifica se finalizou as missões
     *
     * @param $missionId
     * @param $missionUserId
     * @return void
     */
    private static function checkFinishMission($missionId, $missionUserId)
    {
        $checkMissionUser = MissionUser::find($missionUserId);
        $checkMission = Mission::find($missionId);

        if($checkMissionUser->rounds == $checkMission->challenge_total) {
            $rewards = $checkMission->challenge_bonus;
            $checkMissionUser->increment('rewards', $rewards); // coloca o valor do premio
            $checkMissionUser->update(['status' => 1]); /// fecha

            ///
            $wallet = Wallet::where('user_id', $checkMissionUser->user_id)->first();
            $wallet->increment('balance_bonus', $rewards); /// adiciona o premio no bonus
        }
    }



}
