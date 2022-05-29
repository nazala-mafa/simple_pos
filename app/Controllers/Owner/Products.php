<?php

namespace App\Controllers\Owner;

use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

class Products extends ResourcePresenter
{
    use ResponseTrait;
    protected $modelName = 'App\Models\ProductsModel';

    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        if( $this->request->getGet('json') ) return $this->get_all_products();
        
        $data = [
            'title' => 'Daftar Barang'
        ];

        return view('owner/products/index', $data);
    }
    private function get_all_products() {
        return $this->respond([
            'data' => $this->model->getAll()
        ]);
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
        //
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        if( model('App\Models\SuppliersModel')->get()->getNumRows() == 0 ) {
            session()->setFlashdata('message', 'Pemasok tidak ditemukan, Tambah Pemasok!');
            return redirect()->to('products/suppliers/new');
        }

        $data = [
            'title' => 'Tambah Barang',
            'suppliers' => model('App\Models\SuppliersModel')->where('user_id', user_id())->findAll()
        ];
        return view('owner/products/new', $data);
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        //validate
        if( $this->form_validation() == 'error' ) return redirect()->to('/products/new');
        $image = $this->image_validation( $this->request->getFiles() );
        if( $image == 'error' ) return redirect()->to('/products/new');
        
        //add product
        $req = $this->request->getPost();
        $product_id = $this->model->insert([
            'user_id'       => user_id(),
            'image'         => $image,
            'name'          => $req['name'],
            'status'        => ($req['quantity'] != '0')? 'ready stock': 'draft',
            'buy_price'     => $req['buy_price'],
            'sell_price'    => $req['sell_price'],
            'quantity'      => $req['quantity']
        ]);
        if( isset($req['categories_id']) ) $this->model->addCategories( $product_id , $req['categories_id'] ); 

        //add quantity
        $supply_data = [
            'supplier_id'   => $req['supplier_id'],
            'quantity'      => $req['quantity'],
            'buy_price'     => $req['buy_price'],
            'sell_price'    => $req['sell_price'],
            'amount'        => $req['amount'],
            'paid'          => $req['paid'],
            'status'        => $req['payment_status'],
            'note'          => $req['note']
        ];
        if( $req['quantity'] ){
            $prod_flow = service('products_flow');
            $prod_flow->addInitialSupply($product_id, $supply_data);
        }

        //ret
        session()->setFlashdata('success', 'barang berhasil ditambahkan');
        return redirect()->to('products');
        
    }
    private function form_validation($id=null) {
        if(!$this->validate([
			'name' 		=> [
				'label' => 'nama',
				'rules'	=> "required|is_unique[products_item.name,id,$id]",
				'errors'	=> [
					'required'	=> '{field} tidak boleh kosong',
					'is_unique'	=> '{field} telah digunakan, ganti {field}!'
				]
			],
		    'buy_price' 	=> [
				'label'	=> 'harga beli',
				'rules'	=> 'required',
				'errors'	=> [
					'required' => '{field} tidak boleh kosong'
				]
			],
		    'sell_price' 	=> [
				'label'	=> 'harga jual',
				'rules'	=> 'required',
				'errors'	=> [
					'required' => '{field} tidak boleh kosong'
				]
			],
		])) {
            session()->setFlashdata( 'errors', $this->validator->getErrors() );
            return 'error';
        }
    }
    private function image_validation($imagefile) {

        if(!$imagefile) return;
        $img = $imagefile['image'];

        if( !$img->isValid() ){
            session()->setFlashdata('errors', ['image' => $img->getErrorString().'('.$img->getError().')'] );
            return 'error';
        }

        if( !in_array($img->getClientMimeType(), ['image/png','image/jpg','image/jpeg']) ){
            session()->setFlashdata('errors', ['image' => 'hanya menerima file gambar'] );
            return 'error';
        }

        if ($img->isValid() && ! $img->hasMoved()) {
            $newImageName = $img->getRandomName();
            $img->move(FCPATH.'uploads/imgs/'.user_id().'/products', $newImageName);

            //buat folder u/ nampung img kecil
            if( !model('App\Models\ProductsModel')->getAll() ) {
                mkdir(FCPATH.'uploads/imgs/'.user_id().'/products/150');
                mkdir(FCPATH.'uploads/imgs/'.user_id().'/products/300');
            }
            \Config\Services::image()
                ->withFile(FCPATH.'uploads/imgs/'.user_id().'/products/'.$newImageName)
                ->fit(150, 150, 'center')
                ->save(FCPATH.'uploads/imgs/'.user_id().'/products/150/'.$newImageName);
            \Config\Services::image()
                ->withFile(FCPATH.'uploads/imgs/'.user_id().'/products/'.$newImageName)
                ->fit(300, 300, 'center')
                ->save(FCPATH.'uploads/imgs/'.user_id().'/products/300/'.$newImageName);

            return $newImageName;
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
        $data = [
            'title' => 'Edit Barang',
            'id'    => $id,
            'data'  => $this->model->get_by_id($id)
        ];
        return view('owner/products/edit', $data);
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
        return false;
        //init var
        $req = $this->request->getPost();
        $data = [
            'user_id'       => user_id(),
            'name'          => $req['name'],
            'status'        => $req['status'],
            'buy_price'     => $req['buy_price'],
            'sell_price'    => $req['sell_price'],
            'quantity'      => $req['quantity']
        ];

        //validate
        if( $this->form_validation($id) == 'error' ) return redirect()->to('/products/edit/'.$id);
        $imgFile = $this->request->getFiles();
        if( $imgFile['image']->getError() != 4 ) {
            $image = $this->image_validation( $imgFile );
            if( $image == 'error' ) return redirect()->to('/products/edit/'.$id);
            $data['image'] = $image;
        }

        //update
        $this->model->update($id, $data);
        if( $cats_id = $req['categories_id'] ) $this->model->updateCategories( $id , $cats_id ); 

        //ret
        session()->setFlashdata('success', 'barang berhasil diedit');
        return redirect()->to('products');
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
        $res = $this->model->delete($id);
        return $this->respond($res);
    }
}
