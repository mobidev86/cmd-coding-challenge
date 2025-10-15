<?php

namespace App\Filament\Resources;

use App\Enums\QuoteStatus;
use App\Enums\ServiceType;
use App\Filament\Resources\QuoteResource\Pages\ManageQuotes;
use App\Models\Quote;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns;
use Filament\Tables\Filters;
use Filament\Tables\Table;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Components\Textarea::make('address')
                    ->required()
                    ->rows(3),
                Components\Select::make('service_type')
                    ->options(ServiceType::toSelectArray())
                    ->required(),
                Components\DateTimePicker::make('booking_datetime')
                    ->required()
                    ->native(false),
                Components\TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->suffix('hours'),
                Components\Textarea::make('additional_notes')
                    ->rows(3),
                Components\Select::make('status')
                    ->options(QuoteStatus::class)
                    ->required()
                    ->default(QuoteStatus::PENDING),
                Components\TextInput::make('estimated_price')
                    ->numeric()
                    ->prefix('$'),
                Components\TextInput::make('final_price')
                    ->numeric()
                    ->prefix('$'),
                Components\Textarea::make('rejection_reason')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),
                Columns\TextColumn::make('phone')
                    ->searchable()
                    ->copyable(),
                Columns\TextColumn::make('service_type')
                    ->badge(),
                Columns\TextColumn::make('booking_datetime')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
                Columns\TextColumn::make('duration')
                    ->suffix(' hrs')
                    ->numeric(decimalPlaces: 1),
                Columns\TextColumn::make('estimated_price')
                    ->money('USD')
                    ->sortable(),
                Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filters\SelectFilter::make('status')
                    ->options(QuoteStatus::class)
                    ->multiple(),
                Filters\SelectFilter::make('service_type')
                    ->options(ServiceType::toSelectArray())
                    ->multiple(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageQuotes::route('/'),
        ];
    }
}
