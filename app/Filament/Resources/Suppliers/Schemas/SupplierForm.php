<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('supplier_kode')
                    ->label('Kode Supplier')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10)
                    ->columnSpanFull(),

                TextInput::make('supplier_nama')
                    ->label('Nama Supplier')
                    ->required()
                    ->maxLength(100)
                    ->columnSpanFull(),

                Textarea::make('supplier_alamat')
                    ->label('Alamat')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
