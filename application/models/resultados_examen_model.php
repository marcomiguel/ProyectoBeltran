<?php

class Resultados_examen_model extends CI_Model {
    private $detalle_indicadores_examen = 'detalle_indicadores_examen';
    private $detalle_indicador_especial = 'detalle_indicador_especial';
    private $examenes= 'examenes';
    
    function __construct() {
        parent::__construct();
    }

    private function retornar_cantidad() {
        return $this->db->count_all('indicadores');
    }

    public function retornar_examen($sidx, $sord, $start, $limit,$idSearch) {
        $this->db->limit($limit, $start);
        $this->db->order_by($sidx, $sord);
        $this->db->join('pacientes pa', 'ex.pac_id = pa.pac_id', 'inner');
        $this->db->join('medicos me', 'ex.med_id = me.med_id', 'inner');
        if(is_numeric($idSearch)){
            $this->db->where('pa.pac_id', $idSearch);
        }else{
           $this->db->like('CONCAT(ex.exa_cod," ",pa.pac_id)', $idSearch, 'both'); 
        }
        
        
//        if ($searchOn == 1) {
//            $jsona = json_decode($searchstr, true);
//            if (is_array($jsona)) {
//                $gopr = $jsona['groupOp'];
//                $rules = $jsona['rules'];
//                foreach ($rules as $key => $val) {
//                    $dato = $val['data'];
//                    $campo = $val['field'];
//                }
//            }
//            $this->db->like($campo, $dato, 'both');
//        }

        $query = $this->db->get('examenes ex')->result();
        //echo $this->db->last_query(); die();

        return $query;
    }
    
    /* Exportar */
    public function retornar_examen_array($idSearch) {
        $this->db->join('pacientes pa', 'ex.pac_id = pa.pac_id', 'inner');
        $this->db->join('medicos me', 'ex.med_id = me.med_id', 'inner');
        $this->db->join('ciudades ciu', 'pa.ciu_id = ciu.ciu_id', 'inner');
        $this->db->where('ex.exa_id', $idSearch);
        $query = $this->db->get('examenes ex')->result();
//        
        //echo $this->db->last_query(); die();
        
        return $query;
        
    }
    public function retornar_tipoexamen_array($idSearch) {
//        $this->db->join('examen_detalle pa', 'ex.pac_id = pa.pac_id', 'inner');
        $this->db->join('tipos_examen t_ex', 'ex_d.tex_id = t_ex.tex_id', 'inner');
        $this->db->where('ex_d.exa_id', $idSearch);
        $query = $this->db->get('examen_detalle ex_d')->result();
        
        //echo $this->db->last_query(); die();
        
        return $query;
        
    }
    
     public function retornar_tipoexamen_parent_array($idSearch) {
//        $this->db->join('examen_detalle pa', 'ex.pac_id = pa.pac_id', 'inner');
        //$this->db->join('tipos_examen t_ex', 'ex_d.tex_id = t_ex.tex_id', 'inner');
        $this->db->where('t_ex.tex_id', $idSearch);
        $query = $this->db->get('tipos_examen t_ex')->result();
        
        //echo $this->db->last_query(); die();
        
        return $query;
        
    }
    
    
    public function retornar_detalle_indicadores_array($idSearch) {
        $this->db->join('indicadores ind', 'd_ind_ex.ind_id = ind.ind_id', 'inner');
        $this->db->where('d_ind_ex.exad_id', $idSearch);
        $query = $this->db->get('detalle_indicadores_examen d_ind_ex')->result();
        
        //echo $this->db->last_query(); die();
        
        return $query;
        
    }
    
    public function retornar_detalle_indicadores_esp_array($id_ind,$ind_det) {
        /*$this->db->join('indicadores ind', 'd_ind_ex.indid = ind.ind_id', 'inner');*/
        $this->db->where('d_ind_esp.inde_id', $id_ind);
        $this->db->where('d_ind_esp.indd_id', $ind_det);
        $query = $this->db->get('detalle_indicador_especial d_ind_esp')->result();
        
        //echo $this->db->last_query(); die();
        
        return $query;        
    }
    
    public function retornar_num_children_array($id_ind) {
        //$id_ind = 14;
        $this->db->select('Count(1) AS num_children');
        $this->db->join('tipos_examen t_e_c', 't_e.tex_id = t_e_c.tex_idPadre', 'inner');
        $this->db->where('t_e.tex_id', $id_ind);
        $query = $this->db->get('tipos_examen t_e')->result();
        
        //echo $this->db->last_query(); die();
        
        return $query;        
    }
    
    /* FIn de Exportar*/
    

//    public function retornar_medico_por_id($id) {
//        $this->db->where('med_id', $id);
//        $query = $this->db->get('medicos');
//        return $query->result();
//    }
//
//    public function agregar_medico($data) {
//        $this->db->insert('medicos', $data);
//    }
//
//    public function editar_medico($id, $data) {
//        $this->db->where('med_id', $id);
//        $this->db->update('medicos', $data);
//    }
//
//    public function eliminar_medico() {
//        $this->db->where('med_id', $id);
//        $this->db->delete('medicos');
    //}
    
    public function editar_resultado_indicador($id, $data) {
        $this->db->where('indd_id', $id);
        return $this->db->update($this->detalle_indicadores_examen, $data);
    }
    /*Indicador Especial */
    public function editar_resultado_indicador_especial($id, $data) {
        $this->db->where('indd_id', $id);
        return $this->db->update($this->detalle_indicador_especial, $data);
    }
    
    public function editar_examen($id, $data) {
        $this->db->where('exa_id', $id);
        return $this->db->update($this->examenes, $data);
    }

    public function listar_examenes_jqgrid($page, $limit, $sidx, $sord,$idSearch) {
        try {
            $page = $page;
            $limit = $limit;
            $sidx = $sidx;
            $sord = $sord;
            if (!$sidx)
                $sidx = 1;

            $result = $this->retornar_cantidad();

            $count = $result;

            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }
            if ($page > $total_pages)
                $page = $total_pages;
            $start = $limit * $page - $limit;

            $result = $this->retornar_examen($sidx, $sord, $start, $limit,$idSearch);

            $responce->page = $page;
            $responce->total = $total_pages;
            $responce->records = $count;
            $i = 0;
            foreach ($result as $row) {
                $responce->rows[$i]['id'] = $row->exa_id;
                $responce->rows[$i]['cell'] = array(
                    $row->exa_id,
                    $row->exa_cod,
                    $row->exa_estado,
                    $row->exa_fregistro,
                    $row->pac_fullname,
                    $row->med_fullname,
                    $row->exa_estado_pago,
                    $row->exa_monto,
                    $row->exa_monto_prepago,
                    $row->exa_monto_restante,                   
                );
                $i++;
            }
            return json_encode($responce);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
   
}
