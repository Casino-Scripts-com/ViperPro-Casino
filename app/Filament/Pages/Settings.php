<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Filament\Pages;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\Actions\Action;


class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.settings';

    protected static ?string $navigationLabel = 'Configurações';

    protected static ?string $modelLabel = 'Configurações';

    protected static ?string $title = 'Configurações';

    protected static ?string $slug = 'configuracoes';

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public ?array $data = [];
    public Setting $setting;

    /**
     * @dev victormsalatiel - Meu instagram
     * @return void
     */
    public function mount(): void
    {
        $this->setting = Setting::first();
        $this->form->fill($this->setting->toArray());
    }

    /**
     * @dev victormsalatiel - Meu instagram
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detalhes do Site')
                    ->schema([
                        TextInput::make('software_name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(191),
                        TextInput::make('software_description')
                            ->label('Descrição')
                            ->maxLength(191),
                    ])->columns(2),

                Section::make('Logos')
                    ->schema([
                        FileUpload::make('software_favicon')
                            ->label('Favicon')
                            ->placeholder('Carregue um favicon')
                            ->image(),
                        FileUpload::make('software_logo_white')
                            ->label('Logo Branca')
                            ->placeholder('Carregue uma logo branca')
                            ->image(),
                        FileUpload::make('software_logo_black')
                            ->label('Logo Escura')
                            ->placeholder('Carregue uma logo escura')
                            ->image(),
                    ])->columns(3),

                Section::make('Background')
                    ->schema([
                        FileUpload::make('software_background')
                            ->label('Background')
                            ->placeholder('Carregue um background')
                            ->image()
                        ->columnSpanFull(),
                    ]),

                Section::make('Depositos e Saques')
                    ->schema([
                        TextInput::make('min_deposit')
                            ->label('Min Deposito')
                            ->numeric()
                            ->maxLength(191),
                        TextInput::make('max_deposit')
                            ->label('Max Deposito')
                            ->numeric()
                            ->maxLength(191),
                        TextInput::make('min_withdrawal')
                            ->label('Min Saque')
                            ->numeric()
                            ->maxLength(191),
                        TextInput::make('max_withdrawal')
                            ->label('Max Saque')
                            ->numeric()
                            ->maxLength(191),
                        TextInput::make('rollover')
                            ->label('Rollover')
                            ->numeric()
                            ->maxLength(191),
                    ])->columns(5),

                Section::make('Futebol')
                    ->description('Configurações de Futebol')
                    ->schema([
                        TextInput::make('soccer_percentage')
                            ->label('Futebol Comissão (%)')
                            ->numeric()
                            ->suffix('%')
                            ->maxLength(191),

                        Toggle::make('turn_on_football')
                            ->inline(false)
                            ->label('Ativar Futebol'),
                    ])->columns(2),

                Section::make('Taxas')
                    ->description('Configurações de Ganhos da Plataforma')
                    ->schema([
                        TextInput::make('revshare_percentage')
                            ->label('RevShare (%)')
                            ->numeric()
                            ->suffix('%')
                            ->maxLength(191),
                        Toggle::make('revshare_reverse')
                            ->inline(false)
                            ->label('Ativar RevShare Negativo')
                            ->helperText('Esta opção possibilita que o afiliado acumule saldos negativos decorrentes das perdas geradas pelos seus indicados.')
                        ,
                        TextInput::make('ngr_percent')
                            ->label('NGR (%)')
                            ->numeric()
                            ->suffix('%')
                            ->maxLength(191),
                    ])->columns(3),
                Section::make('Dados Gerais')
                    ->schema([
                        TextInput::make('initial_bonus')
                            ->label('Bônus Inicial (%)')
                            ->numeric()
                            ->suffix('%')
                            ->maxLength(191),
                        TextInput::make('currency_code')
                            ->label('Moeda')
                            ->maxLength(191),
                        Select::make('decimal_format')->options([
                            'dot' => 'Dot',
                        ]),
                        Select::make('currency_position')->options([
                            'left' => 'Left',
                            'right' => 'Right',
                        ]),
                        Toggle::make('disable_spin')
                            ->label('Disable Spin')
                        ,
                        Toggle::make('suitpay_is_enable')
                            ->label('SuitPay Ativo')
                        ,
                        Toggle::make('stripe_is_enable')
                            ->label('Stripe Ativo')
                        ,
                    ])->columns(4),
            ])
            ->statePath('data');
    }

    /**
     * @dev victormsalatiel - Meu instagram
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }

    /**
     *
     * @dev victormsalatiel - Meu instagram
     * @return array
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('Submit'))
                ->action(fn () => $this->submit())
                ->submit('submit')
            //->url(route('filament.admin.pages.dashboard'))
            ,
        ];
    }

    /**
     * @dev victormsalatiel - Meu instagram
     * @param $array
     * @return mixed|void
     */
    private function uploadFile($array)
    {
        if(!empty($array) && is_array($array) || !empty($array) && is_object($array)) {
            foreach ($array as $k => $temporaryFile) {
                if ($temporaryFile instanceof TemporaryUploadedFile) {
                    $path = \Helper::upload($temporaryFile);
                    if($path) {
                        return $path['path'];
                    }
                }else{
                    return $temporaryFile;
                }
            }
        }
    }


    /**
     * @dev victormsalatiel - Meu instagram
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


            $setting = Setting::first();

            if(!empty($setting)) {

                $favicon   = $this->data['software_favicon'];
                $logoWhite = $this->data['software_logo_white'];
                $logoBlack = $this->data['software_logo_black'];
                $softwareBackground = $this->data['software_background'];

                if (is_array($softwareBackground) || is_object($softwareBackground)) {
                    if(!empty($softwareBackground)) {
                        $this->data['software_background'] = $this->uploadFile($softwareBackground);
                    }
                }

                if (is_array($favicon) || is_object($favicon)) {
                    if(!empty($favicon)) {
                        $this->data['software_favicon'] = $this->uploadFile($favicon);
                    }
                }

                if (is_array($logoWhite) || is_object($logoWhite)) {
                    if(!empty($logoWhite)) {
                        $this->data['software_logo_white'] = $this->uploadFile($logoWhite);
                    }
                }

                if (is_array($logoBlack) || is_object($logoBlack)) {
                    if(!empty($logoBlack)) {
                        $this->data['software_logo_black'] = $this->uploadFile($logoBlack);
                    }
                }

                $envs = DotenvEditor::load(base_path('.env'));

                $envs->setKeys([
                    'APP_NAME' => $this->data['software_name'],
                ]);

                $envs->save();

                if($setting->update($this->data)) {

                    Cache::put('setting', $setting);

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


}
