<?php

namespace App\Filament\Resources\Leaves\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;

class LeavesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label('Employee Name')
                    ->sortable()
                    ->searchable()
                    ->visible(fn () => !auth()->user()->hasRole(['employee'])),
                TextColumn::make('employee.quota')
                    ->label('Quota'),
                TextColumn::make('employee.department.name'),
                BadgeColumn::make('type')
                    ->colors([
                        'info' => 'cuti',
                        'warning' => 'izin',
                    ]),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable()
                    ->label('Start At'),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->label('End At'),
                TextColumn::make('reason')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->reason),
                BadgeColumn::make('status')
                    ->colors([
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
