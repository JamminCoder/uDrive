<?php

namespace App\Controllers;

use App\Libraries\Files;

use Symfony\Component\Filesystem\Path;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = "Home Page!";
        $files = Files::ls();
        $data['files'] = $files;
        return 
        view('header', $data) 
        . view('home', $data) 
        . view('footer');
    }
}
