<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\LevelModel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Resources\Pages\CreateRecord;

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
                    ->unique(ignoreRecord: true)
                    ->maxLength(20)
                    ->columnSpanFull(),
                
                TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(50)
                    ->columnSpanFull(),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn($livewire) => $livewire instanceof CreateRecord) //wajib ada saat tambah, tidak wajib saat edit
                    ->dehydrateStateUsing(fn($state) => Hash::make($state)) //mengacak pasword
                    ->columnSpanFull(),
            ]);
    }
}
