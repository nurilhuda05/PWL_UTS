<?php

namespace App\Filament\Resources\Stoks\Schemas;

use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 Select::make('supplier_id')
                    ->label('Supplier')
                    ->options(SupplierModel::pluck('supplier_nama', 'supplier_id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),

                Select::make('barang_id')
                    ->label('Barang')
                    ->options(BarangModel::pluck('barang_nama', 'barang_id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),

                Select::make('user_id')
                    ->label('Staff')
                    ->options(UserModel::pluck('username', 'user_id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),

                DateTimePicker::make('stok_tanggal')
                    ->label('Tanggal Stok Masuk')
                    ->required()
                    ->default(now())
                    ->columnSpanFull(),

                TextInput::make('stok_jumlah')
                    ->label('Jumlah Stok')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->columnSpanFull(),
            ]);
    }
}
