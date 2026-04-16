<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\LevelModel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 Select::make('level_id')
                    ->label('Level')
                    ->options(LevelModel::all()->pluck('level_nama', 'level_id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),

                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->unique()
                    ->maxLength(20)
                    ->columnSpanFull(),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->columnSpanFull(),
            ]);
    }
}
