<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Helpers\Core as Helper;

class Order extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';
    protected $appends = ['dateHumanReadable', 'createdAt'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'transaction_id',
        'game',
        'game_uuid',
        'type',
        'type_money',
        'amount',
        'providers',
        'refunded',
        'round_id',
        'status'
    ];

    /**
     * Get the user's first name.
     */
    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => Helper::getTypeOrder($value),
        );
    }

    /**
     * Get the user's first name.
     */
    // protected function typeMoney(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (?string $value) => Helper::getTypeTransactionOrder($value),
    //     );
    // }

    /**
     * Get the user's first name.
     */
    protected function providers(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => Helper::getDistribution()[$value] ?? 'Sem Provedor',
        );
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
