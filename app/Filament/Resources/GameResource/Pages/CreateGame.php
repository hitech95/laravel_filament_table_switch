<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use App\TeamTypeEnum;
use Filament\Resources\Pages\CreateRecord;

class CreateGame extends CreateRecord
{
    protected static string $resource = GameResource::class;

    public function create(bool $another = false): void
    {
        parent::create($another);

        $record = $this->getRecord();

        $record->teams()->create([
            'name' => TeamTypeEnum::RED->name,
            'team_type' => TeamTypeEnum::RED,
        ]);
        $record->teams()->create([
            'name' => TeamTypeEnum::BLUE->name,
            'team_type' => TeamTypeEnum::BLUE,
        ]);
    }
}
