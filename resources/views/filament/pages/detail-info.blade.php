<x-filament-panels::page>

    <form wire:submit="submit">
        {{ $this->form }}

        <br>
        <x-filament-panels::form.actions
            :actions="$this->getFormActions()"
        />
    </form>

    @if (method_exists($this, 'filtersForm'))
        <x-filament::section>
            {{ $this->filtersForm }}
        </x-filament::section>
    @endif

    <x-filament-widgets::widgets
        :columns="$this->getColumns()"
        :data="
            [
                ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
                ...$this->getWidgetData(),
            ]
        "
        :widgets="$this->getVisibleWidgets()"
    />

</x-filament-panels::page>
