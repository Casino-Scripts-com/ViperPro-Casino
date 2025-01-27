<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MissionResource\Pages;
use App\Filament\Resources\MissionResource\RelationManagers;
use App\Models\Currency;
use App\Models\GameProvider;
use App\Models\Mission;
use App\Models\Provider;
use App\Models\Wallet;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MissionResource extends Resource
{
    protected static ?string $model = Mission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationLabel = 'Missões';

    protected static ?string $modelLabel = 'Missões';

    protected static ?string $slug = 'centro-missoes';

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                ->schema([
                    Forms\Components\TextInput::make('challenge_name')
                        ->required()
                        ->label('Nome da Missão')
                        ->placeholder('Digite o nome da missão')
                        ->columnSpanFull()
                        ->maxLength(191),
                    RichEditor::make('challenge_description')
                        ->label('Descrição')
                        ->columnSpanFull()
                        ->placeholder('Digite a descrição da missão'),

                    RichEditor::make('challenge_rules')
                        ->label('Regras')
                        ->columnSpanFull()
                        ->placeholder('Digite as regras da missão'),
                    Select::make('challenge_type')
                        ->default('game')
                        ->label('Tipo da Missão')
                        ->options([
                            'game' => 'Jogo',
                            'wallet' => 'Carteira',
                            'deposit' => 'Deposito',
                            'affiliate' => 'Afiliado',
                        ]),
                    Forms\Components\TextInput::make('challenge_link')
                        ->label('Link da Missão')
                        ->maxLength(191),
                    Forms\Components\DateTimePicker::make('challenge_start_date')
                        ->label('Data inicial da Missão')
                        ->required(),
                    Forms\Components\DateTimePicker::make('challenge_end_date')
                        ->label('Data final da Missão')
                        ->required(),
                    Forms\Components\TextInput::make('challenge_bonus')
                        ->label('Valor do Bônus')
                        ->required()
                        ->numeric()
                        ->default(0.00),
                    Forms\Components\TextInput::make('challenge_total')
                        ->label('Total de Missões')
                        ->required()
                        ->numeric()
                        ->default(1),
                    Select::make('challenge_currency')
                        ->label('Moeda Padrão')
                        ->required()
                        ->options(Currency::all()->pluck('code', 'id'))
                        ->reactive()
                        ->default(Wallet::where('active', 1)->first()->currency)
                        ->searchable(),
                    Select::make('challenge_provider')
                        ->label('Provedor')
                        ->options(Provider::all()->pluck('name', 'id'))
                        ->reactive()
                        ->searchable(),
                    Forms\Components\TextInput::make('challenge_gameid')
                        ->label('Game ID')
                        ->placeholder('Digite o id do jogo, você consegue o id na listagem dos jogos')
                        ->columnSpanFull()
                        ->maxLength(191),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('challenge_name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('challenge_type')
                    ->label('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('challenge_link')
                    ->label('Link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('challenge_start_date')
                    ->label('Data Inicial')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('challenge_end_date')
                    ->label('Data Final')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('challenge_bonus')
                    ->label('Valor do Prêmio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('challenge_total')
                    ->label('Total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('challenge_currency')
                    ->label('Moeda')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    /**
     * @return string[]
     */
    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMissions::route('/'),
            'create' => Pages\CreateMission::route('/create'),
            'edit' => Pages\EditMission::route('/{record}/edit'),
        ];
    }
}
