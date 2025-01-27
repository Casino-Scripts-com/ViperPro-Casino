<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\GGRGamesFiver;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class MyBetsTableWidget extends BaseWidget
{

    protected static ?string $heading = 'Todas Apostas';

    protected static ?int $navigationSort = -1;

    protected int | string | array $columnSpan = 'full';

    public User $record;
    

    /**
     * @param Table $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        // \Log::info('DADOS XXXXXXXXXXX ' . json_encode($this->record->id));

        return $table
            ->query(Order::query()->where('user_id', $this->record->id))
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('game')
                    ->label('Jogo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type_money')
                    ->label('Tipo de Transação')
                    ->badge()
                    ->color('success')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Preço')
                    ->money('BRL')
                    ->searchable(),
                Tables\Columns\TextColumn::make('providers')
                    ->label('Provedor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('Data Inicial'),
                        DatePicker::make('created_until')->label('Data Final'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Criação Inicial ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Criação Final ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ;
    }


    /**
     * @return bool
     */
    public static function canView(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
