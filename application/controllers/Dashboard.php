<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		if($this->admin->logged_id())
		{
			$data = ['role' => $this->role];
			
			$this->load->view("dashboard", $data);			

		}else{
			//jika session belum terdaftar, maka redirect ke halaman login
			redirect("login");

		}
	}
}
