<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditGame extends EditRecord
{
    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('players')
                ->color('gray')
                ->url(fn ($record) => '/admin/games/'.$record->id.'/teams'),

            Actions\DeleteAction::make(),
        ];
    }
}
