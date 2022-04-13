<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model(array('Incidencia', 'Atender_incidencia'));
	}

	public function index()
	{
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
		
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
			);
			$this->load->view('v_administrador', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}
	
	public function cargar_datos()
	{
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			
			$status = 0;
			$res_0 = $this->Incidencia->get_incidenciasAdmin($status);
			// Obtener incidencias en proceso
			$status = 1;
			$res_1 = $this->Incidencia->get_incidenciasAdmin($status);
			// Obtener incidencias en proceso
			$status = 2;
			$res_2 = $this->Incidencia->get_incidenciasAdmin($status);
		
			$data = array(
				'pendientes' => $res_0,
				'en_proceso' => $res_1,
				'finalizados' => $res_2,
			);
			echo json_encode($data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}
	
	public function filtrar_incidencias()
	{
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			// $status, $direccion, $dependencia, $equipo, $departamento
			$pendientes = $this->Incidencia->get_incidenciasStatusCero(0, 2, 1, 2, 2);
			$en_proceso = $this->Incidencia->get_incidenciasStatusUno(1, 2, 1, 1, 3);
			// $status, $fecha_inicio, $fecha_fin, $direccion, $dependencia, $equipo, $departamento
			$finalizados = $this->Incidencia->get_incidenciasStatusDos(2, '2022-04-07', '2022-04-13', 2, 1, NULL, 1);
			$data = array(
						'pendientes' => $pendientes,
						'en_proceso' => $en_proceso,
						'finalizados' => $finalizados,
					);
			echo json_encode($data);

        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}

}