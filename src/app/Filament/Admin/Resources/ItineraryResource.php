<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ItineraryResource\Pages;
use App\Models\Itinerary;
use App\Models\Trip;
use App\Models\Destination; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get; 
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
                            ->options(fn () => Trip::where('user_id', Auth::id())->pluck('title', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live() // Kunci pemantik data realtime Livewire
                            ->disabled(fn (string $context): bool => $context === 'edit'), // Kunci pas edit biar ga sengketa trip_id
                    ]),

                Forms\Components\Section::make('Susun Jadwal Harian (Rundown)')
                    ->description('Silakan isi tempat wisata utama dan aktivitas tambahan sesuai kebutuhan Anda.')
                    ->schema([
                        
                        // REPEATER UTAMA: Kelola Hari
                        Forms\Components\Repeater::make('itineraries_by_day')
                            ->label('Daftar Hari Perjalanan')
                            ->schema([
                                
                                Forms\Components\TextInput::make('day_number')
                                    ->label('Hari Ke-')
                                    ->numeric()
                                    ->required()
                                    ->default(fn (Forms\Components\TextInput $component) => count($component->getContainer()->getState() ?? []) + 1),

                                // NESTED REPEATER: Rundown harian
                                Forms\Components\Repeater::make('activities_list')
                                    ->label('Rencana Kegiatan di Hari Ini')
                                    ->schema([
                                        Forms\Components\TimePicker::make('start_time')
                                            ->label('Jam')
                                            ->required(),

                                        Forms\Components\Select::make('destination_id')
    ->label('Tempat Wisata')
    ->placeholder('Pilih lokasi wisata...')
    ->options(function (Forms\Components\Select $component) {
        // Ambil trip_id dari state Livewire terluar
        $tripId = $component->getLivewire()->data['trip_id'] ?? null;

        // BACKUP RESMI EDIT: Kalau data state kosong (saat load pertama kali), 
        // ambil dari record model utama yang sedang di-edit di page Livewire tersebut
        if (!$tripId && isset($component->getLivewire()->record)) {
            $tripId = $component->getLivewire()->record->trip_id;
        }

        if (!$tripId) {
            // JALUR DARURAT: Kalau bener-bener gak ketemu trip_id sama sekali, 
            // ambil seluruh destinasi milik user yang sedang login saat ini biar tetep muncul label teksnya!
            return \App\Models\Destination::whereHas('trip', function ($query) {
                $query->where('user_id', \Illuminate\Support\Facades\Auth::id());
            })->pluck('name', 'id');
        }

        return \App\Models\Destination::where('trip_id', $tripId)->pluck('name', 'id');
    })
    ->getOptionLabelUsing(fn ($value) => \App\Models\Destination::find($value)?->name) // KUNCI SAKTI: Memaksa Filament nyari nama teks label-nya berdasarkan ID yang tersimpan di DB pas load halaman!
    ->searchable()
    ->preload()
    ->nullable(),
                                                                                // 2. AKTIVITAS BEBAS (OPSIONAL): Input text bebas
                                        Forms\Components\TextInput::make('activity')
                                            ->label('Aktivitas Tambahan')
                                            ->placeholder('Contoh: Jajan, Kulineran, Check-in, Istirahat')
                                            ->nullable(),

                                        Forms\Components\TextInput::make('notes')
                                            ->label('Catatan Singkat')
                                            ->placeholder('Contoh: Siapin uang cash / Beli tiket di Klook')
                                            ->columnSpanFull()
                                            ->nullable(),
                                    ])
                                    ->columns(3) 
                                    ->createItemButtonLabel('Tambah Agenda Baru') 
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

                Tables\Columns\TextColumn::make('destination.name')
                    ->label('Tempat Wisata')
                    ->placeholder('-')
                    ->searchable(),

                Tables\Columns\TextColumn::make('activity')
                    ->label('Aktivitas Tambahan')
                    ->placeholder('-'),
            ])
            ->defaultSort('day_number', 'asc') 
            ->groups([
                Tables\Grouping\Group::make('trip.title')
                    ->label('Nama Trip')
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