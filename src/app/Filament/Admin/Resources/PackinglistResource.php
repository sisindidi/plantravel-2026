<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms\Components\Repeater; // <-- SELIPIN INI DI PALING ATAS COK!
use App\Filament\Admin\Resources\PackinglistResource\Pages;
use App\Models\Packinglist;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PackinglistResource extends Resource
{
    protected static ?string $model = Packinglist::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationLabel = 'Daftar Packing List';


public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Daftar Packing List Perjalanan')
                ->description('Pilih 1 trip utama dan input semua rincian barang bawaan lu di bawah.')
                ->schema([
                    
                    // User milih 1 trip utama di luar repeater
                    Forms\Components\Select::make('trip_id')
                        ->label('Pilih Rencana Trip')
                        ->options(fn () => \App\Models\Trip::where('user_id', \Illuminate\Support\Facades\Auth::id())->pluck('title', 'id'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->disabled(fn (string $context): bool => $context === 'edit'),

                    // REPEATER: Menggunakan field array kustom agar tidak memicu crash relasi hasMany gaib
                    Forms\Components\Repeater::make('items_repeater')
                        ->label('Rincian Barang Bawaan')
                        ->schema([
                            Forms\Components\TextInput::make('item_name')
                                ->label('Nama Barang')
                                ->placeholder('Contoh: Baju, Charger, Jaket')
                                ->required()
                                ->columnSpan(2),

                            Forms\Components\Checkbox::make('is_checked')
                                ->label('Sudah Siap?')
                                ->columnSpan(2),
                        ])
                        ->columns(4)
                        ->addActionLabel('Tambah Barang (+)')
                        ->columnSpanFull(),
                ]),
        ]);
}
   
public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('trip.title')->label('Trip')->searchable(),
                Tables\Columns\TextColumn::make('item_name')->label('Barang')->searchable(),
                Tables\Columns\CheckboxColumn::make('is_checked')->label('Status'),
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
            'index' => Pages\ListPackinglists::route('/'),
            'create' => Pages\CreatePackinglists::route('/create'),
            'edit' => Pages\EditPackinglists::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('trip', fn ($q) => $q->where('user_id', Auth::id()));
    }
}