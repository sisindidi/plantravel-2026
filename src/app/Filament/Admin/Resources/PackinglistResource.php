<?php

namespace App\Filament\Admin\Resources;

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
    return $form->schema([
        Forms\Components\Select::make('trip_id')
            ->relationship('trip', 'title')->required(),
        Forms\Components\TextInput::make('item_name')->required(),
        Forms\Components\Checkbox::make('is_checked'),
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