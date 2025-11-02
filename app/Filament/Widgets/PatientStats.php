<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Pasien;
use App\Models\JadwalKunjungan;
use Carbon\Carbon;

class PatientStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pasien', Pasien::count())
                ->description('Total pasien yang terdaftar')
                ->descriptionIcon('heroicon-o-user'),
                // jadwal kunjungan form pengingat otomatis
                Stat::make('Jadwal Kunjungan Aktif', JadwalKunjungan::where('pengingat_otomatis', true)->count())
                ->description('Jadwal kunjungan yang masih aktif')
                ->descriptionIcon('heroicon-o-calendar'),
        ];
    }
}
