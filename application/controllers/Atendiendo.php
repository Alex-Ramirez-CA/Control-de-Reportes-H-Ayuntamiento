<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atendiendo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Incidencia');
	}

	public function index()
	{
        // validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
            // Obtener el departamento al que pertenece el tecnico
			$id_departamento = $this->session->userdata('id_departamento');
			// Obtener incidencias en proceso
			$status = 1;
			$res_1 = $this->Incidencia->get_incidenciasQueAtiendiendo($id_departamento, $status, $no_empleado);
			// Obtener incidencias en proceso
			$status = 2;
			$res_2 = $this->Incidencia->get_incidenciasQueAtiendiendo($id_departamento, $status, $no_empleado);
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'en_proceso' => $res_1,
				'finalizados' => $res_2,
			);
			// Cargar la vista
        	$this->load->view('v_atendiendo', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}

}