<?php

namespace App\Filament\Resources\ProcessingTimeResource\Pages;

use App\Filament\Resources\ProcessingTimeResource;
use App\Models\ProcessingTime;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListProcessingTimes extends ListRecords
{
    protected static string $resource = ProcessingTimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return ProcessingTime::query()->latest();
    }
}
