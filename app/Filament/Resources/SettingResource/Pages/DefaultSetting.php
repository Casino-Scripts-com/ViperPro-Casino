<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use App\Models\User;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Contracts\Support\Htmlable;

class DefaultSetting extends Page implements HasForms
{
    use HasPageSidebar, InteractsWithForms;

    protected static string $resource = SettingResource::class;

    protected static string $view = 'filament.resources.setting-resource.pages.default-setting';

    /**
     * @dev @victormsalatiel
     * @param Model $record
     * @return bool
     */
    public static function canView(Model $record): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * @return string|Htmlable
     */
    public function getTitle(): string | Htmlable
    {
        return __('Padrão');
    }

    public Setting $record;
    public ?array $data = [];

    /**
     * @dev victormsalatiel - Meu instagram
     * @return void
     */
    public function mount(): void
    {
        $setting = Setting::first();
        $this->record = $setting;
        $this->form->fill($setting->toArray());
    }

    /**
     * @return void
     */
    public function save()
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

            $setting = Setting::find($this->record->id);

            $favicon   = $this->data['software_favicon'];
            $logoWhite = $this->data['software_logo_white'];
            $logoBlack = $this->data['software_logo_black'];
            $softwareBackground = $this->data['software_background'];

            if (is_array($softwareBackground) || is_object($softwareBackground)) {
                if(!empty($softwareBackground)) {
                    $this->data['software_background'] = $this->uploadFile($softwareBackground);

                    if(is_array($this->data['software_background'])) {
                        unset($this->data['software_background']);
                    }
                }
            }

            if (is_array($favicon) || is_object($favicon)) {
                if(!empty($favicon)) {
                    $this->data['software_favicon'] = $this->uploadFile($favicon);

                    if(is_array($this->data['software_favicon'])) {
                        unset($this->data['software_favicon']);
                    }
                }
            }

            if (is_array($logoWhite) || is_object($logoWhite)) {
                if(!empty($logoWhite)) {
                    $this->data['software_logo_white'] = $this->uploadFile($logoWhite);

                    if(is_array($this->data['software_logo_white'])) {
                        unset($this->data['software_logo_white']);
                    }
                }
            }

            if (is_array($logoBlack) || is_object($logoBlack)) {
                if(!empty($logoBlack)) {
                    $this->data['software_logo_black'] = $this->uploadFile($logoBlack);

                    if(is_array($this->data['software_logo_black'])) {
                        unset($this->data['software_logo_black']);
                    }
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

                redirect(route('filament.admin.resources.settings.index'));

            }
        } catch (Halt $exception) {
            return;
        }
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
                Section::make('Ajuste Visual')
                    ->description('Formulário ajustar o visual da plataforma')
                    ->schema([
                        Group::make()->schema([
                            TextInput::make('software_name')
                                ->label('Nome')
                                ->placeholder('Digite o nome do site')
                                ->required()
                                ->maxLength(191),
                            TextInput::make('software_description')
                                ->placeholder('Digite a descrição do site')
                                ->label('Descrição')
                                ->maxLength(191),
                        ])->columns(2),
                        Group::make()->schema([
                            FileUpload::make('software_favicon')
                                ->label('Favicon')
                                ->placeholder('Carregue um favicon')
                                ->image(),
                            Group::make()->schema([
                                FileUpload::make('software_logo_white')
                                    ->label('Logo Branca')
                                    ->placeholder('Carregue uma logo branca')
                                    ->image()
                                    ->columnSpanFull(),
                                FileUpload::make('software_logo_black')
                                    ->label('Logo Escura')
                                    ->placeholder('Carregue uma logo escura')
                                    ->image()
                                    ->columnSpanFull(),
//                                FileUpload::make('software_background')
//                                    ->label('Background')
//                                    ->placeholder('Carregue um background')
//                                    ->image()
//                                    ->columnSpanFull(),
                            ])
                        ])->columns(2),
                    ])
            ])
            ->statePath('data') ;
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
}
