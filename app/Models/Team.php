<?php

namespace App\Models;

use App\TeamTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'team_type',
    ];

    protected function casts(): array
    {
        return [
            'team_type' => TeamTypeEnum::class,
        ];
    }
}
