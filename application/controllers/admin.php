<?php

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        //$this->load->model('Paciente_model');
        session_start();
    }

    public function index() {
        $this->load->view('login/index');
    }

    /*
     * Inicio Login
     * 
     */

    public function autenticar() {
        $data = array();
        $usuario = $this->Admin_model->verificar_usuario($this->input->post('txt_usuario'), $this->input->post('txt_contrasena'));
        if (isset($usuario) && $usuario != NULL) {
            $_SESSION['bienvenido'] = $usuario->usu_login;
            $data["value"] = 1;
            $data["url"] = site_url("admin/panel");
        } else {
            $data["value"] = 0;
        }
        echo json_encode($data);
    }

    private function verificarSesion() {
        $is_logged_in = $_SESSION['bienvenido'];
        if (!isset($is_logged_in) || $is_logged_in != true) {
            echo 'No tienes acceso a este contenido weon!';
            redirect('admin/index');
        }
    }

    public function salir() {
        //session_unset($_SESSION['bienvenido']);
        session_destroy();
        redirect('admin/index');
    }

    /*
     * Fin Login
     * 
     */

    public function panel() {
        $this->verificarSesion();
        $this->load->view('template/header');
        $this->load->view('template/menu');
        //$this->load->view('paciente/index'); //main
        //$this->load->view('template/footer');
    }

    /*
     * Paciente
     * 
     */

    public function pacientes() {
        $this->verificarSesion();
        $data["bcrumb1"]="Administracion";
        $data["bcrumb2"]="Paciente";
        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('template/wrapper',$data);
        $this->load->view('paciente/index'); //main
        $this->load->view('template/footer');
    }

    /*
     * Medico
     * 
     */

    public function medicos() {
        $this->verificarSesion();
        $data["bcrumb1"]="Administracion";
        $data["bcrumb2"]="Medico";
        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('template/wrapper',$data);
        $this->load->view('medico/index'); //main
        $this->load->view('template/footer');
    }
    
    /*
     * Examen
     * 
     */

    public function examen() {
        $this->verificarSesion();
        $data["bcrumb1"]="Administracion";
        $data["bcrumb2"]="Registrar Examen";
        $data["tipos_examen"]=$this->Admin_model->listar_tipos_examen();;
        $data["tipos_sub_examen"]=$this->Admin_model->listar_tipos_sub_examen();
        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('template/wrapper',$data);
        $this->load->view('examen/registrar'); //main
        $this->load->view('template/footer');
    }
    
    /*
     * Examen
     * 
     */

    public function resultados() {
        $this->verificarSesion();
        $data["bcrumb1"]="Administracion";
        $data["bcrumb2"]="Registrar Resultados de Examen";
        //$data["tipos_examen"]=$this->Admin_model->listarExamen_tipos_examen();;
        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('template/wrapper',$data);
        $this->load->view('examen/resultados'); //main
        $this->load->view('template/footer');
    }


}
