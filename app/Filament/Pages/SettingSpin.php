<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\SpinConfigs;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class SettingSpin extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.setting-spin';

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * @return string|Htmlable
     */
    public function getTitle(): string | Htmlable
    {
        return __('Setting Spin');
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return __('Setting Spin');
    }

    public ?array $data = [];
    public SpinConfigs $setting;

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->setting = SpinConfigs::first();
        $this->form->fill($this->setting->toArray());
    }

    /**
     * @return array
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('Submit'))
                ->action(fn () => $this->submit())
                ->submit('submit')
            ,
        ];
    }

    /**
     * @return void
     */
    public function submit(): void
    {
        try {
            if(env('APP_DEMO')) {
                Notification::make()
                    ->title('Atenção')
                    ->body('Você não pode realizar está alteração na versão demo')
                    ->danger()
                    ->send();
                return;
            }

            $setting = SpinConfigs::first();
            if(!empty($setting)) {

                $updatedData = [];
                foreach($this->data['prizesArray'] as $k => $v) {
                    $v['value'] = floatval($v['value']);
                    array_push($updatedData, $v);
                }

                if($setting->update(['prizes' => $updatedData])) {
                    Notification::make()
                        ->title('Dados alterados')
                        ->body('Dados alterados com sucesso!')
                        ->success()
                        ->send();

                    redirect(route('filament.admin.pages.dashboard-admin'));
                }
            }
        } catch (Halt $exception) {
            Notification::make()
                ->title('Erro ao alterar dados!')
                ->body('Erro ao alterar dados!')
                ->danger()
                ->send();
        }
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ajustes do Spin')
                    ->schema([
                        Repeater::make('prizesArray')
                            ->schema([
                                TextInput::make('currency')
                                    ->label('Moeda')
                                    ->required(),
                                TextInput::make('value')
                                    ->label('Valor')
                                    ->numeric()
                                    ->required(),
                            ])
//                            ->itemLabel(function (array $state): ?string {
//
//                                dd($state);
//
//                            })
                    ]),

            ])
            ->statePath('data');
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
     * @return string[]
     */
    public function getWidgets(): array
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
