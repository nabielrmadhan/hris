<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use PhpParser\Node\Stmt\Label;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('nik'),
                TextEntry::make('department.name')
                    ->label('Department'),
                TextEntry::make('address'),
                TextEntry::make('phone'),
                TextEntry::make('status'),
                TextEntry::make('starts_work_at'),
                TextEntry::make('salary'),
                TextEntry::make('quota'),
            ]);
    }
}
