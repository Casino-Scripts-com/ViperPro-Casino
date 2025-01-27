<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mission extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'missions';
    protected $appends = ['dateHumanReadable', 'createdAt', 'haveMission', 'myRounds', 'myRoundsPercentage'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'challenge_name',
        'challenge_description',
        'challenge_rules',
        'challenge_type',
        'challenge_link',
        'challenge_start_date',
        'challenge_end_date',
        'challenge_bonus',
        'challenge_total',
        'influencer_winLength',
        'influencer_loseLength',
        'challenge_currency',
        'challenge_provider', /// caso seja um provedor especifico
        'challenge_gameid', /// caso seja um jogo especifico
    ];


    /**
     * Have Mission
     *
     * @return bool
     */
    public function getMyRoundsAttribute()
    {
        if(auth('api')->check()) {
            $haveMission = MissionUser::where('user_id', auth('api')->id())
                ->where('mission_id', $this->id)->first();

            $challenge_total = $this->challenge_total;
            if(!empty($haveMission)) {
                $rounds = $haveMission->rounds;
                return $rounds.'/'.$challenge_total;
            }

            return '0/'.$challenge_total;
        }
        return null;
    }

    /**
     * Have Mission
     *
     * @return bool
     */
    public function getMyRoundsPercentageAttribute()
    {
        if(auth('api')->check()) {
            $haveMission = MissionUser::where('user_id', auth('api')->id())
                ->where('mission_id', $this->id)->first();

            if(!empty($haveMission)) {
                $rounds = $haveMission->rounds;
                $challenge_total = $this->challenge_total;

                if ($challenge_total > 0) {
                    $percentage = ($rounds / $challenge_total) * 100;
                    return round($percentage, 2); // Round to 2 decimal places
                } else {
                    return 0; // Avoid division by zero
                }
                return 0;
            }
            return 0;
        }
        return null;
    }

    /**
     * Have Mission
     *
     * @return bool
     */
    public function getHaveMissionAttribute()
    {
        if(auth('api')->check()) {
            $haveMission = MissionUser::where('user_id', auth('api')->id())
                ->where('mission_id', $this->id)->first();

            if(!empty($haveMission)) {
                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at']);
    }

    /**
     * @return mixed
     */
    public function getDateHumanReadableAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    /**
     * Sport Events
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(MissionUser::class);
    }
}
