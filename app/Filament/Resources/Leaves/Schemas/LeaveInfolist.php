<?php

namespace App\Filament\Resources\Leaves\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LeaveInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
           ->components([
                TextEntry::make('employee.name'),
                TextEntry::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state){
                        'cuti' => 'info',
                        'izin' => 'warning',
                }),
                TextEntry::make('start_date')
                    ->date()
                    ->label('Start At'),
                TextEntry::make('end_date')
                    ->date()
                    ->label('End At'),
                TextEntry::make('reason'),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state){
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
            ]);
    }
}
