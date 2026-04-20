<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\PenjualanModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use App\Models\PenjualanDetailModel;


class StatsOverview extends StatsOverviewWidget
{
    protected function getColumns(): int
    {
        return 4;
    }
    protected function getStats(): array
    {
        $totalOmzet = PenjualanDetailModel::sum(DB::raw('harga * jumlah'));

        $totalKeuntungan = PenjualanDetailModel::join('m_barang', 't_penjualan_detail.barang_id', '=', 'm_barang.barang_id')
            ->sum(DB::raw('(t_penjualan_detail.harga - m_barang.harga_beli) * t_penjualan_detail.jumlah'));

        $totalBarangTerjual = PenjualanDetailModel::sum('jumlah');
        return [
            Stat::make('Total Omzet', 'Rp ' . number_format($totalOmzet, 0, ',', '.'))
                ->description('Pendapatan kotor')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success')
                ->url(route('filament.admin.resources.penjualans.index')),

            Stat::make('Total Keuntungan', 'Rp ' . number_format($totalKeuntungan, 0, ',', '.'))
                ->description('Laba bersih')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('primary')
                ->url(route('filament.admin.resources.penjualans.index')),

            Stat::make('Total Transaksi', PenjualanModel::count())
                ->description('Transaksi')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('warning')
                ->url(route('filament.admin.resources.penjualans.index')),

            Stat::make('Total Barang Terjual', $totalBarangTerjual)
                ->description('Barang terjual')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('warning')
                ->url(route('filament.admin.resources.penjualans.index')),

            Stat::make('Total Stok', StokModel::sum('stok_jumlah'))
                ->description('Stok tersedia')
                ->descriptionIcon('heroicon-o-archive-box')
                ->color('success')
                ->url(route('filament.admin.resources.stoks.index')),
            Stat::make('Total Produk', BarangModel::count())
                ->description('Jenis barang tersedia  ')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('primary')
                ->url(route('filament.admin.resources.barangs.index')),

            Stat::make('Total Supplier', SupplierModel::count())
                ->description('Pemasok')
                ->descriptionIcon('heroicon-o-truck')
                ->color('danger')
                ->url(route('filament.admin.resources.suppliers.index')),

            Stat::make('Total User', UserModel::count())
                ->description('Staff')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info')
                ->url(route('filament.admin.resources.users.index')),
        ];
    }
}
