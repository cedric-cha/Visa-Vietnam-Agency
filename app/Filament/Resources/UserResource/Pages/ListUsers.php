<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Notifications\AccountCreatedNotification;
use Exception;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        $password = Str::password();

        return [
            Actions\CreateAction::make()
                ->before(function ($data) use ($password) {
                    $data['password'] = bcrypt($password);

                    return $data;
                })
                ->after(function (User $record) use ($password) {
                    try {
                        $record->notify(new AccountCreatedNotification(url('/admin/login'), $password));
                    } catch (Exception $e) {
                    }
                }),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return User::query()->latest();
    }
}
