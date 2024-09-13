<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PlayerTeam extends Pivot
{
    protected $table = 'player_teams';

    //
    public function player()
    {
        return $this->belongsTo(Player::class, 'id', 'player_id');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'id', 'game_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'id', 'team_id');
    }
}
