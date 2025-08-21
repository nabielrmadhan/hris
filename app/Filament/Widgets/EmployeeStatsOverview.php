<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class EmployeeStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Employees', User::count())
                ->description('Total number of employees in the system')
                ->icon('heroicon-o-users'),
            Stat::make('Total Department', Department::count())
                ->description('Total number of departments in the system')
                ->icon('heroicon-o-building-office-2'),
        ];
    }
}
