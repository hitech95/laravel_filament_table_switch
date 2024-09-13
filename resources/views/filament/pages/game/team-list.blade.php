<x-filament::page @class([
    'fi-resource-view-record-page',
    'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
    'fi-resource-record-' . $record->getKey(),
])>

    <div wire:key="{{ $this->getId() }}.forms.{{ $this->getFormStatePath() }}">
        {{ $this->form }}
    </div>

</x-filament::page>
