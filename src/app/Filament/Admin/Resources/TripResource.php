<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TripResource\Pages;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth; // Wajib di-import untuk Auth::id()

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'heroicon-o-map'; // Ubah icon jadi peta biar keren

    protected static ?string $navigationLabel = 'Rencana Trip';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Perjalanan')
                    ->description('Silakan isi informasi lengkap rencana perjalanan.')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Rencana Trip')
                            ->placeholder('Contoh: Eksplorasi Jepang Bersama Keluarga')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('country_or_city')
                            ->label('Kota / Negara Tujuan')
                            ->placeholder('Contoh: Tokyo, Jepang')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('start_date')
                            ->label('Tanggal Keberangkatan')
                            ->required(),

                        Forms\Components\TextInput::make('pax_count')
                            ->label('Jumlah Peserta ')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),

                        // Otomatis ngisi user_id yang login di latar belakang
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn () => Auth::id())
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Trip')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('country_or_city')
                    ->label('Tujuan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tgl Berangkat')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('pax_count')
                    ->label('Peserta')
                    ->numeric()
                    ->badge() // Dibikin bentuk badge biar cakep visualnya
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Tambah aksi hapus satuan
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
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }

    /**
     * ISOLASI DATA: Hanya menampilkan data Trip milik user yang sedang login!
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }
}