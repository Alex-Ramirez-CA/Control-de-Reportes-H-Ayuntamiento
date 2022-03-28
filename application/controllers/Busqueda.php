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
        // obtener el id del impleado
        $no_empleado = $this->session->userdata('id');
        // Recibir el valor del campo de busqueda via post
		$search = $this->input->post('search');
        // Recibir la direccion desde donde se hace la busqueda
        $url = $this->input->post('uri');

        // Validar que la variable de busqueda traiga datos
        if(!empty($search)) {
            // La busqueda a realizar sera diferente segun el usuario y el lugar donde se encuentre
            switch ($url) {
                case 'reporte':
                case 'cliente':
                    $data = $this->Incidencia->buscar_porUsuario($no_empleado, $search);
                    break;
                case 'filtro':
                    $data = $this->Incidencia->buscar_pendientes($search);
                    break;
                case 'tecnico':
                    echo "Funcionalidad en desarrollo";
                    break;
                case 'administrador':
                    echo "Funcionalidad en desarrollo";
                    break;
            }
            // Hacer consulta al modelo
            
        }
		// Mandar datos al cliente via ajax
		echo json_encode($data);
	}

}