<?php

namespace App\Filament\Resources\Penjualans\Schemas;

use App\Models\BarangModel;
use App\Models\UserModel;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PenjualanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Data Penjualan')
                        ->description('Isi informasi transaksi')
                        ->icon('heroicon-o-shopping-cart')
                        ->schema([
                            Select::make('user_id')
                                ->label('Staff')
                                ->options(UserModel::pluck('username', 'user_id'))
                                ->required()
                                ->searchable()
                                ->preload()
                                ->columnSpanFull(),

                            TextInput::make('pembeli')
                                ->label('Nama Pembeli')
                                ->required()
                                ->maxLength(50)
                                ->columnSpanFull(),

                            TextInput::make('penjualan_kode')
                                ->label('Kode Penjualan')
                                ->required()
                                ->default('INV-' . date('Ymd') . '-' . Str::random(4))
                                ->unique(ignoreRecord: true)
                                ->maxLength(20)
                                ->columnSpanFull(),

                            DateTimePicker::make('penjualan_tanggal')
                                ->label('Tanggal Penjualan')
                                ->required()
                                ->default(now())
                                ->columnSpanFull(),
                        ]),

                    Step::make('Detail Barang')
                        ->description('Pilih barang yang dijual')
                        ->icon('heroicon-o-list-bullet')
                        ->schema([
                            Repeater::make('detail')
                                ->label('Daftar Barang')
                                ->relationship('detail')
                                ->schema([
                                    Select::make('barang_id')
                                        ->label('Barang')
                                        ->options(BarangModel::pluck('barang_nama', 'barang_id'))
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->distinct()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->columnSpan(2)
                                        ->afterStateUpdated(function ($state, $set, $get) {
                                            if ($state) {
                                                $barang = BarangModel::find($state);
                                                if ($barang) {
                                                    $set('harga', $barang->harga_jual);
                                                }
                                            }
                                        }),

                                    TextInput::make('harga')
                                        ->label('Harga')
                                        ->required()
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->readOnly()
                                        ->columnSpan(1),

                                    TextInput::make('jumlah')
                                        ->label('Jumlah')
                                        ->required()
                                        ->numeric()
                                        ->minValue(1)
                                        ->default(1)
                                        ->columnSpan(1)
                                        ->rules([
                                            function ($get) {
                                                return function ($attribute, $value, $fail) use ($get) {
                                                    $barangId = $get('barang_id');
                                                    if ($barangId) {
                                                        $totalStok = \App\Models\StokModel::where('barang_id', $barangId)->sum('stok_jumlah');
                                                        if ($value > $totalStok) {
                                                            $fail("Stok tidak cukup! Stok hanya Tersedia: {$totalStok}");
                                                        }
                                                    }
                                                };
                                            },
                                        ]),
                                ])
                                ->columns(4)
                                ->addActionLabel('Tambah Barang')
                                ->reorderable(false)
                                ->collapsible()
                                ->columnSpanFull(),
                        ]),
                ])
                    ->columnSpanFull()
                    ->submitAction(
                        \Filament\Actions\Action::make('save')
                            ->label('Simpan Penjualan')
                            ->color('primary')
                            ->submit('save')
                    ),
            ]);
    }
}
