<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\PenjualanModel;
use App\Models\SupplierModel;
use App\Models\UserModel;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
             Stat::make('Total Barang', BarangModel::count())
                ->description('Jumlah produk')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('primary')
                ->url(route('filament.admin.resources.barangs.index')),

            Stat::make('Total Stok', StokModel::sum('stok_jumlah'))
                ->description('Stok tersedia')
                ->descriptionIcon('heroicon-o-archive-box')
                ->color('success')
                ->url(route('filament.admin.resources.stoks.index')),

            Stat::make('Total Penjualan', PenjualanModel::count())
                ->description('Transaksi')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('warning')
                ->url(route('filament.admin.resources.penjualans.index')),

            Stat::make('Total Supplier', SupplierModel::count())
                ->description('Pemasok')
                ->descriptionIcon('heroicon-o-truck')
                ->color('danger')
                ->url(route('filament.admin.resources.suppliers.index')),

            Stat::make('Total User', UserModel::count())
                ->description('Karyawan')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info')
                ->url(route('filament.admin.resources.users.index')),
        ];
    }
}
