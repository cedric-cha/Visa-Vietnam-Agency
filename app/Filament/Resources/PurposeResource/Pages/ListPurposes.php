<?php

namespace App\Filament\Resources\PurposeResource\Pages;

use App\Filament\Resources\PurposeResource;
use App\Models\Purpose;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPurposes extends ListRecords
{
    protected static string $resource = PurposeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return Purpose::query()->latest();
    }
}
