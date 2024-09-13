<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Models\Game;
use App\TeamTypeEnum;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),

                Group::make()
                    ->hidden(fn (Get $get) => is_null($get('id')))
                    ->schema([
                        // Select::make('teams')
                        //     ->relationship(
                        //         name: 'teams',
                        //         titleAttribute: 'name',
                        //         // modifyQueryUsing: fn (Builder $query, $record) => $query->where('game_id', '=', $record->id)
                        //     )
                        //     ->createOptionForm([
                        //         TextInput::make('name')
                        //             ->required(),
                        //         Select::make('team_type')
                        //             ->required()
                        //             ->options(collect(TeamTypeEnum::cases())->pluck('name', 'value')),
                        //     ]),

                        Select::make('players')
                            ->multiple()
                            ->relationship(name: 'players', titleAttribute: 'nickname')
                            ->pivotData(fn (Game $record) => [
                                // GET team!
                                'team_id' => $record->teams()->first()->id,
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('playerCount')
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
            'teams' => Pages\TeamsGame::route('/{record}/teams'),
        ];
    }
}
