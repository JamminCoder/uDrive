<?php

namespace App\Controllers;

use App\Libraries\Files;

use Symfony\Component\Filesystem\Path;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = "Home Page!";
        $files = Files::dirTree(Path::canonicalize(__DIR__ . '/../../writable/storage'));
        $data['files'] = $files;
        return 
        view('header', $data) 
        . view('home', $data) 
        . view('footer');
    }
}
