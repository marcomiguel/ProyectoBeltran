<?php

class Registerexamen_model extends CI_Model {

    private $examenes = 'examenes';

    function __construct() {
        parent::__construct();
    }

    private function retornar_cantidad() {
        return $this->db->count_all('indicadores');
    }

    private function retornar_examen($sidx, $sord, $start, $limit, $idSearch) {
        $this->db->limit($limit, $start);
        $this->db->order_by($sidx, $sord);
//        $this->db->join('especialidades e', 'm.esp_id = e.esp_id', 'inner');
//        $this->db->join('centro_laboral cl', 'm.med_centro_laboral = cl.cenl_id', 'inner');
        $this->db->where('ind.tex_id', $idSearch);
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

        $query = $this->db->get('indicadores ind');

        return $query->result();
    }

    private function retornar_perfil($sidx, $sord, $start, $limit, $idSearch) {
        $this->db->limit($limit, $start);
        $this->db->order_by($sidx, $sord);
        
        $this->db->join('indicadores_perfiles ind_per', 'ind.ind_id = ind_per.ind_id', 'inner');
        //echo 'entr'; die(); 
        $this->db->where('ind_per.per_id', $idSearch);
        $query = $this->db->get('indicadores ind')->result();
        //echo $this->db->last_query(); die();
        return $query;
    }

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

    public function listar_indicadores_jqgrid($page, $limit, $sidx, $sord, $idSearch, $isPerfil) {
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

            if ($isPerfil == 1)
                $result = $this->retornar_perfil($sidx, $sord, $start, $limit, $idSearch);
            else
                $result = $this->retornar_examen($sidx, $sord, $start, $limit, $idSearch);

            $responce->page = $page;
            $responce->total = $total_pages;
            $responce->records = $count;
            $i = 0;
            foreach ($result as $row) {
                $responce->rows[$i]['id'] = $row->ind_id;
                $responce->rows[$i]['cell'] = array(
                    $row->ind_id,
                    $row->ind_descripcion,
                    $row->ind_precio,
                );
                $i++;
            }
            return json_encode($responce);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

//    public function listar_indicadores_jqgrid($page, $limit, $sidx, $sord,$idSearch) {
//        try {
//            $page = $page;
//            $limit = $limit;
//            $sidx = $sidx;
//            $sord = $sord;
//            if (!$sidx)
//                $sidx = 1;
//
//            $result = $this->retornar_cantidad();
//
//            $count = $result;
//
//            if ($count > 0) {
//                $total_pages = ceil($count / $limit);
//            } else {
//                $total_pages = 0;
//            }
//            if ($page > $total_pages)
//                $page = $total_pages;
//            $start = $limit * $page - $limit;
//
//            $result = $this->retornar_perfil($sidx, $sord, $start, $limit,$idSearch);
//
//            $responce->page = $page;
//            $responce->total = $total_pages;
//            $responce->records = $count;
//            $i = 0;
//            foreach ($result as $row) {
//                $responce->rows[$i]['id'] = $row->ind_id;
//                $responce->rows[$i]['cell'] = array(
//                    $row->ind_id,
//                    $row->ind_descripcion,
//                    $row->ind_precio,
//                );
//                $i++;
//            }
//            return json_encode($responce);
//        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }

    public function editar_examenes($id, $data) {
        $this->db->where('exa_id', $id);
        return $this->db->update($this->examenes, $data);
    }

}
