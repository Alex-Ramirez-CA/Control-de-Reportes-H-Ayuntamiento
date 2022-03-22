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
		$no_empleado = $this->session->userdata('id');
		// para incidencias pendientes
		$status = 0;
		$res_0 = $this->Incidencia->get_incidencias($no_empleado, $status);
		// para incidencias en proceso
		$status = 1;
		$res_1 = $this->Incidencia->get_incidencias($no_empleado, $status);

		$data = array(
			'head' => $this->load->view('layout/head', '', TRUE),
			'nav' => $this->load->view('layout/nav', '', TRUE),
			'footer' => $this->load->view('layout/footer', '', TRUE),
			'pendientes' => $res_0,
			'en_proceso' => $res_1,
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
		$no_empleado = $this->session->userdata('id');
		$id_incidencia = 1;
		$titulo = 'coloma';
		$res = $this->Incidencia->get_incidencia($no_empleado, $id_incidencia, $titulo);
		echo json_encode($res);
	}

	public function incidecias() {
		$no_empleado = $this->session->userdata('id');
		// para incidencias pendientes
		$status = 0;
		$res_0 = $this->Incidencia->get_incidencias($no_empleado, $status);
		// para incidencias en proceso
		$status = 1;
		$res_1 = $this->Incidencia->get_incidencias($no_empleado, $status);
		// $operad='';
		// foreach ($res_1 as $valor) {
		// 	if($valor->id_incidencia == $res_1[0]->id_incidencia){
		// 		$operad .= $valor->Encargado .', ';
		// 	}
			
		// }
		$data = array(
			'pendientes' => $res_0,
			'en_proceso' => $res_1,
			'finalizado' => ''
		);
		// echo $operad;
		// echo json_encode($res_1);
		// return $data;
		echo json_encode($data);
	}

}