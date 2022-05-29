<?php

namespace App\Controllers\Owner;

use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

class Supplies extends ResourcePresenter
{
    use ResponseTrait;
    protected $modelName = 'App\Models\SuppliesModel';

    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        if( $this->request->getGet('json') ){
            return $this->respond([ 'data' => $this->model->getAllWithSupplierName() ]);
        }
        $data = [
            'title' => 'Riwayat Barang Masuk'
        ];
        return view('owner/supplies/index', $data);
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
        $supplies = $this->model->getOneWithSupplierNameById($id);
        $supplyDetail = model('App\Models\SupplyDetailModel')->where('supplies_id', $id)->find();
        $data = [
            'title' => 'Detail Barang Masuk',
            'supply_detail' => $supplyDetail,
            'supplies'  => $supplies,
            'id'    => $id
        ];
        return view('owner/supplies/show', $data);
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        $data = [
            'title' => 'Tambah Barang Masuk',
            'suppliers' => model('App\Models\SuppliersModel')->where('user_id', user_id())->findAll()
        ];
        return view('owner/supplies/new', $data);
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
        $prod_flow->addSupply( $req );
        
        session()->setFlashdata('message', 'Data berhasil ditambahkan');
        return redirect()->to('/products/supplies');
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
            return redirect()->to('/products/supplies');
        } else {
            session()->setFlashdata('errors', $this->model->errors());
            return redirect()->to('/products/supplies/update/'.$id);
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
        //
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
