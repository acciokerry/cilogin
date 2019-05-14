<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('admin');
		$this->load->helper('Role');
		$this->checkLogin();
		$this->role = Role::getRoles($this->session->get_userdata()['role']);
	}

	public function index()
	{
		$this->checkLogin();
	}

	public function checkLogin(){
		if(!$this->admin->logged_id()){
			redirect("login");
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
} 