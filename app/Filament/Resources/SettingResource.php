<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{

    protected Setting $record;

    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * @dev victormsalatiel - Meu instagram
     * @return void
     */
    public function mount(): void
    {
        $this->record = Setting::first();
    }

    /**
     * @param Model $record
     * @return FilamentPageSidebar
     */
    public static function sidebar(Model $record): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
            ->setTitle('Definições')
            ->setDescription('Ajustes da plataforma')
            ->setNavigationItems([
                PageNavigationItem::make('Padrão')
                    ->translateLabel()
                    ->url(static::getUrl('index'))->icon('heroicon-o-cog-6-tooth')
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName() . '.index');
                    }),

                PageNavigationItem::make('Bônus Vip')
                    ->translateLabel()
                    ->url(static::getUrl('bonus', ['record' => $record->id]))->icon('heroicon-o-currency-dollar')
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName() . '.bonus');
                    }),
                 PageNavigationItem::make('Rollover')
                     ->translateLabel()
                     ->url(static::getUrl('rollover', ['record' => $record->id]))->icon('heroicon-o-currency-dollar')
                     ->isActiveWhen(function () {
                         return request()->routeIs(static::getRouteBaseName() . '.rollover');
                     }),
                PageNavigationItem::make('Taxas')
                    ->translateLabel()
                    ->url(static::getUrl('fee', ['record' => $record->id]))->icon('heroicon-o-chart-pie')
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName() . '.fee');
                    }),
                PageNavigationItem::make('Limites')
                    ->translateLabel()
                    ->url(static::getUrl('limit', ['record' => $record->id]))->icon('heroicon-o-adjustments-vertical')
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName() . '.limit');
                    }),
                PageNavigationItem::make('Pagamentos')
                    ->translateLabel()
                    ->url(static::getUrl('payment', ['record' => $record->id]))->icon('heroicon-o-banknotes')
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName() . '.payment');
                    }),
            ]);
    }

    /**
     *
     * @dev victormsalatiel
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    /**
     * @dev victormsalatiel
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
     * @return array|\Filament\Resources\RelationManagers\RelationGroup[]|\Filament\Resources\RelationManagers\RelationManagerConfiguration[]|string[]
     */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * @dev victormsalatiel
     * @return array|\Filament\Resources\Pages\PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\DefaultSetting::route('/'),
            'limit' => Pages\LimitSetting::route('/limit/{record}'),
            'bonus' => Pages\BonusSetting::route('/bonus/{record}'),
            'rollover' => Pages\RolloverSetting::route('/rollover/{record}'),
            'details' => Pages\DefaultSetting::route('/details/{record}'),
            'fee' => Pages\FeeSetting::route('/fee/{record}'),
            'payment' => Pages\PaymentSetting::route('/payment/{record}'),
        ];
    }
}
