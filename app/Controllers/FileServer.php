<?php

namespace App\Controllers;

class FileServer extends BaseController {
    public function show($path=false) {
        $path = join('/', func_get_args());
        $files = \App\Libraries\Files::ls($path);
        $data['files'] = $files;
        $data['title'] = 'Files';
        return 
        view('header', $data) 
        . view('home', $data) 
        . view('footer');
    }
};