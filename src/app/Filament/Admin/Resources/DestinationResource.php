<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DestinationResource\Pages;
use App\Models\Destination;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Destinasi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Rencana Destinasi Trip')
                ->description('Pilih 1 trip utama Anda dan input daftar tempat wisata yang dikunjungi.')
                ->schema([
                    
                    // User milih 1 trip utama di luar repeater
                    Forms\Components\Select::make('trip_id')
                        ->label('Pilih Rencana Trip Utama')
                        ->options(fn () => Trip::where('user_id', Auth::id())->pluck('title', 'id'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->disabled(fn (string $context): bool => $context === 'edit'),

                    // REPEATER: Cuma input nama tempat murni tanpa diganggu datepicker
                    Forms\Components\Repeater::make('destinations_repeater')
                        ->label('Daftar Tempat Wisata / Objek Destinasi')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Tempat Wisata')
                                ->placeholder('Contoh: Gunung Fuji, Disneyland, Tokyo Tower')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Tambah Destinasi Baru (+)')
                        ->columnSpanFull(),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('trip.title')
                ->label('Nama Trip')
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->label('Destinasi')
                ->searchable(),
        ])
        ->groups([
            Tables\Grouping\Group::make('trip.title')
                ->label('Rencana Trip')
                ->collapsible(),
        ])
        ->defaultGroup('trip.title')
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('trip', function ($query) {
                $query->where('user_id', Auth::id());
            });
    }
}