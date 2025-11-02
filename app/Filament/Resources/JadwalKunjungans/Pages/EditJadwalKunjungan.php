<?php

namespace App\Filament\Resources\JadwalKunjungans\Pages;

use App\Filament\Resources\JadwalKunjungans\JadwalKunjunganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJadwalKunjungan extends EditRecord
{
    protected static string $resource = JadwalKunjunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
