<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Widgets\StatsUserDetailOverview;
use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Component;

class DetailUser extends Page
{

    protected static ?string $title = 'Detalhes';

    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.detail-user';

    public User $record;
    public ?array $data = [];

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * @return int|string|array
     */
    public function getColumns(): int | string | array
    {
        return 2;
    }

    /**
     * @return array
     */
    public function getVisibleWidgets(): array
    {
        return $this->filterVisibleWidgets($this->getWidgets());
    }

    /**
     * @return Component
     */
    protected function getTemplateSection(): Component
    {
        return Section::make()
            ->schema([
                ViewField::make('preview.default')->view('filament.resources.user-resource.pages.detail-info'),
            ]);
    }

    /**
     * @return string[]
     */
    public function getWidgets(): array
    {
        return array(
            StatsUserDetailOverview::make([
                'record' => $this->record,
            ]),
            UserResource\Widgets\MyBetsTableWidget::make([
                'record' => $this->record,
            ]),
            UserResource\Widgets\IndicationsTableWidget::make([
                'record' => $this->record,
            ]),
        );
    }

    /**
     *
     * @dev victormsalatiel - Meu instagram
     * @return array
     */
    protected function getFormActions(): array
    {
        return [

        ];
    }

    /**
     * @return array|\Filament\Widgets\WidgetConfiguration[]|string[]
     */
    protected function getFooterWidgets(): array
    {
        return [

        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return [
            'md' => 4,
            'xl' => 5,
        ];
    }
}
