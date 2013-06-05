<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paciente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Paciente_model');
    }

//    public function index() {
//        $this->load->view('template/header');
//        $this->load->view('template/menu');
//        $this->load->view('paciente/index');
//    }

    public function listar() {
        $page = $this->input->post('page');
        $limit = $this->input->post('rows');
        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');
        $paciente = $this->Paciente_model->listar_jqgrid($page, $limit, $sidx, $sord);
        echo $paciente;
    }

}