<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VipResource\Pages;
use App\Filament\Resources\VipResource\RelationManagers;
use App\Models\Vip;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VipResource extends Resource
{
    protected static ?string $model = Vip::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationLabel = 'Vip';

    protected static ?string $modelLabel = 'Vip';

    protected static ?string $slug = 'vip';

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Vip')
                    ->description('Cadastre sua lista vip de bonus')
                    ->schema([
                        FileUpload::make('bet_symbol')
                            ->label('Símbolo')
                            ->placeholder('Carregue um Símbolo')
                            ->image()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('bet_level')
                            ->label('Level')
                            ->required()
                            //->readOnly(fn (string $context): bool => $context === 'create')
                            ->placeholder('Mantenha a lista numérica na ordem')
//                            ->default(function() {
//                                $ultimoRegistro = Vip::latest()->first();
//                                return $ultimoRegistro ? $ultimoRegistro->id + 1 : 1;
//                            })
                        ,
                        Forms\Components\TextInput::make('bet_required')
                            ->label('Aposta necessária')
                            ->required()
                            ->placeholder('Digite aposta necessária para ganhar o prêmio')
                            ->numeric(),
                        Forms\Components\Select::make('bet_period')
                            ->label('Período')
                            ->options([
                                'weekly' => 'Semanal',
                                'monthly' => 'Mensal',
                                'yearly' => 'Anual',
                            ]),
                        Forms\Components\TextInput::make('bet_bonus')
                            ->label('Bônus')
                            ->placeholder('Digite o total de bônus')
                            ->required()
                            ->numeric(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('bet_symbol')
                    ->label('Imagem'),
                Tables\Columns\TextColumn::make('bet_level')
                    ->label('Level')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bet_required')
                    ->label('Aposta necessária')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bet_period')
                    ->label('Período')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bet_bonus')
                    ->label('Bônus')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVips::route('/'),
            'create' => Pages\CreateVip::route('/create'),
            'edit' => Pages\EditVip::route('/{record}/edit'),
        ];
    }
}
