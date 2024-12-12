<?php

namespace App\Filament\Resources\TimeSlotResource\Pages;

use App\Enums\TimeSlotType;
use App\Filament\Resources\TimeSlotResource;
use App\Models\TimeSlot;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTimeSlots extends ListRecords
{
    protected static string $resource = TimeSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            TimeSlotType::ARRIVAL->value => Tab::make(TimeSlotType::ARRIVAL->value)
                ->badge(TimeSlot::query()->where('type', TimeSlotType::ARRIVAL->value)->count())
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('type', TimeSlotType::ARRIVAL->value);
                }),
            TimeSlotType::DEPARTURE->value => Tab::make(TimeSlotType::DEPARTURE->value)
                ->badge(TimeSlot::query()->where('type', TimeSlotType::DEPARTURE->value)->count())
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('type', TimeSlotType::DEPARTURE->value);
                }),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return TimeSlot::query()->latest();
    }
}
