<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers;
use App\Models\Category;
use App\Models\Game;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Todos os Jogos';

    protected static ?string $modelLabel = 'Todos os Jogos';

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
                    Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Select::make('provider_id')
                            ->label('Provedor')
                            ->placeholder('Selecione um provedor')
                            ->relationship(name: 'provider', titleAttribute: 'name')
                            ->options(
                                fn($get) => Provider::query()
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->columnSpanFull()
                        ,
                        Forms\Components\Select::make('categories')
                            ->label('Categoria')
                            ->placeholder('Selecione categorias para seu jogo')
                            ->multiple()
                            ->relationship('categories', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->columnSpanFull()
                        ,
                        Forms\Components\TextInput::make('game_server_url')
                            ->label('Server URL')
                            ->placeholder('Se existir add o server URL')
                            ->maxLength(191),
                        Forms\Components\TextInput::make('game_name')
                            ->label('Nome do Jogo')
                            ->placeholder('Digite o nome do jogo')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\Textarea::make('description')
                            ->label('Descrição')
                            ->placeholder('Digite a descrição do jogo')
                            ->autosize(),
                        Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\TextInput::make('game_id')
                                ->label('ID do Jogo')
                                ->placeholder('Digite o ID do jogo')
                                ->required()
                                ->maxLength(191),
                            Forms\Components\TextInput::make('game_code')
                                ->placeholder('Digite o código do jogo')
                                ->label('Código do Jogo')
                                ->required()
                                ->maxLength(191),
                            Forms\Components\TextInput::make('game_type')
                                ->placeholder('Digite o tipo de jogo')
                                ->label('Tipo do Jogo')
                                ->required()
                                ->maxLength(191),
                        ])->columns(3),
                        Forms\Components\FileUpload::make('cover')
                            ->label('Capa')
                            ->placeholder('Carregue a capa do jogo')
                            ->image()
                            ->columnSpanFull()
                            ->helperText('Tamanho recomendado para a capa é de 322x322')
                            ->required(),
                    ]),
                    Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TextInput::make('technology')
                            ->label('Tecnologia')
                            ->placeholder('Digite a Tecnologia do jogo, exemplo: html, java, construct 3')
                            ->maxLength(191),
                        Forms\Components\TextInput::make('rtp')
                            ->label('RTP')
                            ->placeholder('Digite o RTP do jogo')
                            ->required()
                            ->numeric()
                            ->default(90),
                        Forms\Components\Select::make('distribution')
                            ->label('Distribuição')
                            ->placeholder('Selecione a distribuição')
                            ->required()
                            ->options(\Helper::getDistribution()),
                        Forms\Components\TextInput::make('views')
                            ->label('Visualizações')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('has_lobby')
                            ->required(),
                        Forms\Components\Toggle::make('is_mobile')
                            ->required(),
                        Forms\Components\Toggle::make('has_freespins')
                            ->required(),
                        Forms\Components\Toggle::make('has_tables')
                            ->required(),
                        Forms\Components\Toggle::make('only_demo')
                            ->required(),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Destaques'),
                        Forms\Components\Toggle::make('show_home')
                            ->label('Mostrar na Home'),
                        Forms\Components\Toggle::make('status')
                            ->label('Status')
                            ->helperText('Ative ou desative o jogo')
                            ->default(true)
                            ->required(),
                    ])

                ])->columns(2)
            ]);
    }

    /**
     * @param Table $table
     * @return Table
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                ->label('Capa')
                //->disk('media')
                ,
                Tables\Columns\TextColumn::make('provider.name')
                    ->label('Provedor')
                    ->numeric()
                    ->sortable()
                ,
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Categorias')
                    ->wrap()
                    ->badge()
                ,
                Tables\Columns\TextColumn::make('game_server_url')
                    ->label('Server URL')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('game_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Game ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('game_name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('show_home')
                    ->afterStateUpdated(function ($record, $state) {
                        if($state == 1) {
                            $record->update(['status' => 1]);
                        }
                    })
                    ->label('Exibir na Home'),
                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Destaques'),
                Tables\Columns\TextColumn::make('game_code')
                    ->label('Código')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('game_type')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status'),
                Tables\Columns\TextColumn::make('technology')
                    ->label('Tecnologia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('has_lobby')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_mobile')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_freespins')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_tables')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\ToggleColumn::make('only_demo')
                    ->label('Demo')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('rtp')
                    ->label('RTP')
                    ->suffix('%')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('distribution')
                    ->label('Distribuição')
                    ->badge(),
                Tables\Columns\TextColumn::make('views')
                    ->icon('heroicon-o-eye')
                    ->numeric()
                    ->formatStateUsing(fn (Game $record): string => \Helper::formatNumber($record->views))
                    ->sortable(),
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
                SelectFilter::make('categories.name')
                    ->relationship('categories', 'name')
                    ->preload()
                    ->multiple()
                    ->indicator('Categoria')
                    ->searchable(),
//                SelectFilter::make('Categoria')
//                    ->relationship('category', 'name')
//                    ->label('Selecione uma categoria')
//                    ->indicator('Categoria'),
                SelectFilter::make('Provedor')
                    ->relationship('provider', 'name')
                    ->label('Provedor')
                    ->indicator('Provedor'),
                SelectFilter::make('distribution')
                    ->label('Distribuição')
                    ->options(\Helper::getDistribution())
                    ->attribute('distribution')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Ativar Jogos')
                    ->icon('heroicon-m-check')
                    ->requiresConfirmation()
                    ->action(function($records) {
                        return $records->each->update(['status' => 1]);
                    }),
                Tables\Actions\BulkAction::make('Desativar Jogos')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function($records) {
                        return $records->each(function($record) {
                            $record->update(['status' => 0]);
                        });
                    }),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
