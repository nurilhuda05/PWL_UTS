<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Schemas\Schema;
use App\Models\KategoriModel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('barang_kode')
                    ->label('Kode Barang')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10)
                    ->columnSpanFull(),

                TextInput::make('barang_nama')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(100)
                    ->columnSpanFull(),

                Select::make('kategori_id')
                    ->label('Kategori')
                    ->options(KategoriModel::pluck('kategori_nama', 'kategori_id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),

                TextInput::make('harga_beli')
                    ->label('Harga Beli')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->columnSpanFull(),

                TextInput::make('harga_jual')
                    ->label('Harga Jual')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->columnSpanFull(),
            ]);
    }
}
