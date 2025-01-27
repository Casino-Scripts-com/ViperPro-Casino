<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'games';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'game_server_url',
        'game_id',
        'game_name',
        'game_code',
        'game_type',
        'description',
        'cover',
        'status',
        'technology',
        'has_lobby',
        'is_mobile',
        'has_freespins',
        'has_tables',
        'only_demo',
        'rtp',
        'distribution',
        'views',
        'is_featured',
        'show_home'
    ];

    protected $appends = ['hasFavorite', 'totalFavorites', 'hasLike', 'totalLikes', 'dateHumanReadable', 'createdAt' ];

    /**
     * Total Favorites
     * @return int
     */
    public function getTotalFavoritesAttribute()
    {
        return $this->favorites()->count();
    }

    /**
     * Total Favorites
     * @return int
     */
    public function getTotalLikesAttribute()
    {
        return $this->likes()->count();
    }

    /**
     * Has Favorite
     * @return int
     */
    public function getHasLikeAttribute()
    {
        if(auth('api')->check() && !empty($this->attributes['id'])) {
            $like = GameLike::whereUserId(auth('api')->id())->where('game_id', $this->attributes['id'])->first();
            if(!empty($like)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Has Favorite
     * @return int
     */
    public function getHasFavoriteAttribute()
    {
       if(auth('api')->check() && !empty($this->attributes['id'])) {
           $favorite = GameFavorite::whereUserId(auth('api')->id())->where('game_id', $this->attributes['id'])->first();
           if(!empty($favorite)) {
               return true;
           }
           return false;
       }
       return false;
    }

    /**
     * @return BelongsTo
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(GameFavorite::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(GameLike::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(GameReview::class);
    }


    /**
     * @return mixed
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }

    /**
     * @return mixed
     */
    public function getDateHumanReadableAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
