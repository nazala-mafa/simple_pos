<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['pemasukan'] = model( "OrdersModel" )->getTotalByDate();
        $data['total_pemasukan'] = model('OrdersModel')->getTotal();
        $data['pengeluaran'] = model( "SuppliesModel" )->getTotalByDate();
        $data['total_pembelian'] = model( "SuppliesModel" )->getTotal();

        $data['pemasukan_berdasarkan_items'] = model( "ProductsModel" )->getTotalByItems();
        $data['pemasukan_berdasarkan_kategori'] = model( "CategoriesModel" )->getTotalByCategory();
        
        $data = [
            'title' => 'Dashboard',
            'data'  => $data
        ];
        return view('owner/dashboard/index', $data);
    }
}
