<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DestinationResource\Pages;
use App\Models\Destination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select; // <-- IMPORT HARUS DI SINI (DI ATAS)

class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Destinasi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Destinasi')
                ->schema([
                    Select::make('trip_id')
                        ->label('Pilih Rencana Trip')
                        ->relationship('trip', 'title')
                        ->required()
                        ->searchable()
                        ->preload(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Destinasi')
                        ->required(),
                    Forms\Components\DatePicker::make('visit_date')
                        ->label('Tanggal Kunjungan'),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('trip.title')->label('Nama Trip')->searchable(),
            Tables\Columns\TextColumn::make('name')->label('Destinasi')->searchable(),
            Tables\Columns\TextColumn::make('visit_date')->date('d M Y'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit' => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}