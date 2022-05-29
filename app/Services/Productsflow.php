<?php namespace App\Services;

class ProductsFlow
{
  function addInitialSupply($product_id, $data){
    $sm_id = model('App\Models\SuppliesModel')->insert([
      'user_id'   => user_id(),
      'supplier_id'   => $data['supplier_id'],
      'status'    => $data['status'],
      'amount'    => $data['amount'],
      'paid'      => $data['paid'],
      'note'      => $data['note']
    ]);

    model("App\Models\SupplyDetailModel")->insert([
      'supplies_id' => $sm_id,
      'product_id'  => $product_id,
      'quantity'    => $data['quantity'],
      'buy_price_unit'  => $data['buy_price'],
      'sell_price_unit' => $data['sell_price']
    ]);
  }

  function addSupply($req) {
    //insert supplies
    $suppliesId = model('App\Models\SuppliesModel')->insert([
      'user_id'   => user_id(),
      'supplier_id'   => $req['supplier_id'],
      'status'    => $req['status'],
      'amount'    => $req['amount'],
      'paid'      => $req['paid'],
      'note'      => $req['note']
    ]);

    //pre insert supply_detail & update products_item
    foreach( $req['supply_detail'] as $sd) {
      $sd['supplies_id'] = $suppliesId;
      $batchCreateSupplyDetail[] = $sd;
      $productsId[] = $sd['product_id'];
    }

    //insert products_item
    model("App\Models\SupplyDetailModel")->insertBatch( $batchCreateSupplyDetail );

    //update products_item
    $sd = $req['supply_detail'];
    $products = model('App\Models\ProductsModel')->select('id, quantity')->find( $productsId );
    foreach( $products as &$p ) {
      $p['buy_price'] = $sd[ $p['id'] ]['buy_price_unit'];
      $p['sell_price'] = $sd[ $p['id'] ]['sell_price_unit'];
      $p['quantity'] = (int) $p['quantity'] + (int) $sd[ $p['id'] ]['quantity'];
      $p['status'] = 'ready stock';
    }
    model('App\Models\ProductsModel')->updateBatch($products, 'id');
  }

  function addOrders($req){
    
    //kurangi kuantitas produk
    foreach( $req['order_detail'] as $p ){
      $products_id[] = $p['product_id'];
    }
    $products = model('App\Models\ProductsModel')
      ->select('id, name, quantity')
      ->whereIn( 'id', $products_id )
      ->findAll();
    foreach( $products as &$p ) {
      //kurangi kauntitas
      $p['quantity'] = (int) $p['quantity'] - (int) $req['order_detail'][ $p['id'] ]['quantity'];
      //ubah status ke sold out jika kuantitas = 0
      if( $p['quantity'] == 0 ) $p['status']  = 'sold out';
      //cek  apakah melebihi stock
      if( $p['quantity'] < 0 ) {
        session()->setFlashdata('error', 'Error, produk yang diminta melebihi stok yang tersedia');
        return 'error';
      }
    }
    model('App\Models\ProductsModel')->updateBatch( $products, 'id' );

    //insert to orders
    $order_id = model('App\Models\OrdersModel')->insert([
      'user_id'     => user_id(),
      'customer_id' => $req['customer_id'],
      'status'      => $req['status'],
      'amount'      => $req['amount'],
      'paid'        => $req['paid'],
      'note'        => $req['note']
    ]);

    //insert to order_detail
    foreach( $req['order_detail'] as $p ){
      $products_data[] = [
        'order_id'    =>  $order_id,
        'product_id'  =>  $p['product_id'],
        'quantity'    =>  $p['quantity'],
        'price_unit'  =>  $p['sell_price_unit'],
        'note'        =>  $p['note']
      ];
    }

    //insert order_detail dan kembalikan
    return model('App\Models\OrderdetailModel')->insertBatch( $products_data );
  }

  function deleteOrder($id){
    //get data order
    $order = model('OrdersModel')->where([
      'orders.user_id'   => user_id(),
      'orders.id'        => $id
    ]);
    $orderId = $order->find()[0]['id'];
    //get datas order_detail
    $prods = model('OrderdetailModel')->where('order_id', $orderId)->findAll();
    foreach( $prods as $p ){
        $prodsId[] = $p['product_id'];
        $delProd[ $p['product_id'] ] = $p['quantity'];
    }
    //update product_item data
    $prodsItem = model('ProductsModel')
        ->select('id, quantity')
        ->whereIn('id', $prodsId)->findAll();
    foreach($prodsItem as &$p){
        $p['quantity'] = (int) $p['quantity'] + (int) $delProd[ $p['id'] ];
    }
    model('ProductsModel')->updateBatch( $prodsItem, 'id' );

    return $order;
  }
}