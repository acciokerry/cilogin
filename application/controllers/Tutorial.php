<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tutorial extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $data = [
            'video' => 'test.mp4',
            'title' => 'Tutorial PDF',
            'role' => $this->role
        ];
        $this->load->view('tutorial', $data);
    }
    
}