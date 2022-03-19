<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model('Incidencia');
	}

	public function index()
	{
		$data = array(
			'head' => $this->load->view('layout/head', '', TRUE),
			'nav' => $this->load->view('layout/nav', '', TRUE),
			'footer' => $this->load->view('layout/footer', '', TRUE),
		);

        if($this->session->userdata('id_rol') == 0) {
			// Aqui llamar la consulta para traer datos 
        	$this->load->view('v_cliente', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}

	public function buscar_incidencia() {
		$id_incidencia = 1;
		$titulo = 'Fallo de red';
		$res = $this->Incidencia->get_incidencia($id_incidencia, $titulo);
		echo json_encode($res);
		// print_r(json_encode($res));
	}

}