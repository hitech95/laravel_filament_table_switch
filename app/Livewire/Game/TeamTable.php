<?php

namespace App\Livewire\Game;

use App\Models\Game;
use App\Models\Player;
use App\Models\PlayerTeam;
use App\TeamTypeEnum;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class TeamTable extends Component implements HasForms, HasTable
{
    use EvaluatesClosures;
    use InteractsWithForms;
    use InteractsWithTable;

    // View Data
    public ?Game $record = null;

    // View configuration
    public ?string $title = null;

    public TeamTypeEnum $filter = TeamTypeEnum::NONE;

    public TeamTypeEnum $move = TeamTypeEnum::NONE;

    // Override those to create custom tables
    protected function getHeaderActions()
    {
        return [];
    }

    // Override those to create custom tables
    protected function getActions()
    {
        return [
            Action::make('move')
                ->label('Switch')
                ->requiresConfirmation()
                ->modalHeading('Switch Team')
                ->successNotificationTitle('Switch Successful')
                ->failureNotificationTitle('Something went wrong')
                ->action(function (Action $action, Player $record) {

                    $team = $this->getRecord()->teams()->where('team_type', '=', $this->move)->first();

                    $done = PlayerTeam::where([
                        'game_id' => $this->getRecord()->id,
                        'player_id' => $record->id,
                    ])->update([
                        'team_id' => $team->id,
                    ]);

                    if ($done) {
                        $action->success();

                        return;
                    }
                    $action->failure();
                }),
        ];
    }

    protected function getColumns()
    {
        return [
            Columns\TextColumn::make('id'),
            Columns\TextColumn::make('nickname'),
            Columns\TextColumn::make('user.email'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => $this->getQuery())
            ->heading(fn () => $this->title)
            ->headerActions($this->getHeaderActions())
            ->actions($this->getActions())
            ->columns($this->getColumns());
    }

    protected function getRecord(): Model
    {
        return $this->record;
    }

    protected function getQuery()
    {
        $team = $this->getRecord()->teams()->where('team_type', '=', $this->filter)->first();

        return $this->getDataQueryBuilder($team->id);
    }

    protected function getDataQueryBuilder(mixed $teamID)
    {
        return $this->record->players()
            ->wherePivot('team_id', '=', $teamID)
            ->with([
                'user',
            ]);
    }

    public function render(): View
    {
        return view('livewire.game.team-table');
    }
}
