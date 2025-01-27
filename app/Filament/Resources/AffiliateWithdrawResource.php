<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AffiliateWithdrawResource\Pages;
use App\Models\AffiliateWithdraw;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AffiliateWithdrawResource extends Resource
{
    protected static ?string $model = AffiliateWithdraw::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('afiliado') || auth()->user()->hasRole('admin');
    }

    /**
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return auth()->user()->hasRole('afiliado') ? 'Meus Saques' : 'Saques de Afiliados';
    }

    /**
     * @return string
     */
    public static function getModelLabel(): string
    {
        return auth()->user()->hasRole('afiliado') ? 'Meus Saques' : 'Saques de Afiliados';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(auth()->user()->hasRole('afiliado') ? AffiliateWithdraw::query()->where('user_id', auth()->id()) : AffiliateWithdraw::query())
            ->columns([
                Tables\Columns\TextColumn::make('amount')
                    ->label('Valor')
                    ->formatStateUsing(fn (AffiliateWithdraw $record): string => $record->symbol . ' ' . $record->amount)
                    ->sortable(),
                Tables\Columns\TextColumn::make('pix_type')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state): string => \Helper::formatPixType($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('pix_key')
                    ->label('Chave Pix'),
                Tables\Columns\TextColumn::make('bank_info')
                    ->label('Informações Bancaria'),
                Tables\Columns\TextColumn::make('proof')
                    ->label('Comprovante')
                    ->html()
                    ->formatStateUsing(fn (string $state): string => '<a href="'.url('storage/'.$state).'" target="_blank">Baixar</a>'),
                auth()->user()->hasRole('afiliado') ? Tables\Columns\IconColumn::make('status')
                    ->boolean() : Tables\Columns\ToggleColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAffiliateWithdraws::route('/'),
        ];
    }
}
