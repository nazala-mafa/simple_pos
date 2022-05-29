<?php

namespace App\Controllers\Owner;

use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

class Suppliers extends ResourcePresenter
{
    use ResponseTrait;
    protected $modelName = 'App\Models\SuppliersModel';
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        if( $this->request->getGet('json') ) {
            return $this->respond([ 'data'  => $this->model->where('user_id', user_id())->findAll() ]);
        }

        $data = [
            'title' => 'Daftar Pemasok'
        ];
        return view('/owner/suppliers/index', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = $this->model->where('user_id', user_id())->find($id);
        $data = [
            'title' => 'Detail Supplier '. $data['name'],
            'data'  => $data
        ];
        return view('/owner/suppliers/show', $data);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data = [
            'title' => 'Tambah Pemasok'
        ];
        return view('owner/suppliers/new', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $req = $this->request->getPost();
        $validate = $this->validate([
            'name'      => [
                "rules"     => "required|is_unique[suppliers.name]",
                'errors'    => [
                    'required'  =>  'Nama tidak boleh kosong',
                    'is_unique' =>  'Nama sudah digunakan',
                ]
            ],
            'phone'     => 'required|is_unique[suppliers.phone]',
            'address'   => 'required|is_unique[suppliers.address]',
            'status'    => 'required',
        ]);

        if( $validate ) {
            $req['user_id'] = user_id();
            $this->model->insert( $req );
            session()->setFlashdata('message', 'Data berhasil ditambahkan');
            return redirect()->to('/products/suppliers');
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to('/products/suppliers/create');
        }     
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $data = [
            'title' => 'Edit Pemasok',
            'data'  => $this->model->find($id),
            'id'    => $id
        ];

        return view('owner/suppliers/edit', $data);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $req = $this->request->getPost();
        $validate = $this->validate([
            "name"      => [
                "rules"     => "required|is_unique[suppliers.name,id,$id]",
                "errors"    => [
                    "required"  =>  "Nama tidak boleh kosong",
                    "is_unique" =>  "Nama sudah digunakan",
                ]
            ],
            "phone"     => "required|is_unique[suppliers.phone,id,$id]",
            "address"   => "required|is_unique[suppliers.address,id,$id]",
            "status"    => "required",
        ]);

        if( $validate ) {
            $req['user_id'] = user_id();
            $this->model->save( $req );
            session()->setFlashdata('message', 'data berhasil diupdate!');
            return redirect()->to('/products/suppliers');
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to('/products/suppliers/edit/'.$id);
        } 
    }

    public function remove($id = null) 
    {
        $this->model->where([
            'user_id'   => user_id(),
            'id'        => $id
        ])->delete();
        session()->setFlashdata('message', 'Data berhasil dihapus');
        return redirect()->to('/products/suppliers');
    }
}
