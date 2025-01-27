<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderResource\Pages;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Helpers\Core as Helper;
use Illuminate\Database\Eloquent\Model;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Todos os Provedores';

    protected static ?string $modelLabel = 'Todos os Provedores';

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
                Forms\Components\Section::make('')
                ->schema([
                    Forms\Components\TextInput::make('code')
                        ->label('Código')
                        ->placeholder('Digite o Código')
                        ->maxLength(50),
                    Forms\Components\TextInput::make('name')
                        ->placeholder('Digite o Nome')
                        ->label('Nome')
                        ->maxLength(50),
                    Forms\Components\Select::make('distribution')
                        ->label('Distribuição')
                        ->placeholder('Selecione a distribuição')
                        ->required()
                        ->options(\Helper::getDistribution()),
                    Forms\Components\TextInput::make('rtp')
                        ->label('RTP')
                        ->numeric()
                        ->default(90),
                    Forms\Components\TextInput::make('views')
                        ->label('Visualizações')
                        ->numeric()
                        ->default(1),
                    Forms\Components\Toggle::make('status')
                        ->label('Status')
                        ->inline(false)
                        ->required(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('distribution')
                    ->label('Distribuição')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('rtp')
                    ->label('RTP')
                    ->suffix('%')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('views')
                    ->label('Visualizações')
                    ->numeric()
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
                SelectFilter::make('distribution')
                    ->label('Distribuição')
                    ->options(Helper::getDistribution())
                    ->attribute('distribution')
                ,
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProviders::route('/'),
//            'create' => Pages\CreateProvider::route('/create'),
//            'edit' => Pages\EditProvider::route('/{record}/edit'),
        ];
    }
}
