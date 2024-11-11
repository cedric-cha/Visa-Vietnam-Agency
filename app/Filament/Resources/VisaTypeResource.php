<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisaTypeResource\Pages;
use App\Models\VisaType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VisaTypeResource extends Resource
{
    protected static ?string $model = VisaType::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Resources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),

                Forms\Components\TextInput::make('fees')
                    ->required()
                    ->integer(),

                Forms\Components\Toggle::make('enabled')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('fees')
                    ->money('USD')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('enabled')
                    ->label('Enabled ?'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d Y')
                    ->icon('heroicon-m-calendar')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('M d Y')
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
            'index' => Pages\ListVisaTypes::route('/'),
        ];
    }
}
