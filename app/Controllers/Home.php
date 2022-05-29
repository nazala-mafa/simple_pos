<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        if( in_groups('admin') ) return redirect()->to('admin');
        if( in_groups('owner') ) return redirect()->to('owner/dashboard');
    }
}
