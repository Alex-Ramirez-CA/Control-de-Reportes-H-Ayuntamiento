<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filtro extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session', 'form_validation'));
		$this->load->model(array('Incidencia', 'Incidencia_departamento'));
		$this->load->helper(array('incidence/incidencia_rules'));
	}

	public function index()
	{
		// validar que el usuario este logeado y sea de tipo cliente
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 1) {
			// Obtener los datos necesarios para la vista principal
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'incidencias' => $this->Incidencia->get_new_incidencias(),
			);
			// Cargar la vista
        	$this->load->view('v_Filtro', $data);
			// echo json_encode(array('incidencias' => $this->Incidencia->get_new_incidencias()));
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}

}