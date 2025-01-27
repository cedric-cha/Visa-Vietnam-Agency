<?php

namespace App\Filament\Widgets;

use App\Enums\OrderServiceType;
use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?string $heading = 'Latest Paid Orders';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('status', OrderStatus::TRANSACTION_SUCCESS->value)
                    ->latest()
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->date('d M Y')
                    ->icon('heroicon-m-calendar'),

                Tables\Columns\TextColumn::make('reference'),

                Tables\Columns\TextColumn::make('service')
                    ->state(function (Order $record) {
                        return match ($record->service) {
                            OrderServiceType::EVISA->value => 'E-Visa',
                            OrderServiceType::FAST_TRACK->value => 'Fast Track',
                            OrderServiceType::EVISA_FAST_TRACK->value => 'E-Visa + Fast Track',
                        };
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'E-Visa' => 'primary',
                        'Fast Track' => 'info',
                        'E-Visa + Fast Track' => 'warning',
                    })
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('applicant.full_name'),

                Tables\Columns\TextColumn::make('total_fees')->money('USD'),
            ])->actions([
                Tables\Actions\EditAction::make()
                    ->label('Details')
                    ->url(fn (Order $record): string => OrderResource::getUrl('edit', ['record' => $record])),
            ]);

    }
}
