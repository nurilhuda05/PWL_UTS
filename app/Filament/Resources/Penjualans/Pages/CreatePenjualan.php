<?php

namespace App\Filament\Resources\Penjualans\Pages;

use App\Filament\Resources\Penjualans\PenjualanResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\StokModel;

class CreatePenjualan extends CreateRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function getFormActions(): array
    {
        return [];
    }

    protected function afterCreate(): void
    {
        $penjualan = $this->record;

        foreach ($penjualan->detail as $detail) {
            $barangId = $detail->barang_id;
            $jumlahTerjual = $detail->jumlah;

            // Kurangi stok pertama yang ditemukan
            $stok = StokModel::where('barang_id', $barangId)
                ->where('stok_jumlah', '>', 0)
                ->first();

            if ($stok) {
                $stok->stok_jumlah -= $jumlahTerjual;
                if ($stok->stok_jumlah < 0) $stok->stok_jumlah = 0;
                $stok->save();
            }
        }
    }
}
