<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Examen extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Registerexamen_model');
        $this->load->model('Resultados_examen_model');
    }

    public $json_array_return = array(
        'code' => 441
    );

    public function listar_pacintes() {

        $aResponse = $this->json_array_return;
        try {

            $dato = $this->input->post('term');
            $a_pacientes = $this->db->select('pac.pac_id, pac.pac_fullname')
                    ->from('pacientes AS pac')
                    ->like('pac.pac_fullname', $dato, 'both')
                    ->get()
                    ->result_array();

            $aResponse['data'] = $a_pacientes;
        } catch (Exception $exc) {
            $aResponse['code'] = self::CODE_ERROR;
            $aResponse['msg'] = $exc->getMessage();
        }
        echo json_encode($aResponse);
    }

    public function listar_medicos() {

        $aResponse = $this->json_array_return;
        try {

            $dato = $this->input->post('term');
            $a_medicos = $this->db->select('med.med_id, med.med_fullname')
                    ->from('medicos AS med')
                    ->like('med.med_fullname', $dato, 'both')
                    ->get()
                    ->result_array();

            $aResponse['data'] = $a_medicos;
        } catch (Exception $exc) {
            $aResponse['code'] = self::CODE_ERROR;
            $aResponse['msg'] = $exc->getMessage();
        }
        echo json_encode($aResponse);
    }

    public function listar_indicadoresxtipoexamen() {

        $aResponse = $this->json_array_return;
        try {

            $dato = $this->input->post('idTipoExamen');
            $dato = 1;
            $a_medicos = $this->db->select('ind.ind_id, ind.ind_descripcion,ind.ind_precio')
                    ->from('indicadores AS ind')
                    //->like('ind.med_fullname', $dato, 'both')
                    ->where('ind.tex_id', $dato)
                    ->get()
                    ->result_array();

            $aResponse['data'] = $a_medicos;
        } catch (Exception $exc) {
            $aResponse['code'] = self::CODE_ERROR;
            $aResponse['msg'] = $exc->getMessage();
        }
        echo json_encode($aResponse);
    }

    public function listar_indicadores() {
        $page = $this->input->post('page');
        $limit = $this->input->post('rows');
        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');
        $idSearch = $this->input->post('i_idexamen');
        //$searchOn = $this->input->post('_search');
//        if ($searchOn == 'true') {
//            $searchOn = true;
//        } else {
//            if ($searchOn == 'false')
//                $searchOn = false;
//        }
        //$searchstr = "";
        //$searchstr = $this->input->post('filters');

        $inidicadores = $this->Registerexamen_model->listar_indicadores_jqgrid($page, $limit, $sidx, $sord, $idSearch);
        echo $inidicadores;
    }

    public function listar_examenes() {
        $page = $this->input->post('page');
        $limit = $this->input->post('rows');
        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');
        $idSearch = $this->input->post('i_idexamen');
        //$searchOn = $this->input->post('_search');
//        if ($searchOn == 'true') {
//            $searchOn = true;
//        } else {
//            if ($searchOn == 'false')
//                $searchOn = false;
//        }
        //$searchstr = "";
        //$searchstr = $this->input->post('filters');

        $inidicadores = $this->Resultados_examen_model->listar_examenes_jqgrid($page, $limit, $sidx, $sord, $idSearch);
        echo $inidicadores;
    }

    // FUNCTIONS PARA PARA RESULTADOS DE EXAMENES
    public function listar_tipoexamen() {

        $aResponse = $this->json_array_return;
        try {

            $dato = $this->input->post('idExamen');

            $a_examenes = $this->db->select('exa_d.exad_id, exa_d.exa_id,exa_d.exad_nombre')
                    ->from('examen_detalle AS exa_d')
                    //->like('ind.med_fullname', $dato, 'both')
                    ->where('exa_d.exa_id', $dato)
                    ->get()
                    ->result_array();

//            print_r($this->db->last_query());
//           die();

            $aResponse['data'] = $a_examenes;
        } catch (Exception $exc) {
            $aResponse['code'] = self::CODE_ERROR;
            $aResponse['msg'] = $exc->getMessage();
        }
        echo json_encode($aResponse);
    }

    /* Listar Indicadores ** */

    public function listar_indicadoresByExamen() {

        $aResponse = $this->json_array_return;
        try {

            $dato = $this->input->post('idTipoExamen');

            $a_indicadores = $this->db->select('d_iex.indd_id,ind.ind_id AS idIndicador,ind.ind_descripcion,d_iex.indd_valor_resultante,ind.ind_unidad_medida,ind.ind_rango_referencial')
                    ->from('detalle_indicadores_examen AS d_iex')
                    ->join('indicadores ind', 'd_iex.ind_id = ind.ind_id', 'inner')
                    //->like('ind.med_fullname', $dato, 'both')
                    ->where('d_iex.exad_id', $dato)
                    ->get()
                    ->result_array();

//            print_r($this->db->last_query());
//           die();

            $aResponse['data'] = $a_indicadores;
        } catch (Exception $exc) {
            $aResponse['code'] = self::CODE_ERROR;
            $aResponse['msg'] = $exc->getMessage();
        }
        echo json_encode($aResponse);
    }

    //GUARDAR RESULTADOS DE INDICADORES
    public function guardar_resultado_indicador() {


        $response = $this->json_array_return;

        try {

            $i_indicador_resultado_id = $_POST['idIndicador'];
            $valor_resultante = $_POST['dato_resultado'];

            $data = Array(
                'indd_valor_resultante' => $valor_resultante
            );
            if ($i_indicador_resultado_id != 0) {
                $ver = $this->Resultados_examen_model->editar_resultado_indicador($i_indicador_resultado_id, $data);
            } else {
                //$ver = $this->paciente_model->agregar_paciente($data);
                echo 'No existe indocador Asociado.';
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            throw $e;
        }
        echo json_encode($response);
    }

    public function guardar_resultado_indicador_especial() {


        $response = $this->json_array_return;

        try {

            $i_indicador_resultado_id = $this->input->post('input_idDetalleInd');
            /* Valores */
            $valor_input_idInd = $this->input->post('input_idInd');

            $valor_input_leucocitos = $this->input->post('input_leucocitos');
            $valor_input_mielo = $this->input->post('input_mielo');
            $valor_input_juv = $this->input->post('input_juv');
            $valor_input_abs = $this->input->post('input_abs');
            $valor_input_seg = $this->input->post('input_seg');
            $valor_input_oe = $this->input->post('input_oe');
            $valor_input_bas = $this->input->post('input_bas');
            $valor_input_mon = $this->input->post('input_mon');
            $valor_input_linf = $this->input->post('input_linf');
            $valor_input_obser = $this->input->post('input_observacion');
            $valor_input_Neutrofilos = $this->input->post('input_Neutrofilos');

            $data = Array(
                'indd_valor_resultante' => "0"
            );

            $this->db->trans_begin();
            if ($i_indicador_resultado_id != 0) {
                $ver = $this->Resultados_examen_model->editar_resultado_indicador($i_indicador_resultado_id, $data);

                /* Guardar Valores Especiales */
                $data_de = Array(
                    'inde_id' => $valor_input_idInd,
                    'indd_id' => $i_indicador_resultado_id,
                    'die_leucocitos' => $valor_input_leucocitos,
                    'die_mielo' => $valor_input_mielo,
                    'die_juv' => $valor_input_juv,
                    'die_abs' => $valor_input_abs,
                    'die_seg' => $valor_input_seg,
                    'die_eo' => $valor_input_oe,
                    'die_bas' => $valor_input_bas,
                    'die_mon' => $valor_input_mon,
                    'die_linf' => $valor_input_linf,
                    'die_neutrofilos' => $valor_input_Neutrofilos,
                    'die_observaciones' => $valor_input_obser,
                    'isGuardado' => 1
                );

                $this->db->set($data_de);
                $this->db->insert('detalle_indicador_especial');
            } else {
                //$ver = $this->paciente_model->agregar_paciente($data);
                echo 'No existe indocador Asociado.';
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            throw $e;
        }
        echo json_encode($response);
    }

    /* Register Examen */

    public function agregar_examen() {

        $response = $this->json_array_return;

        try {
            $pago_restante = 0;
            $estado_pago = 0;
            $cod_exa = "EXA";

            $i_paciente = $_POST['paciente'];
            $i_medico = $_POST['medico'];
            $v_pago_efectivo = trim($_POST['pago_efectivo']);
            $v_pago_adelanto = trim($_POST['pago_adelanto']);

            if ($v_pago_adelanto == 0) {
                $pago_restante = 0;
                $estado_pago = 'pagado';
            } else {
                $pago_restante = $v_pago_efectivo - $v_pago_adelanto;
                $estado_pago = 'saldo por cobrar';
            }



            $a_detail = $_POST['detail'];

            // $paciente_id = $_POST['pac_id'];

            $this->db->trans_begin();

            //$q_limit_num = $this->db->query("SELECT fnGetLimitNum() AS 'limit_num'")->row();
            $q_limit_num = $this->db->query("SELECT fnGetLimitNum() AS 'limit_num'")->row();


            // print_r($q_limit_num->limit_num); 

            date_default_timezone_set("America/Lima");
            $data = Array(
                'pac_id' => $i_paciente,
                'med_id' => $i_medico,
                'exa_numero' => (int) ($q_limit_num->limit_num) + 1,
                'exa_fregistro' => strftime("%Y-%m-%d-%H-%M-%S", time()),
                'exa_monto' => $v_pago_efectivo,
                'exa_monto_prepago' => $v_pago_adelanto,
                'exa_monto_restante' => $pago_restante,
                'exa_estado_pago' => $estado_pago,
                'exa_estado' => 'recepcionado',
            );

            $this->db->set($data);

//
//            if ($paciente_id != 0) {
//                $ver = $this->paciente_model->editar_paciente($paciente_id, $data);
//            } else {
//                $ver = $this->paciente_model->agregar_paciente($data);
//            }

            $this->db->insert('examenes');
            $id_header = $this->db->insert_id();
            //Generar Codigo Examen
            $q_limit_num = $this->db->query("SELECT fnGetLimitNum() AS 'limit_num'")->row();

            //print_r($q_limit_num->limit_num); die();
            $cod_examen = $cod_exa . '' . $q_limit_num->limit_num;
            $data_code = Array(
                'exa_cod' => $cod_examen
            );

            $update_cod = $this->Registerexamen_model->editar_examenes($id_header, $data_code);

            foreach ($a_detail as $a_item) {

                $data_detail = Array(
                    'exa_id' => $id_header,
                    'tex_id' => $a_item['idExamen'],
                    'exad_nombre' => $a_item['nameExamen'],
                    'exad_precio' => $a_item['getTotal'],
                );

                $this->db->set($data_detail);
                $this->db->insert('examen_detalle');

                $d_ind = $a_item['idIndicadores'];
                $id_header_det = $this->db->insert_id();

                //$a_indicadores = explode(",", $d_ind);
                //$a_indicadores = array_map('trim',explode(",",$d_ind));
                $a_indicadores = explode(",", trim($d_ind, ","));

                for ($i = 0; $i < count($a_indicadores); $i++) {
                    $data_detail_ind = Array(
                        'exad_id' => $id_header_det,
                        //'tex_id' => $a_indicadores[$i],
                        'ind_id' => $a_indicadores[$i]
                    );


                    $this->db->set($data_detail_ind);
                    $this->db->insert('detalle_indicadores_examen');
                }
            }


//            echo $this->db->last_query();
//            die();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            throw $e;
        }
        echo json_encode($response);
    }

    /*
     * Metodo para pasar data necesaria a la vista de exportacion
     * Parecido al metodo anterior 
     */

    public function printDataToExport($idSearch) {

        $det_indicadores = Array();
        $det_indicadores_esp = Array();
        $det_tipo_examen_parent = Array();

        $examen = $this->Resultados_examen_model->retornar_examen_array($idSearch);
        foreach ($examen as $key => $value) {
            $id_examen = $value->exa_id;
        }

        $tipo_examen = $this->Resultados_examen_model->retornar_tipoexamen_array($id_examen);

        foreach ($tipo_examen as $key => $value) {
            $id_tipo_examen = $value->exad_id;
            $det_indicadores[$key] = $this->Resultados_examen_model->retornar_detalle_indicadores_array($id_tipo_examen);

            foreach ($det_indicadores[$key] as $esp_key=>$det_ex_valor) {
                //echo "p".$esp_key;
                if ($det_ex_valor->ind_id == 26) {
                    //echo "entra0";
                    $det_indicadores_esp[$esp_key] = $this->Resultados_examen_model->retornar_detalle_indicadores_esp_array($det_ex_valor->ind_id , $det_ex_valor->indd_id );
               
                }
                     //echo "entra1" . count($det_indicadores_esp);
            }
            //if($value->tex_idPadre!=null)
            $det_tipo_examen_parent[$key] = $this->Resultados_examen_model->retornar_tipoexamen_parent_array($value->tex_idPadre);
        }
        //print_r($det_tipo_examen_parent); die();
        //print_r($det_indicadores); die();

        $data['detalle_examen_indicadores'] = $det_indicadores;
        $data['detalle_examen_indicadores_esp'] = $det_indicadores_esp;
        $data['detalle_tipo_examen_parent'] = $det_tipo_examen_parent;
        $data['examen'] = $examen;
        $data['tipo_examen'] = $tipo_examen;

        $this->load->view('examen/exportar', $data);
    }

    public function cancelar_examen() {
        $aResponse = $this->json_array_return;
        try {
            $exa_id = $_POST['idExamen'];
            $estado = 'cancelado';

            $data = Array(
                'exa_estado' => $estado
            );
            $ver = $this->Resultados_examen_model->editar_examen($exa_id, $data);
        } catch (Exception $exc) {
            echo $exc;
        }
        echo json_encode($aResponse);
    }

    // Listar Examenes para Lista Inicial
    public function getTipoExamen() {

        $aResponse = $this->json_array_return;
        try {
            $key = $this->input->post('key');
            $adic_where_key = "";
            $adic_where_parent = "";
            //print_r($key); die();
            //print_r($key); die();
            // $dato = $this->input->post('idExamen');
//            $sub_examenes = $this->db->select('tipos_examen.tex_id')
//                    ->select_sum('IF(tipos_examen.tex_id=t_ex.tex_idPadre,"1","0") AS "unassigned"')
//                    ->from('tipos_examen,`tipos_examen` AS t_ex')
//                    ->group_by("tipos_examen.tex_id")
//                    //->join('tipos_examen AS t_ex2', 'subOpt.tex_id = tipos_examen.tex_id', 'inner')
//                    //->like('ind.med_fullname', $dato, 'both')
//                    //->where('exa_d.exa_id', $dato)
//                    ->get()
            // $sub_examenes = $this->db->query("SELECT tipos_examen.tex_id,SUM(IF(tipos_examen.tex_id = t_ex.tex_idPadre,1,0)) AS tex_idPadre FROM
            if ($key === 'null') {
                $adic_where_key = "";
                $adic_where_parent = ('WHERE tipos_examen.tex_idPadre IS NULL');
                //print_r($key.'777'); die();
            } else {
                $adic_where_parent = "";
                $adic_where_key = ('WHERE tipos_examen.tex_idPadre=' . $key);
            }

            $sub_examenes = ("(SELECT tipos_examen.tex_id,SUM(IF(tipos_examen.tex_id = t_ex.tex_idPadre,1,0)) AS subExamenes FROM
              (
                tipos_examen,
                tipos_examen AS t_ex
              ) " . $adic_where_key . "" . $adic_where_parent . " GROUP BY tipos_examen.tex_id)");
            //->get();
            //->result_array();
//            else
//                $sub_examenes->where('tipos_examen.tex_idPadre', NULL);

            $options = $this->db->select('*')
                    ->from('tipos_examen')
                    //->join(array($sub_examenes, 'subOpt'))->on('subOpt.key', '=', 'options.key')
                    ->join($sub_examenes . ' AS subOpt', 'subOpt.tex_id = tipos_examen.tex_id', 'inner')
                    ->get()
                    ->result_array();
            //->where('options.component', '=', $component)
            //->order_by('options.order');
//            print_r($this->db->last_query());
//            die();

            $aResponse['data'] = $options;
        } catch (Exception $exc) {
            $aResponse['code'] = self::CODE_ERROR;
            $aResponse['msg'] = $exc->getMessage();
        }
        echo json_encode($aResponse);
    }

}
