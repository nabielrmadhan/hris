<?php

namespace App\Filament\Resources\Leaves;

use App\Filament\Resources\Leaves\Pages\CreateLeave;
use App\Filament\Resources\Leaves\Pages\EditLeave;
use App\Filament\Resources\Leaves\Pages\ListLeaves;
use App\Filament\Resources\Leaves\Pages\ViewLeave;
use App\Filament\Resources\Leaves\Schemas\LeaveForm;
use App\Filament\Resources\Leaves\Schemas\LeaveInfolist;
use App\Filament\Resources\Leaves\Tables\LeavesTable;
use App\Models\Leave;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use GuzzleHttp\Psr7\Query;
use function Laravel\Prompts\search;
use Illuminate\Database\Eloquent\Builder;

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return LeaveForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LeaveInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        $table = LeavesTable::configure($table);
        return $table
        ->actions([
            EditAction::make(),

            Action::make('approve')
                ->label('Approve')
                ->action(function ($record){
                    $record->update(['status' => 'approved']);
                })
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->visible(fn ($record) => $record->status === 'pending' && auth()->user()->hasRole(['super_admin', 'HR'])),

            Action::make('rejected')
                ->label('Reject')
                ->action(function ($record){
                    $record->update(['status' => 'rejected']);
                })
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->visible(fn ($record) => $record->status === 'pending' && auth()->user()->hasRole(['super_admin', 'HR'])),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->hasRole('HR')) {
            $hrDepartmentId = $user->department_id;
            
            return $query->whereHas('employee', function(Builder $query) use ($hrDepartmentId) {
                $query->where('department_id', $hrDepartmentId);
            });
        }

        if ($user->hasRole('Employee')) {
            return $query->where('employee_id', $user->id);
        }

        return $query; 
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeaves::route('/'),
            'create' => CreateLeave::route('/create'),
            'view' => ViewLeave::route('/{record}'),
            'edit' => EditLeave::route('/{record}/edit'),
        ];
    }
}
