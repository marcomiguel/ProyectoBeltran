<?php

class Paciente_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private function retornar_cantidad() {
        return $this->db->count_all('pacientes');
    }

    private function retornar_paciente($sidx, $sord, $start, $limit) {
        $this->db->limit($limit, $start);
        $this->db->order_by($sidx, $sord);
        $this->db->join('ciudades c', 'p.ciu_id = c.ciu_id');
        $query = $this->db->get('pacientes p');
        return $query->result();
    }

    public function retornar_paciente_por_id($id) {
        $this->db->where('pac_id', $id);
        $query = $this->db->get('pacientes');
        return $query->result();
    }

    public function agregar_paciente($data) {
        $this->db->insert('pacientes', $data);
    }

    public function editar_paciente($id, $data) {
        $this->db->where('pac_id', $id);
        $this->db->update('pacientes', $data);
    }

    public function eliminar_paciente() {
        $this->db->where('pac_id', $id);
        $this->db->delete('pacientes');
    }

    public function listar_jqgrid($page, $limit, $sidx, $sord) {
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

            $result = $this->retornar_paciente($sidx, $sord, $start, $limit);

            $responce->page = $page;
            $responce->total = $total_pages;
            $responce->records = $count;
            $i = 0;
            foreach ($result as $row) {
                $responce->rows[$i]['id'] = $row->pac_id;
                $responce->rows[$i]['cell'] = array(
                    $row->pac_id,
                    $row->pac_nombres,
                    $row->pac_apellido_paterno,
                    $row->pac_apellido_materno,
                    $row->pac_edad,
                    $row->pac_telefono,
                    $row->pac_direccion,
                    $row->ciu_nombre);
                $i++;
            }
            return json_encode($responce);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
