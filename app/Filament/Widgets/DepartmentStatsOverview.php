<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Leave;


class DepartmentStatsOverview extends StatsOverviewWidget
{

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['HR', 'super_admin']);
    }

    protected function getStats(): array
    {
        $user = auth()->user();

        $requestsQuery = Leave::query();
        $userQuery = User::query();

        $titlePrefix = 'All Department'; 
        $descriptionPrefix = 'Overview of all department statistics';

        if ($user->hasRole('HR')) {
            $departmentId = $user->department_id;
            $departmentName = $user->department->name ?? 'Anda';

            $requestsQuery->whereHas('employee', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });

            $userQuery->where('department_id', $departmentId);

            $titlePrefix = 'Department: ' . $departmentName;
            $descriptionPrefix = 'Employee at your department';
        }

        return [
            Stat::make('Total Employees', $userQuery->count())
                ->description($descriptionPrefix)
                ->icon('heroicon-s-users'),
                
            Stat::make('Total Requests', $requestsQuery->clone()->count())
                ->description($titlePrefix)
                ->icon('heroicon-o-document-text'),

            Stat::make('Pending', $requestsQuery->clone()->where('status', 'pending')->count())
                ->description($titlePrefix)
                ->color('warning')
                ->icon('heroicon-o-clock'),
            
            Stat::make('Approved', $requestsQuery->clone()->where('status', 'approved')->count())
                ->description('Request Approved')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Rejected', $requestsQuery->clone()->where('status', 'rejected')->count())
                ->description('Request Rejected')
                ->color('danger')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
