<?php

namespace App\Filament\Resources;

use App\Enums\EntryPortType;
use App\Filament\Resources\EntryPortResource\Pages;
use App\Models\EntryPort;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EntryPortResource extends Resource
{
    protected static ?string $model = EntryPort::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Resources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        EntryPortType::SEA_PORT->value => 'Seaport',
                        EntryPortType::LAND_PORT->value => 'Land port',
                        EntryPortType::AIR_PORT->value => 'Airport',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\Toggle::make('is_fast_track')->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_fast_track')
                    ->label('Is fast track ?'),

                Tables\Columns\TextColumn::make('created_at')
                    ->date('d M Y')
                    ->icon('heroicon-m-calendar')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->date('d M Y')
                    ->icon('heroicon-m-calendar')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntryPorts::route('/'),
        ];
    }
}
