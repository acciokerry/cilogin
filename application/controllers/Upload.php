<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin");
    }

    public function index(){
        $this->checkLogin();
        $params = ["error"=>""];
        $this->load->view("upload",$params);
    }

    public function do_upload(){
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 10000;

        $name = $this->session->get_userdata()['groups'].'_'.time().'.pdf';

        $config['file_name']            = $name;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('fupload'))
        {
                $error = array('error' => '<h4 style="color:red">'.$this->upload->display_errors().'</h4>');

                $this->load->view('upload', $error);
        }
        else
        {
                $data = array('error' => '<h4 style="color:green">Your file was successfully uploaded!</h4>');

                $this->load->view('upload', $data);
        }
    }

    private function checkLogin(){
		if(!$this->admin->logged_id()){
			redirect("login");
		}
	}
}