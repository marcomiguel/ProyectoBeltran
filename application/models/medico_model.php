<?php

class Medico_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private function retornar_cantidad() {
        return $this->db->count_all('medicos');
    }

    private function retornar_medico($sidx, $sord, $start, $limit, $searchOn=null, $searchstr=null) {
        $this->db->limit($limit, $start);
        $this->db->order_by($sidx, $sord);
        $this->db->join('especialidades e', 'm.esp_id = e.esp_id', 'inner');
        $this->db->join('centro_laboral cl', 'm.med_centro_laboral = cl.cenl_id', 'left');
        $this->db->where('m.med_estado', 1);
        if ($searchOn == 1) {
            $jsona = json_decode($searchstr, true);
            if (is_array($jsona)) {
                $gopr = $jsona['groupOp'];
                $rules = $jsona['rules'];
                foreach ($rules as $key => $val) {
                    $dato = $val['data'];
                    $campo = $val['field'];
                }
            }
            $this->db->like($campo, $dato, 'both');
        }

        $query = $this->db->get('medicos m');

        return $query->result();
    }

    public function retornar_medico_por_id($id) {
        $this->db->where('med_id', $id);
        $query = $this->db->get('medicos');
        return $query->result();
    }

    public function agregar_medico($data) {
        $this->db->insert('medicos', $data);
    }

    public function editar_medico($id, $data) {
        $this->db->where('med_id', $id);
        $this->db->update('medicos', $data);
    }

    public function eliminar_medico() {
        $this->db->where('med_id', $id);
        $this->db->delete('medicos');
    }

    public function listar_jqgrid($page, $limit, $sidx, $sord, $searchOn=null, $searchstr=null) {
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

            $result = $this->retornar_medico($sidx, $sord, $start, $limit, $searchOn, $searchstr);

            $responce->page = $page;
            $responce->total = $total_pages;
            $responce->records = $count;
            $i = 0;
            foreach ($result as $row) {
                $responce->rows[$i]['id'] = $row->med_id;
                $responce->rows[$i]['cell'] = array(
                    $row->med_id,
                    $row->med_nombres,
                    $row->med_apellido_paterno,
                    $row->med_apellido_materno,
                    $row->esp_nombre,
                    $row->med_telefono,
                    $row->med_direccion,
                    $row->cenl_nombre
                );
                $i++;
            }
            return json_encode($responce);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
