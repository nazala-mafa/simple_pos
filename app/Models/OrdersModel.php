<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'customer_id', 'status', 'amount', 'paid', 'note'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'status'    => 'required',
        'amount'    => 'required|decimal',
        'paid'      => 'required|decimal',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    function findAllWidthCustomerName() {
        $this->builder()->select('orders.*, customers.name as customer_name')->join('customers', 'customers.id = orders.customer_id');
    }
    function findOneWidthCustomerName($id) {
        return $this->builder()->select('orders.*, customers.name as customer_name')->where('orders.id', $id)->join('customers', 'customers.id = orders.customer_id')->get()->getRowArray();
    }

    // # === Chart === #
    //uang masuk berdasarkan tanggal
    function getTotalByDate() {
        for ($i=1; $i <= (int) date('t'); $i++) { 
            $data[] = 0;
        }
        $pemasukan = $this
            ->select("SUM(paid) as total, DAY(orders.created_at) as tanggal")
            ->where("created_at >= '" .date('Y-m-'). "01 00:00:00'")
            ->where("created_at < '" .date('Y-m-t'). " 00:00:00'" )
            ->groupBy("DAY(orders.created_at);")->get()->getResultArray();
        foreach ($pemasukan as $p) {
            $data[ (int) $p['tanggal'] - 1 ] = (int)$p['total'];
        }
        return $data;
    }
    function getSellingCategories() {} 
    
    //uang masuk keseluruhan
    function getTotal() {
        return $this
            ->select("SUM(paid) as total")
            ->where("created_at >= '" .date('Y-m-'). "01 00:00:00'")
            ->where("created_at < '" .date('Y-m-t'). " 00:00:00'" )
            ->get()->getResultArray()[0]['total'];
    }
}
