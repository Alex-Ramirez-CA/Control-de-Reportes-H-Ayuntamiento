<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Busqueda extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model(array('Incidencia'));
	}
    
    public function index()
	{
        
	}

    public function buscar_incidencia() {
		// Validar para que no puedan ingresar a esta direccion sin estar logeados
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
        $data;
        // Obtener el tipo de rol del usuario
        $rol = $this->session->userdata('id_rol');
        // Recibir el valor del campo de busqueda via post
		$search = $this->input->post('search');
        // La busqueda a realizar sera diferente segun el usuario
        if($rol == 0) { // Cuando es tipo cliente
            // Extraer id del empleado de las variabes de sesion 
            $no_empleado = $this->session->userdata('id');
            // Validar que la variable traiga datos
            if(!empty($search)) {
                // Hacer consulta al modelo
                $data = $this->Incidencia->get_incidencia($rol, $no_empleado, $search);
            }
        } else if($rol == 1) { // Cuando es tipo filtro
            // Extraer id del empleado de las variabes de sesion 
            $no_empleado = $this->session->userdata('id');
            // Validar que la variable traiga datos
            if(!empty($search)) {
                // Hacer consulta al modelo
                $data = $this->Incidencia->get_incidencia($rol, $no_empleado, $search);
            }
        }
		// Mandar datos al cliente via ajax
		echo json_encode($data);
	}

}