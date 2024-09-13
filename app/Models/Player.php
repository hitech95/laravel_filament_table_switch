<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['nickname', 'user_id'];

    //
    protected function getGamesCountAttribute(): int
    {
        return $this->games()->count();
    }

    //
    public function games(): BelongsToMany
    {
        // return $this->hasManyThrough(Player::class, PlayerTeam::class, 'game_id', 'id', 'player_id');

        return $this->belongsToMany(Game::class, 'player_teams', 'player_id', 'game_id')
            ->withTimestamps(); //->using(PlayerTeam::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)->using(PlayerTeam::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
