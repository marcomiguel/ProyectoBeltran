<?php

class Admin_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function retornar_usuario() {
        $query = $this->db->get('usuarios');
        return $query->result();
    }

    /*
     * Login
     * 
     */

    public function verificar_usuario($user, $password) {
        $query = $this->db->where('usu_login', $user);
        $query = $this->db->where('usu_password', md5($password));
        $query = $this->db->get('usuarios');
        return $query->row();
    }

    public function listar_tipos_examen() {
        try {

            //$dato = $this->input->post('term');
            $a_tipo_examen = $this->db->select('t_ex.tex_id, t_ex.tex_descripcion,t_ex.tex_idPadre')
                    ->from('tipos_examen AS t_ex')
                    //->where('t_ex.tex_idPadre', null, FALSE)
                    //->like('med.med_fullname', $dato, 'both')
                    ->get()
                    ->result_array();
//            print_r($this->db->last_query());
//            die();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }

        return $a_tipo_examen;
    }
    
    public function listar_tipos_sub_examen() {
        try {

            //$dato = $this->input->post('term');
            $a_tipo_examen = $this->db->select('*')
                    ->from('tipos_examen AS tp_1')
                    ->join('tipos_examen tp_2', 'tp_1.tex_id = tp_2.tex_idPadre', 'inner')
                    ->where('tp_1.tex_id', 9)
                    //->like('med.med_fullname', $dato, 'both')
                    ->get()
                    ->result_array();
//            print_r($this->db->last_query());
//            die();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }

        return $a_tipo_examen;
    }

}
