<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Estimasi Budget Trip';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Rencana Anggaran Perjalanan')
                    ->description('Pilih 1 trip utama Anda dan input semua rincian estimasi biaya kebutuhan di bawah.')
                    ->schema([
                        
                        // FIX: Dropdown ini dipindah ke LUAR REPEATER agar user cukup milih 1 kali saja pas awal!
                        Forms\Components\Select::make('trip_id')
                            ->label('Pilih Rencana Trip Utama')
                            ->options(fn () => Trip::where('user_id', Auth::id())->pluck('title', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn (string $context): bool => $context === 'edit'), // Kunci trip_id pas mode edit

                        // REPEATER: Sekarang repeater murni hanya berisi rincian item kebutuhan dan biaya
                        Forms\Components\Repeater::make('expense_details')
                            ->label('Daftar Rincian Kebutuhan Biaya')
                            ->schema([
                                Forms\Components\TextInput::make('expense_name')
                                    ->label('Nama Kebutuhan')
                                    ->placeholder('Contoh: Tiket Pesawat, Hotel, Belanja, Makan')
                                    ->required()
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('amount')
                                    ->label('Estimasi Biaya')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->placeholder('Misal: 5000000')
                                    ->required()
                                    ->columnSpan(2),
                            ])
                            ->columns(4) // Membagi inputan nama kebutuhan & biaya menjadi berdampingan rapi
                            ->addActionLabel('Tambah Kebutuhan Biaya (+)') 
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('trip.title')
                    ->label('Nama Trip')
                    ->searchable(),

                Tables\Columns\TextColumn::make('expense_name')
                    ->label('Kebutuhan Biaya')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Estimasi Anggaran')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->summarize(Tables\Columns\Summarizers\Sum::make()
                        ->label('Total Estimasi')
                        ->money('IDR', locale: 'id')
                    ),
            ])
            ->groups([
                Tables\Grouping\Group::make('trip.title')
                    ->label('Rencana Trip')
                    ->collapsible(),
            ])
            ->defaultGroup('trip.title')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
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