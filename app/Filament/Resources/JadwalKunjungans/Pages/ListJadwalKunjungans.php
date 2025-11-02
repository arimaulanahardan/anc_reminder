<?php

namespace App\Filament\Resources\JadwalKunjungans\Pages;

use App\Filament\Resources\JadwalKunjungans\JadwalKunjunganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJadwalKunjungans extends ListRecords
{
    protected static string $resource = JadwalKunjunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
