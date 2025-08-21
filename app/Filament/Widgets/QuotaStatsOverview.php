<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User; 

class QuotaStatsOverview extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return auth()->user()->hasRole(['Employee', 'HR']);
    }
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
