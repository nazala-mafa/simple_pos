<?php

namespace App\Controllers\Owner;

use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

class Orders extends ResourcePresenter
{
    use ResponseTrait;
    protected $modelName = 'App\Models\OrdersModel';
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        if( $this->request->getGet('json') ) {
            return $this->respond([ 'data' => $this->model->where('orders.user_id', user_id())->orderBy('created_at', 'DESC')->findAll() ]);
        }

        $data = [
            'title' => 'Daftar Penjualan'
        ];
        return view('owner/orders/index', $data);
    }

    /**
     * Present a view to present a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $orders = $this->model->findOneWidthCustomerName($id);
        // dd( $orders );
        $orderDetail = model('App\Models\OrderdetailModel')->where('order_id', $id)->findAll();
        $data = [
            'title' => 'Detail Barang Penjualan',
            'order_detail' => $orderDetail,
            'pelanggan'  => $orders,
            'id'    => $id
        ];
        return view('owner/orders/show', $data);
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        if( model('App\Models\CustomersModel')->get()->getNumRows() == 0 ) {
            session()->setFlashdata('message', 'Pelanggan Tidak ditemukan, Tambah Pelanggan!');
            return redirect()->to('products/customers/new');
        }

        if( $this->request->getGet('sc') ) {
            $data = [
                'title' => 'Pilih Pelanggan',
                'customers' => model('App\Models\CustomersModel')->findAll()
            ];
            return view('owner/orders/select_customers', $data);
        }
        
        $data = [
            'title' => 'Tambah Penjualan',
            'customer'  => model('App\Models\CustomersModel')->find( $this->request->getGet('c_id') )
        ];
        return view('owner/orders/new', $data);
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        $req = $this->request->getPost();
        $prod_flow = service('products_flow');
        $res = $prod_flow->addOrders( $req );
        if( $res == 'error' ) {
            return redirect()->to('/products/orders');
        } else {
            session()->setFlashdata('message', 'Pesanan berhasil ditambahkan');
            return redirect()->to('/products/orders');
        }
    }

    /**
     * Present a view to edit the properties of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Process the updating, full or partial, of a specific resource object.
     * This should be a POST.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $req = $this->request->getPost();
        $req['amount'] = (int) str_replace('.', '', $req['amount']);
        $req['paid'] = (int) str_replace('.', '', $req['paid']);
        $this->model->save( $req );
        if( !$this->model->errors() ){
            session()->setFlashdata('message', 'data telah terupdate');
            return redirect()->to('/products/orders');
        } else {
            session()->setFlashdata('errors', $this->model->errors());
            return redirect()->to('/products/orders/update/'.$id);
        }
    }

    /**
     * Present a view to confirm the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function remove($id = null)
    {
        $prod_flow = service('products_flow');
        $order = $prod_flow->deleteOrder( $id );
        $order->where('orders.id', $id)->delete();
        session()->setFlashdata('message', 'Data penjualan telah terhapus');
        return redirect()->to('/products/orders');
    }

    /**
     * Process the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
