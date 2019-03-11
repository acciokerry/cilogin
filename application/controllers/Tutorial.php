<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tutorial extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
    }

    public function index(){
        $this->checkLogin();
        $data = [
            'video' => 'test.mp4',
            'title' => 'Tutorial PDF'
        ];
        $this->load->view('tutorial', $data);
    }

    private function checkLogin(){
		if(!$this->admin->logged_id()){
			redirect("login");
		}
	}
    
}