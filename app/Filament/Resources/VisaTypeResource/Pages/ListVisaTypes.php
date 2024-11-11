<?php

namespace App\Filament\Resources\VisaTypeResource\Pages;

use App\Filament\Resources\VisaTypeResource;
use App\Models\VisaType;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListVisaTypes extends ListRecords
{
    protected static string $resource = VisaTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return VisaType::query()->latest();
    }
}
