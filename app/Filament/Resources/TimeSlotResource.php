<?php

namespace App\Filament\Resources;

use App\Enums\TimeSlotType;
use App\Filament\Resources\TimeSlotResource\Pages;
use App\Models\TimeSlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TimeSlotResource extends Resource
{
    protected static ?string $model = TimeSlot::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Resources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),

                Forms\Components\Select::make('type')
                    ->options([
                        TimeSlotType::ARRIVAL->value => 'Arrival',
                        TimeSlotType::DEPARTURE->value => 'Departure',
                    ])
                    ->required(),

                Forms\Components\TimePicker::make('start_time')->required(),
                Forms\Components\TimePicker::make('end_time')->required(),

                Forms\Components\TextInput::make('fees')
                    ->required()
                    ->integer(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_time')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('end_time')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('fees')
                    ->money('USD')
                    ->sortable()
                    ->searchable(),

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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimeSlots::route('/'),
        ];
    }
}
