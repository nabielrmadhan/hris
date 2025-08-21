<?php

namespace App\Filament\Resources\Leaves\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class LeaveForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                ->relationship(name:'employee', titleAttribute:'name')
                ->preload()
                ->required(),
                Select::make('type')
                ->preload()
                ->options([
                    'cuti' => 'Cuti',
                    'izin' => 'Izin',
                ])
                ->required(),
                DatePicker::make('start_date')
                ->label('Start At')
                ->minDate(now()->addDays(3)->startOfDay())
                ->required(),
                DatePicker::make('end_date')
                ->label('End At')
                ->required(),
                Textarea::make('reason')
                ->required(),
                TextInput::make('duration_days')
                ->numeric()
                ->required()
                ->minValue(1)
                ->label('Duration (Days)'),
            ]);
    }
}
