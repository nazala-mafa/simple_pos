<?php

namespace App\Controllers\Owner;

use CodeIgniter\RESTful\ResourceController;

class Categories extends ResourceController
{
    protected $modelName = 'App\Models\CategoriesModel';
    protected $format    = 'json';

    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        if( $this->request->getGet('json') ){
            return $this->respond([
                'data' => $this->model
                    ->select('id, name')
                    ->where('user_id', user_id())
                    ->findAll()
            ]);
        }
        $data = [
            'title' => 'Setting Kategori'
        ];
        return view('owner/products/category', $data);
    }
    
    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        if($this->validate([
          'name'    => [
              'rules' => 'required|is_unique[products_category.name]',
              'errors' => [
                  'required' => 'Nama tidak boleh kosong!',
                  'is_unique' => 'Nama sudah digunakan, ganti nama!'
              ]
          ]
        ])){
            $res = $this->model->insert([
                'user_id'   => user_id(),
                'name'      => $this->request->getVar('name'),
            ]);
            return $this->respond( ['status'=> $res] );
        } else {
            return $this->respond( $this->validator->getErrors() );
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
        $res = $this->model->update($id, $this->request->getJSON(1));
        return $this->respond( $res );
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
        $res = $this->model->delete($id);
        return $this->respond($res);
    }
}
