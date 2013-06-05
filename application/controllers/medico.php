<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medico extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('medico_model');
    }
	
	public $json_array_return = array(
        'code' => 441
    );


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
        
        $medico = $this->medico_model->listar_jqgrid($page, $limit, $sidx, $sord, $searchOn, $searchstr);
        echo $medico;
    }
	
	public function listar_especialidades() {

        $aResponse = $this->json_array_return;
        try {
            $a_especialidades= $this->db->select('esp.esp_id, esp.esp_nombre')
                    ->from('especialidades AS esp')
                    ->get()
                    ->result_array();

            $aResponse['data'] = $a_especialidades;
        } catch (Exception $exc) {
            $aResponse['code'] = self::CODE_ERROR;
            $aResponse['msg'] = $exc->getMessage();
        }
        echo json_encode($aResponse);
    }
	
	public function listar_centro_laboral() {

        $aResponse = $this->json_array_return;
        try {
            $a_especialidades= $this->db->select('c_lab.cenl_id, c_lab.cenl_nombre')
                    ->from('centro_laboral AS c_lab')
                    ->get()
                    ->result_array();

            $aResponse['data'] = $a_especialidades;
        } catch (Exception $exc) {
            $aResponse['code'] = self::CODE_ERROR;
            $aResponse['msg'] = $exc->getMessage();
        }
        echo json_encode($aResponse);
    }
	
	public function agregar_medico() {

        $response = $this->json_array_return;

        try {

            $med_nombres = $_POST['med_nombres'];
            $med_ape_paterno= $_POST['med_ape_paterno'];
            $med_ape_materno= $_POST['med_ape_materno'];
			$list_especialidades = $_POST['list_especialidades'];           
            $med_direccion= $_POST['med_direccion'];
            $med_telefono = $_POST['med_telefono'];
			$med_celular= $_POST['med_celular'];
			$med_centro_lab = $_POST['med_centro_lab'];
            

            $medico_id = $_POST['med_id'];

            $data = Array(
                'med_nombres' => $med_nombres,
                'med_apellido_paterno' => $med_ape_paterno,
                'med_apellido_materno' => $med_ape_materno,
                'med_fullname' => $med_nombres . ' ' . $med_ape_paterno . ' ' . $med_ape_materno,
                'med_centro_laboral' => $med_centro_lab,
                'med_telefono' => $med_telefono,
				'med_celular' => $med_celular,
                'med_direccion' => $med_direccion,
                'esp_id' => $list_especialidades,
                'med_estado' => 1
            );
            if ($medico_id != 0) {
                $ver = $this->medico_model->editar_medico($medico_id, $data);
            } else {
                $ver = $this->medico_model->agregar_medico($data);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            throw $e;
        }
        echo json_encode($response);
    }

}