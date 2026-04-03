<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\ParkirTransaksi;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Kendaraan Masuk (Aktif)', 
                ParkirTransaksi::where('status', 'IN')->count()
            ),

            Stat::make('Total Transaksi Hari Ini', 
                ParkirTransaksi::whereDate('created_at', today())->count()
            ),

            Stat::make('Pendapatan Hari Ini', 
                'Rp ' . number_format(
                    ParkirTransaksi::whereDate('created_at', today())->sum('fee'),
                    0, ',', '.'
                )
            ),
        ];
    }
}