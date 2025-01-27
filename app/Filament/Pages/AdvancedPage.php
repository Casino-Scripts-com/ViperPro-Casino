<?php

namespace App\Filament\Pages;

use App\Models\CustomLayout;
use App\Traits\Providers\WorldSlotTrait;
use Filament\Forms\Components\ColorPicker;
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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\Actions\Action;
use Creagia\FilamentCodeField\CodeField;
use Livewire\WithFileUploads;

class AdvancedPage extends Page implements HasForms
{
    use InteractsWithForms, WorldSlotTrait, WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.advanced-page';

    protected static ?string $navigationLabel = 'Opções Avançada';

    protected static ?string $modelLabel = 'Opções Avançada';

    protected static ?string $title = 'Opções Avançada';

    protected static ?string $slug = 'advanced-options';

    public ?array $data = [];
    public $output;

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * @return void
     */
    public function mount(): void
    {

    }

    /**
     * @param $type
     * @return void
     */
    public function loadProvider($type)
    {
        self::getProviderWorldslot($type);
        Notification::make()
            ->title('Sucesso')
            ->body('Provedores Carregados com sucesso')
            ->success()
            ->send();
    }

    /**
     * @return void
     */
    public function loadGames()
    {
        self::getGamesWorldslot();
        Notification::make()
            ->title('Sucesso')
            ->body('Jogos Carregados com sucesso')
            ->success()
            ->send();
    }

    /**
     * @return void
     */
    public function upload()
    {

    }

    /**
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {

        return $data;
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Atualização')
                    ->description('Carregue aqui seu arquivo de atualização no formato zip')
                    ->schema([
                        FileUpload::make('update')
                    ])

            ])
            ->statePath('data');
    }

    /**
     * @return void
     */
    public function submit(): void
    {
        try {
            foreach ($this->data['update'] as $file) {
                $extension  = $file->extension();
                if($extension === "zip") {
                    $filePath = $file->storeAs('updates', $file->getClientOriginalName());

                    $zip = new \ZipArchive;
                    $zipPath = storage_path("app/{$filePath}"); // Caminho completo para o arquivo zip
                    $extractPath = base_path(); // Altere para o diretório desejado

                    if ($zip->open($zipPath) === true) {
                        $zip->extractTo($extractPath);
                        $zip->close();

                        // Exclua o arquivo zip após a extração
                        \Storage::delete($filePath);
                    }
                }

                Notification::make()
                    ->title('Sucesso')
                    ->body('Atualização feita com sucesso')
                    ->success()
                    ->send();
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
     * @return void
     */
    public function runMigrate()
    {
        // Executar o comando Artisan para rodar as migrations
        Artisan::call('migrate');

        // Você também pode adicionar a opção '--seed' para rodar os seeders, se necessário
        // Artisan::call('migrate --seed');

        // Obter a saída do comando, se necessário
        $this->output = Artisan::output();
        Notification::make()
            ->title('Sucesso')
            ->body('Migrações carregadas com sucesso')
            ->success()
            ->send();
    }

    /**
     * @return void
     */
    public function runMigrateWithSeed()
    {
        // Executar o comando Artisan para rodar as migrations
        Artisan::call('migrate --seed');

        // Você também pode adicionar a opção '--seed' para rodar os seeders, se necessário
        // Artisan::call('migrate --seed');

        // Obter a saída do comando, se necessário
        $this->output = Artisan::output();
        Notification::make()
            ->title('Sucesso')
            ->body('Migrações carregadas com sucesso')
            ->success()
            ->send();
    }
}
