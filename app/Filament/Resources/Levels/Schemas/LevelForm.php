<?php

namespace App\Filament\Resources\Levels\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class LevelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('level_kode')
                    ->label('Kode Level')
                    ->required()
                    ->unique()
                    ->maxLength(10)
                    ->columnSpanFull(),
                    
                TextInput::make('level_nama')
                    ->label('Nama Level')
                    ->required()
                    ->maxLength(100)
                    ->columnSpanFull(),
            ]);
    }
}
