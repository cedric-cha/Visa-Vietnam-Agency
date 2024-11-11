<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Enums\Gender;
use App\Models\Applicant;
use App\Notifications\OrderPlacedNotification;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ApplicantsRelationManager extends RelationManager
{
    protected static string $relationship = 'applicant';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('password')
                    ->required()
                    ->maxLength(255)
                    ->visibleOn('edit'),

                Forms\Components\Select::make('country')
                    ->required()
                    ->searchable()
                    ->options(
                        DB::table('countries')
                            ->get()
                            ->pluck('name', 'id')
                    ),

                Forms\Components\DatePicker::make('date_of_birth')->required(),

                Forms\Components\Select::make('gender')
                    ->options([
                        Gender::MALE->value => 'Male',
                        Gender::FEMALE->value => 'Female',
                        Gender::OTHER->value => 'Other',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('address')->maxLength(255),
                
                Forms\Components\TextInput::make('phone_number')->maxLength(255),
            
                Forms\Components\TextInput::make('passport_number')
                    ->required()
                    ->maxLength(255),
            
                Forms\Components\DatePicker::make('passport_expiration_date')->required(),

                Forms\Components\FileUpload::make('photo')
                    ->disk('public')
                    ->imageEditor()
                    ->image()
                    ->required(),

                Forms\Components\FileUpload::make('passport_image')
                    ->disk('public')
                    ->image()
                    ->imageEditor()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                Tables\Columns\TextColumn::make('full_name')->searchable(),

                Tables\Columns\TextColumn::make('password')->searchable(),

                Tables\Columns\ImageColumn::make('photo')
                    ->toggleable()
                    ->size(90),

                Tables\Columns\ImageColumn::make('passport_image')
                    ->toggleable()
                    ->width(250)
                    ->height(100),

                Tables\Columns\TextColumn::make('country')
                    ->state(function (Applicant $record): string|null {
                        return DB::table('countries')
                            ->find($record->country, 'name')
                            ?->name;
                    })
                    ->icon('heroicon-m-map-pin')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_of_birth')
                    ->icon('heroicon-m-cake')
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('phone_number')
                    ->icon('heroicon-m-device-phone-mobile')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->default('-'),

                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('passport_number')
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('passport_expiration_date')
                    ->dateTime('M d Y')
                    ->icon('heroicon-m-calendar')
                    ->toggleable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d Y')
                    ->icon('heroicon-m-calendar')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('M d Y')
                    ->icon('heroicon-m-calendar')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function (Applicant $record) {
                        try {
                            Notification::route('mail', $record->email)->notify(
                                new OrderPlacedNotification($record->order->reference, $record->password, url('/check-visa-status'))
                            );
                        } catch (Exception $e) {}
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([]);
    }
}
