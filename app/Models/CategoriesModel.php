<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table            = 'products_category';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id','name'];

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

    //uang masuk berdasarkan kategori produk
    function getTotalByCategory() {
        $res = $this->select('orders.id')
        ->where("orders.created_at >= '" .date('Y-m-'). "01 00:00:00'")
        ->where("orders.created_at < '" .date('Y-m-t'). " 00:00:00'" )
        ->groupBy('orders.id')->from('orders')->findAll();
        $order_ids = [];
        foreach($res as $d){ $order_ids[] = $d['id']; }

        $res = $this
            ->select('products_category.name, SUM((od.quantity*od.price_unit)) as total')
            ->join('products_item_category as pic', 'pic.product_category_id = products_category.id')
            ->join('products_item as pi', 'pi.id = pic.product_item_id')
            ->join('order_detail as od', 'od.product_id = pi.id')
            ->where('products_category.user_id', user_id())
            ->whereIn('od.order_id', $order_ids)
            ->groupBy('products_category.name')
            ->get()->getResultArray();
        $data = [ 'names' => [], 'totals' => [], 'total' => 0 ];
        foreach($res as $d){
            $data['names'][] = $d['name'];
            $data['totals'][] = $d['total'];
            $data['total'] = $data['total'] + (int)$d['total'];
        }
        return $data;
    }
}
