<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use App\Models\Reminder;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pasien', Patient::count())
                ->description('Jumlah pasien terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Pesan Terkirim', Reminder::where('status', 'sent')->count())
                ->description('Total pesan berhasil dikirim')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Pesan Pending', Reminder::where('status', 'pending')->count())
                ->description('Menunggu jadwal pengiriman')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Pesan Gagal', Reminder::where('status', 'failed')->count())
                ->description('Gagal terkirim')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
