<?php

namespace App\Models;

use CodeIgniter\Model;

class SuppliesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'supplies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'supplier_id', 'status', 'amount', 'paid', 'note'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function getAllWithSupplierName() {
        return $this->builder()->select('supplies.*, users.username as name, suppliers.name as supplier_name')
            ->join('users', 'users.id = supplies.user_id')
            ->join('suppliers', 'suppliers.id = supplies.supplier_id')
            ->orderBy('supplies.id', 'DESC')->get()->getResultArray();
    }

    function getOneWithSupplierNameById($id) {
        return $this->builder()->select('supplies.*, users.username as name, suppliers.name as supplier_name')
            ->where('supplies.id',$id)
            ->join('users', 'users.id = supplies.user_id')
            ->join('suppliers', 'suppliers.id = supplies.supplier_id')
            ->orderBy('supplies.id', 'DESC')->get()->getRowArray();
    }

    function getTotalByDate() {
        for ($i=1; $i <= (int) date('t'); $i++) { 
            $data[] = 0;
        }
        $pengeluaran = $this
            ->select("SUM(paid) as total, DAY(supplies.created_at) as tanggal")
            ->where("created_at >= '" .date('Y-m-'). "01 00:00:00'")
            ->where("created_at < '" .date('Y-m-t'). " 00:00:00'" )
            ->groupBy("DAY(supplies.created_at);")->get()->getResultArray();
        foreach ($pengeluaran as $p) {
            $data[ (int) $p['tanggal'] - 1 ] = (int)$p['total'];
        }
        return $data;
    }

    function getTotal() {
        return $this
            ->select("SUM(paid) as total")
            ->where("created_at >= '" .date('Y-m-'). "01 00:00:00'")
            ->where("created_at < '" .date('Y-m-t'). " 00:00:00'" )->get()->getResultArray()[0]['total'];
    }
}
