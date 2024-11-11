<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?string $heading = 'Latest Pending Orders';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('status', OrderStatus::PENDING)
                    ->latest()
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('reference'),

                Tables\Columns\TextColumn::make('applicant.full_name'),

                Tables\Columns\TextColumn::make('processingTime.description')
                    ->icon('heroicon-m-clock'),

                Tables\Columns\TextColumn::make('purpose.description'),

                Tables\Columns\TextColumn::make('visaType.description'),

                Tables\Columns\TextColumn::make('entry_port_id')
                    ->state(fn (Order $record) => '(' . $record->entryPort->type . ') ' . $record->entryPort->name),

                Tables\Columns\TextColumn::make('arrival_date')
                    ->icon('heroicon-m-calendar')
                    ->dateTime('M d Y'),

                Tables\Columns\TextColumn::make('total_fees')->money('USD'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d Y')
                    ->icon('heroicon-m-calendar'),
            ])->actions([
                Tables\Actions\EditAction::make()
                    ->label('Details')
                    ->url(fn (Order $record): string => OrderResource::getUrl('edit', ['record' => $record])),
            ]);

    }
}
