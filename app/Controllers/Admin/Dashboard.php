<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // $asd = \Config\Database::connect()->query('SELECT * from migration');
        $pemasukan = model( "OrdersModel" )->getTotal();
        $pengeluaran = model( "SuppliesModel" )->getTotal();
        
        $data = [
            'title' => 'Dashboard',
            'pemasukan' => $pemasukan,
            'pengeluaran'   => $pengeluaran
        ];
        return view('admin/dashboard/index', $data);
    }
}
