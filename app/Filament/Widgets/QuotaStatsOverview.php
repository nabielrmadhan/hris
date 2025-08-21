<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuotaStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        return [
            Stat::make('Total Quota', $user->quota)
                ->description('The total quota allocated to the user.')
                ->icon('heroicon-o-calendar-days'),
        ];
    }
}
