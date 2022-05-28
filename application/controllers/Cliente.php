<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session', 'form_validation'));
		$this->load->model(array('Incidencia', 'Atender_incidencia'));
		$this->load->helper(array('incidence/incidencia_rules'));
	}

	public function index()
	{
		// validar que el usuario este logeado y sea de tipo cliente
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 0) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
			
			// Obtener incidencias pendientes
			$status = 0;
			$res_0 = $this->Incidencia->get_incidencias($no_empleado, $status);
			
			// Obtener incidencias en proceso
			$status = 1;
			$res_1 = $this->Incidencia->get_incidencias($no_empleado, $status);

			// Meter la información en un array para mandarlo a la vista
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'pendientes' => $res_0,
				'en_proceso' => $res_1,
			);

			// Cargar vista y mandarle los datos
        	$this->load->view('v_cliente', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}

}