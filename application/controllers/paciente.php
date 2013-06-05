<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paciente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('paciente_model');
    }

    public $json_array_return = array(
        'code' => 441
    );

    public function index() {
        $this->load->view('template/header');
        $this->load->view('paciente/index');
    }

    public function listar() {
        $page = $this->input->post('page');
        $limit = $this->input->post('rows');
        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');
        $searchOn = $this->input->post('_search');

        if ($searchOn == 'true') {
            $searchOn = true;
        } else {
            if ($searchOn == 'false')
                $searchOn = false;
        }

        $searchstr = "";

        $searchstr = $this->input->post('filters');

        $paciente = $this->paciente_model->listar_jqgrid($page, $limit, $sidx, $sord, $searchOn, $searchstr);
        echo $paciente;
    }

    public function agregar_paciente() {

        $response = $this->json_array_return;

        try {

            $pac_nombres = $_POST['pac_nombres'];
            $pac_ape_paterno = $_POST['pac_ape_paterno'];
            $pac_ape_materno = $_POST['pac_ape_materno'];
            $pac_edad = $_POST['pac_edad'];
            $pac_telefono = $_POST['pac_telefono'];
            $pac_direccion = $_POST['pac_direccion'];
            $pac_ciudad = $_POST['list_ciudades'];

            $paciente_id = $_POST['pac_id'];

            $data = Array(
                'pac_nombres' => $pac_nombres,
                'pac_apellido_paterno' => $pac_ape_paterno,
                'pac_apellido_materno' => $pac_ape_materno,
                'pac_fullname' => $pac_ape_paterno . ' ' . $pac_ape_materno. ' ' .$pac_nombres  ,
                'pac_edad' => $pac_edad,
                'pac_telefono' => $pac_telefono,
                'pac_direccion' => $pac_direccion,
                'ciu_id' => $pac_ciudad,
                'pac_estado' => 1
            );
            if ($paciente_id != 0) {
                $ver = $this->paciente_model->editar_paciente($paciente_id, $data);
            } else {
                $ver = $this->paciente_model->agregar_paciente($data);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            throw $e;
        }
        echo json_encode($response);
    }

    public function listar_ciudades() {

        $aResponse = $this->json_array_return;
        try {
            $a_ciudades = $this->db->select('ciu.ciu_id, ciu.ciu_nombre')
                    ->from('ciudades AS ciu')
                    ->get()
                    ->result_array();

            $aResponse['data'] = $a_ciudades;
        } catch (Exception $exc) {
            $aResponse['code'] = self::CODE_ERROR;
            $aResponse['msg'] = $exc->getMessage();
        }
        echo json_encode($aResponse);
    }

    public function retornar_pacientexId() {

        $aResponse = $this->json_array_return;
        try {
            $i_pacientes = $this->input->post('idi');

            $pacientes = $this->db->select('*')
                            ->from('pacientes AS pa')
                            ->where('pa.pac_id = ' . "$i_pacientes")
                            ->order_by('pa.pac_id', 'ASC')
                            ->get()->row_array();

            //$query = $this->db->get();
            //print_r($this->db->last_query());
            //die();

            $aResponse['data'] = $pacientes;
        } catch (Database_Exception $exc) {
            //$aResponse['code'] = self::CODE_ERROR;
            $aResponse['msg'] = $exc->getMessage();
        }
        echo json_encode($aResponse);
    }

    public function eliminar_paciente() {
        $aResponse = $this->json_array_return;
        try {
            $pac_id = $_POST['idi'];
            $estado = 0;

            $data = Array(
                'pac_estado' => $estado
            );
            $ver = $this->paciente_model->editar_paciente($pac_id, $data);
        } catch (Exception $exc) {
            echo $exc;
        }
        echo json_encode($aResponse);
    }

}