<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wallets';
    protected $appends = ['total_balance'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'currency',
        'symbol',
        'balance',
        'balance_withdrawal',
        'balance_deposit_rollover',
        'balance_bonus',
        'balance_bonus_rollover',
        'balance_cryptocurrency',
        'balance_demo',
        'refer_rewards',
        'total_bet',
        'total_won',
        'total_lose',
        'last_won',
        'last_lose',
        'hide_balance',
        'active',
        'vip_level',
        'vip_points',
    ];

    /**
     * Cover
     * @return int
     */
    public function getTotalBalanceAttribute()
    {
        return ($this->attributes['balance'] + $this->attributes['balance_bonus'] + $this->attributes['balance_withdrawal']);
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
