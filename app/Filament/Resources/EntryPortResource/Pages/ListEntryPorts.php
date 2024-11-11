<?php

namespace App\Filament\Resources\EntryPortResource\Pages;

use App\Enums\EntryPortType;
use App\Filament\Resources\EntryPortResource;
use App\Models\EntryPort;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListEntryPorts extends ListRecords
{
    protected static string $resource = EntryPortResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            EntryPortType::AIR_PORT->value => Tab::make(EntryPortType::AIR_PORT->value)
                ->badge(EntryPort::query()->where('type', EntryPortType::AIR_PORT->value)->count())
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('type', EntryPortType::AIR_PORT->value);
                }),
            EntryPortType::LAND_PORT->value => Tab::make(EntryPortType::LAND_PORT->value)
                ->badge(EntryPort::query()->where('type', EntryPortType::LAND_PORT->value)->count())
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('type', EntryPortType::LAND_PORT->value);
                }),
            EntryPortType::SEA_PORT->value => Tab::make(EntryPortType::SEA_PORT->value)
                ->badge(EntryPort::query()->where('type', EntryPortType::SEA_PORT->value)->count())
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('type', EntryPortType::SEA_PORT->value);
                }),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return EntryPort::query()->latest();
    }
}
