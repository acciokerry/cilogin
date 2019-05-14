<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $params = ["error"=>"",
                    'role' => $this->role];
        $this->load->view("upload",$params);
    }

    public function do_upload(){
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'xls|xlsx';
        $config['max_size']             = 10000;

        $filename = $_FILES['fupload']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        $name = $this->session->get_userdata()['groups'].'_'.time().'.'.$ext;

        $config['file_name']            = $name;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('fupload'))
        {
                $error = array('error' => '<h4 style="color:red">'.$this->upload->display_errors().'</h4>',
                                'role' => $this->role);

                $this->load->view('upload', $error);
        }
        else
        {
                $data = array('error' => '<h4 style="color:green">Your file was successfully uploaded!</h4>',
                            'role' => $this->role);

                $this->load->view('upload', $data);
        }
    }
}