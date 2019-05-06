<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->model('admin');
        $this->load->helper('Role');
    }

	public function index()
	{
		if($this->admin->logged_id())
		{
			$data = ['role' => Role::getRoles($this->session->get_userdata()['role'])];
			
			$this->load->view("dashboard", $data);			

		}else{
			//jika session belum terdaftar, maka redirect ke halaman login
			redirect("login");

		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}

}
