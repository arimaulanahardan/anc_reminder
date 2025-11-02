<?php

namespace App\Filament\Resources\JadwalKunjungans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class JadwalKunjunganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('pasien_id')
                    ->relationship('pasien', 'nama')
                    ->required(),
                DatePicker::make('tanggal_kunjungan')
                    ->required(),
                TimePicker::make('waktu'),
                TextInput::make('lokasi'),
                Select::make('frekuensi_pengingat')
                    ->options([
                        'sekali' => 'Sekali',
                        'mingguan' => 'Mingguan',
                        'dua_minggu_sekali' => 'Dua Minggu Sekali',
                        'bulanan' => 'Bulanan',
                    ])
                    ->required(),
                Textarea::make('pesan_pengingat')
                    ->columnSpanFull(),
                Toggle::make('pengingat_otomatis')
                    ->required(),
            ]);
    }
}
