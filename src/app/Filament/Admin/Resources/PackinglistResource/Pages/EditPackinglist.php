<?php

namespace App\Filament\Admin\Resources\PackinglistResource\Pages;

use App\Filament\Admin\Resources\PackinglistResource;
use Filament\Resources\Pages\EditRecord;

class EditPackinglists extends EditRecord // <--- PASTIKAN INI SAMA
{
    protected static string $resource = PackinglistResource::class;
}