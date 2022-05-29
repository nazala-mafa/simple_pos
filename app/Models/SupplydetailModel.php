<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplyDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'supply_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['supplies_id', 'product_id', 'quantity', 'buy_price_unit', 'sell_price_unit'];

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
    protected $beforeFind     = ['join_users'];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function join_users() {
        $this->builder()->select('supply_detail.*, products_item.name as product_name')->join('products_item', 'products_item.id = supply_detail.product_id');
    }
}
