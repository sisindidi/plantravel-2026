<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ItineraryResource\Pages;
use App\Models\Itinerary;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ItineraryResource extends Resource
{
    protected static ?string $model = Itinerary::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock'; 

    protected static ?string $navigationLabel = 'Jadwal Perjalanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pilih Trip Utama')
                    ->schema([
                        Forms\Components\Select::make('trip_id')
                            ->label('Rencana Trip')
                            ->options(fn () => \App\Models\Trip::where('user_id', Auth::id())->pluck('title', 'id'))
                            ->searchable()
                            ->required(),
                    ]),

                Forms\Components\Section::make('Susun Jadwal Harian (Rundown)')
                    ->description('Lu bisa tambah hari dan isi tempat wisatanya langsung di sini sekaligus!')
                    ->schema([
                        
                        // REPEATER UTAMA: Kelola Hari
                        Forms\Components\Repeater::make('itineraries_by_day')
                            ->label('Daftar Hari Perjalanan')
                            ->schema([
                                
                                Forms\Components\TextInput::make('day_number')
                                    ->label('Hari Ke-')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Contoh: 1')
                                    // FIX TYPE HINTING: Menggunakan TextInput $component agar tidak pemicu crash data type & minus
                                    ->default(fn (Forms\Components\TextInput $component) => count($component->getContainer()->getState() ?? []) + 1),

                                
                                Forms\Components\Repeater::make('activities_list')
                                    ->label('Rencana Kegiatan di Hari Ini')
                                    ->schema([
                                        Forms\Components\TimePicker::make('start_time')
                                            ->label('Jam')
                                            ->required(),

                                        Forms\Components\TextInput::make('activity')
                                            ->label('Tempat Wisata / Kegiatan')
                                            ->placeholder('Contoh: Tokyo Tower / Disneyland')
                                            ->required(),

                                        Forms\Components\TextInput::make('notes')
                                            ->label('Catatan Singkat (Opsional)')
                                            ->placeholder('Contoh: Beli tiket via Klook'),
                                    ])
                                    ->columns(3) 
                                    ->createItemButtonLabel('Tambah Tempat Wisata Baru') 
                                    ->required(),

                            ])
                            ->createItemButtonLabel('Tambah Hari Baru (Hari Selanjutnya)') 
                            ->columnSpanFull(),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('day_number')
                    ->label('Hari Ke')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_time')
                    ->label('Jam Mulai')
                    ->time('H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('activity')
                    ->label('Agenda Tempat Wisata')
                    ->searchable(),
            ])
            ->defaultSort('day_number', 'asc') 
            ->groups([
                Tables\Grouping\Group::make('trip.title')
                    ->label('Nama Trip')
                    ->collapsible(), 
            ])
            ->defaultGroup('trip.title') 
            ->filters([
                Tables\Filters\SelectFilter::make('trip_id')
                    ->label('Filter Berdasarkan Trip')
                    ->options(fn () => Trip::where('user_id', Auth::id())->pluck('title', 'id')),
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
            'index' => Pages\ListItineraries::route('/'),
            'create' => Pages\CreateItinerary::route('/create'),
            'edit' => Pages\EditItinerary::route('/{record}/edit'),
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