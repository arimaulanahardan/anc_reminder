<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Pasien;

class PatientStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pasien', Pasien::count())
                ->description('Total pasien yang terdaftar')
                ->descriptionIcon('heroicon-o-user'),
        ];
    }
}
