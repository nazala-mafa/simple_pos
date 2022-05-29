<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Profile extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Setting Profile'
        ];
        return view('all/profile/index', $data);
    }

    public function update()
    {
        $db = model('Myth\Auth\Model\UserModel');
        $req = $this->request->getPost();

        $data = [
            'id'        => user_id(),
            'username'  => $req['username'],
            'email'     => $req['email']
        ];

        if ( isset($req['password']) ) {
            if ( $req['password'] !== $req['password_confirm'] ) {
                session()->setFlashdata('error', 'Password tidak valid!');
                return redirect()->to("/profile");
            } else {
                user()->setPassword( $req['password'] );
                $data['password_hash'] = user()->toArray()['password_hash'];
            }
        }

        $res = $db->update( user_id(), $data );
        session()->setFlashdata('message', 'User berhasil diupdate!');
        return redirect()->to("/profile");
    }
}