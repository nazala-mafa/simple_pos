<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table            = 'products_item';
    protected $useSoftDeletes   = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['name', 'image', 'quantity', 'status', 'buy_price', 'sell_price', 'sold', 'user_id'];

    function getAll() {
        $datas = $this->where('products_item.user_id', user_id())
        ->select('products_item.*, products_category.name as category')
        ->join('products_item_category', 'products_item_category.product_item_id = products_item.id', 'LEFT')
        ->join('products_category', 'products_item_category.product_category_id = products_category.id', 'LEFT')
        ->orderBy('id','DESC')
        ->findAll();
        
        $final = [];
        foreach($datas as $data){
            if( isset($final[$data['id']]) ) {
                array_push( $final[$data['id']]['categories'], $data['category'] );
            } else {
                $data['categories'] = [ $data['category'] ];
                $final[$data['id']] = $data;
                unset( $final['category'] );
            }
        }

        return array_values($final);
    }

    function get_by_id($id) {
        $product = $this->find($id);
        $categories = $this->db->table('products_item_category as pic')
            ->select('pic.product_category_id')
            ->where('pic.product_item_id', $id)
            ->get()->getResultArray();
        foreach( $categories as $cat ){
            $product['categories'][] = $cat['product_category_id'];
        }
        return $product;
    }

    function addCategories( $prodId, $catIds ) {
        $data = [];
        foreach( $catIds as $id ) {
            $data[] = [
                'product_item_id'       => $prodId,
                'product_category_id'   => $id
            ];
        }
        return $this->db->table('products_item_category')->insertBatch( $data );
    }

    function updateCategories( $prodId, $catIds ) {
        $builder = $this->db->table('products_item_category');
        $builder->where('product_item_id', $prodId)->delete();
        $data = [];
        foreach( $catIds as $id ) {
            $data[] = [
                'product_item_id'       => $prodId,
                'product_category_id'   => $id
            ];
        }
        return $builder->insertBatch( $data );
    }

    //uang masuk berdasarkan item produk
    function getTotalByItems() {
        $res = $this->select('orders.id')
        ->where("orders.created_at >= '" .date('Y-m-'). "01 00:00:00'")
        ->where("orders.created_at < '" .date('Y-m-t'). " 00:00:00'" )
        ->groupBy('orders.id')->from('orders')->findAll();
        $order_ids = [];
        foreach($res as $d){ $order_ids[] = $d['id']; }
        
        $res = $this
            ->select('name, SUM((od.quantity*od.price_unit)) as total')
            ->join('order_detail as od', 'od.product_id = products_item.id')
            ->where('user_id', user_id())
            ->whereIn('od.order_id', $order_ids)
            ->groupBy('name')
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