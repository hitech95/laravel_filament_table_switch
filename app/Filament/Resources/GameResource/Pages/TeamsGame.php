<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use App\Livewire\Game as GameComponents;
use App\TeamTypeEnum;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Livewire;
use Filament\Forms\Form;
use Filament\Resources\Pages\Concerns;
use Filament\Resources\Pages\Page;

class TeamsGame extends Page
{
    use Concerns\InteractsWithRecord {
        configureAction as configureActionRecord;
    }

    protected static string $resource = GameResource::class;

    protected static string $view = 'filament.pages.game.team-list';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function getTitle(): string
    {
        return 'Player list';
    }

    public function getHeading(): string
    {
        return $this->getTitle().' - '.$this->getRecordTitle();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Livewire::make(GameComponents\TeamTable::class, fn (Page $livewire, Component $component) => [
                    'title' => 'Red Team',
                    'record' => $livewire->getRecord(),
                    'filter' => TeamTypeEnum::RED,
                    'move' => TeamTypeEnum::BLUE,
                ])->key('bids-approved'),

                Livewire::make(GameComponents\TeamTable::class, fn (Page $livewire, Component $component) => [
                    'title' => 'Blue Team',
                    'record' => $livewire->getRecord(),
                    'filter' => TeamTypeEnum::BLUE,
                    'move' => TeamTypeEnum::RED,
                ])->key('bids-rejected'),
            ]);
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->authorizeAccess();
    }

    protected function authorizeAccess(): void
    {
        abort_unless(static::getResource()::canEdit($this->getRecord()), 403);
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->operation('edit')
                    ->model($this->getRecord())
                    ->statePath('data')
                    ->columns($this->hasInlineLabels() ? 1 : 2)
                    ->inlineLabel($this->hasInlineLabels()),
            ),
        ];
    }
}
