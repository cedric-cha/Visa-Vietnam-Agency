<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\EntryPort;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Support\Enums\FontWeight;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('processing_time_id')
                    ->relationship('processingTime', 'description')
                    ->required(),
                    
                Forms\Components\Select::make('purpose_id')
                    ->relationship('purpose', 'description')
                    ->required(),
                
                Forms\Components\Select::make('visa_type_id')
                    ->relationship('visaType', 'description')
                    ->required(),

                Forms\Components\Select::make('entry_port_id')
                    ->relationship('entryPort')
                    ->getOptionLabelFromRecordUsing(fn (EntryPort $record): string => '(' . $record->type . ') ' . $record->name)
                    ->searchable()
                    ->preload()
                    ->required(),
                    
                Forms\Components\DatePicker::make('arrival_date')->required(),
                Forms\Components\DatePicker::make('departure_date')->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        OrderStatus::PROCESSED->value => 'Processed',
                        OrderStatus::CANCELLED->value => 'Cancelled',
                    ])
                    ->required()
                    ->live()
                    ->visibleOn('edit'),

                Forms\Components\FileUpload::make('visa_pdf')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->preserveFilenames()
                    ->required(fn (Forms\Get $get) => $get('status') === OrderStatus::PROCESSED->value)
                    ->visibleOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')->searchable(),

                Tables\Columns\TextColumn::make('applicant.ful_name')
                    ->state(fn (Order $record) => $record->applicant()->first()->full_name)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('processingTime.description')
                    ->icon('heroicon-m-clock')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('purpose.description')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('visaType.description')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('entry_port_id')
                    ->sortable()
                    ->state(fn (Order $record) => '(' . $record->entryPort->type . ') ' . $record->entryPort->name)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('arrival_date')
                    ->icon('heroicon-m-calendar')
                    ->dateTime('M d Y')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('departure_date')
                    ->icon('heroicon-m-calendar')
                    ->dateTime('M d Y')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_fees')
                    ->money('USD')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_fees_with_discount')
                    ->money('USD')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->colors([
                        'warning' => OrderStatus::PENDING->value,
                        'success' => OrderStatus::TRANSACTION_SUCCESS->value,
                        'orange' => OrderStatus::TRANSACTION_EXPIRED->value,
                        'info' => OrderStatus::TRANSACTION_CANCELED->value,
                        'red' => OrderStatus::TRANSACTION_FAILED->value,
                        'yellow' => OrderStatus::TRANSACTION_IN_PROGRESS->value,
                        'primary' => OrderStatus::PROCESSED->value,
                        'danger' => OrderStatus::CANCELLED->value
                    ]),

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
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),
                ])
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
            RelationManagers\ApplicantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('reference')
                    ->weight(FontWeight::Bold),

                Infolists\Components\TextEntry::make('applicant')
                    ->state(fn (Order $record) => $record->applicant()->first()->full_name)
                    ->weight(FontWeight::Bold),

                Infolists\Components\TextEntry::make('processingTime.description')
                    ->icon('heroicon-m-clock')
                    ->weight(FontWeight::Bold),
                    
                Infolists\Components\TextEntry::make('purpose.description')
                    ->weight(FontWeight::Bold),
                
                Infolists\Components\TextEntry::make('visaType.description')
                    ->weight(FontWeight::Bold),
                    
                Infolists\Components\TextEntry::make('entry_port_id')
                    ->state(fn (Order $record) => '(' . $record->entryPort->type . ') ' . $record->entryPort->name)
                    ->weight(FontWeight::Bold),
                
                Infolists\Components\TextEntry::make('arrival_date')
                    ->dateTime('M d Y')
                    ->icon('heroicon-m-calendar')
                    ->weight(FontWeight::Bold),
                
                Infolists\Components\TextEntry::make('departure_date')
                    ->dateTime('M d Y')
                    ->icon('heroicon-m-calendar')
                    ->weight(FontWeight::Bold),

                Infolists\Components\TextEntry::make('total_fees')
                    ->money('USD')
                    ->weight(FontWeight::Bold),

                Infolists\Components\TextEntry::make('total_fees_with_discount')
                    ->money('USD')
                    ->weight(FontWeight::Bold)
                    ->default('-'),

                Infolists\Components\TextEntry::make('status')
                    ->badge()
                    ->colors([
                        'warning' => OrderStatus::PENDING->value,
                        'success' => OrderStatus::TRANSACTION_SUCCESS->value,
                        'orange' => OrderStatus::TRANSACTION_EXPIRED->value,
                        'info' => OrderStatus::TRANSACTION_CANCELED->value,
                        'red' => OrderStatus::TRANSACTION_FAILED->value,
                        'yellow' => OrderStatus::TRANSACTION_IN_PROGRESS->value,
                        'primary' => OrderStatus::PROCESSED->value,
                        'danger' => OrderStatus::CANCELLED->value
                    ]),

                Infolists\Components\TextEntry::make('created_at')
                    ->dateTime('M d Y')
                    ->icon('heroicon-m-calendar')
                    ->weight(FontWeight::Bold),

                Infolists\Components\TextEntry::make('updated_at')
                    ->dateTime('M d Y')
                    ->icon('heroicon-m-calendar')
                    ->weight(FontWeight::Bold),
            ]);
    }
}
