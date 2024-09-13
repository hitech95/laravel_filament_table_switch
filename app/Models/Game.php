<?php

namespace App\Models;

use App\TeamTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //
    protected function getPlayerCountAttribute(): int
    {
        return $this->players()->count();
    }

    public function getRedTeam(): HasOne
    {
        return $this->teams()->having('team_type', '=', TeamTypeEnum::RED);
    }

    public function getBlueTeam(): HasOne
    {
        return $this->teams()->having('team_type', '=', TeamTypeEnum::BLUE);
    }

    //
    public function players(): BelongsToMany
    {
        // return $this->hasManyThrough(Player::class, PlayerTeam::class, 'game_id', 'id', 'player_id');

        return $this->belongsToMany(Player::class, 'player_teams', 'game_id', 'player_id')
            ->withTimestamps(); //->using(PlayerTeam::class);
    }

    public function teams(): HasMany
    {
        return $this->HasMany(Team::class);

    }
}
