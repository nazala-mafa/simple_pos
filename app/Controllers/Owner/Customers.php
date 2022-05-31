<?php

namespace App\Controllers\Owner;

use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

class Customers extends ResourcePresenter
{
    use ResponseTrait;
    protected $modelName = 'App\Models\CustomersModel';
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        if( $this->request->getGet('json') ) {
            return $this->respond([ 'data'  => $this->model->where('user_id', user_id())->findAll() ]);
        }

        $data = [
            'title' => 'Daftar Pelanggan'
        ];
        return view('/owner/customers/index', $data);
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
        if( $this->request->getGet('json') ) {
            return $this->respond([ 'data'  => model('App\Models\OrdersModel')->where('customer_id', $id)->findAll() ]);
        }

        $customer = $this->model->find($id);
        $data = [
            'title'     => 'Detail Pelanggan '.$customer['name'],
            'customer'  => $customer
        ];
        return view('owner/customers/show', $data);
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        $data = [
            'title' => 'Tambah Pelanggan'
        ];
        return view('owner/customers/new', $data);
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
        $image = $this->image_validation( $this->request->getFiles() );
        if( $image == 'error' ) return redirect()->to('/products/customers/new');
        
        //insert to db
        $req = $this->request->getPost();
        $req['avatar'] = $image;
        $req['user_id'] = user_id();
        $product_id = $this->model->insert($req);

        session()->setFlashdata('message', 'Pelanggan baru telah ditambahkan');
        return redirect()->to('/products/customers');
    }
    private function image_validation($imagefile, $isUpdate=false) {

        if(!$imagefile) return;
        $img = $imagefile['image'];

        if( !$img->isValid() ){
            if( $isUpdate && $img->getError() == 4 ) { return "no-image"; }
            session()->setFlashdata('errors', ['image' => $img->getErrorString().'('.$img->getError().')'] );
            return 'error';
        }

        if( !in_array($img->getClientMimeType(), ['image/png','image/jpg','image/jpeg']) ){
            session()->setFlashdata('errors', ['image' => 'hanya menerima file gambar'] );
            return 'error';
        }

        if ($img->isValid() && ! $img->hasMoved()) {
            $newImageName = $img->getRandomName();
            $img->move(FCPATH.'uploads/imgs/'.user_id().'/customers', $newImageName);

            //buat folder u/ nampung img kecil
            if( !is_dir(FCPATH.'uploads/imgs/'.user_id().'/customers/150') && !is_dir(mkdir(FCPATH.'uploads/imgs/'.user_id().'/customers/300')) ) {
                mkdir(FCPATH.'uploads/imgs/'.user_id().'/customers/150');
                mkdir(FCPATH.'uploads/imgs/'.user_id().'/customers/300');
            }
            
            \Config\Services::image()
                ->withFile(FCPATH.'uploads/imgs/'.user_id().'/customers/'.$newImageName)
                ->fit(150, 150, 'center')
                ->save(FCPATH.'uploads/imgs/'.user_id().'/customers/150/'.$newImageName);
            \Config\Services::image()
                ->withFile(FCPATH.'uploads/imgs/'.user_id().'/customers/'.$newImageName)
                ->fit(300, 300, 'center')
                ->save(FCPATH.'uploads/imgs/'.user_id().'/customers/300/'.$newImageName);

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
            'title' => 'Edit Customers',
            'data'  => $this->model->find($id),
            'id'    => $id
        ];
        return view('owner/customers/edit', $data);
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
        //get old image name
        $oldImageName = $this->model->find($id)['avatar'];

        //validate
        $image = $this->image_validation( $this->request->getFiles(), true );
        if( $image == 'error' ) return redirect()->to('/products/customers/edit/'.$id);
        
        //insert to db
        $req = $this->request->getPost();
        if( $image != 'no-image' ) $req['avatar'] = $image;
        $req['user_id'] = user_id();
        $product_id = $this->model->save($req);

        if( !$this->model->errors() ){
            if( $image != 'no-image' ) {
                unlink( FCPATH.'uploads/imgs/'.user_id().'/customers/'.$oldImageName );
                unlink( FCPATH.'uploads/imgs/'.user_id().'/customers/150/'.$oldImageName );
                unlink( FCPATH.'uploads/imgs/'.user_id().'/customers/300/'.$oldImageName );
            }

            session()->setFlashdata('message', 'Pelanggan berhasil diubah!');
            return redirect()->to('/products/customers');
        } else {
            session()->setFlashdata('message', $this->model->errors());
            return redirect()->to('/products/customers/edit/'.$id);
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
        $ava = $this->model->find($id)['avatar'];
        unlink(FCPATH.'assets/img/customers/'.$ava);
        $this->model->where([
            'user_id'    => user_id(),
            'id'         => $id
        ])->delete();
        session()->setFlashdata('message', 'Data Berhasil Dihapus');
        return redirect()->to('products/customers');
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

    }
}
