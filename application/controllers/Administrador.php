<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model(array('Incidencia', 'Atender_incidencia', 'Equipo'));
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
			$fecha_inicio = $this->input->post('fecha_inicio'); 
			$fecha_fin = $this->input->post('fecha_fin'); 
			$direccion = (int)$this->input->post('direccion');
			$dependencia = (int)$this->input->post('dependencia'); 
			$equipo = (int)$this->input->post('equipo');
			$departamento = (int)$this->input->post('departamento');
			// $status, $direccion, $dependencia, $equipo, $departamento
			$pendientes = $this->Incidencia->get_incidenciasStatusCero(0, $direccion, $dependencia, NULL, $departamento);
			$en_proceso = $this->Incidencia->get_incidenciasStatusUno(1, $direccion, $dependencia, NULL, $departamento);
			// // $status, $fecha_inicio, $fecha_fin, $direccion, $dependencia, $equipo, $departamento
			$finalizados = $this->Incidencia->get_incidenciasStatusDos(2, $fecha_inicio, $fecha_fin, $direccion, $dependencia, NULL, $departamento);
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

	// Funcion para el campo de busqueda de equipos
	public function buscar_equipo() {
        // Validar para que no puedan ingresar a esta direccion sin estar logeados
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
        // Recibir el valor del campo de busqueda via post
		$search_equipo = $this->input->post('search_equipo');
        // Hacer consulta a la base de datos
        if($search_equipo != '' || $search_equipo != NULL) {
            $data = $this->Equipo->buscarEquipo($search_equipo);
        } else {
            $data = FALSE;
        }
        
        echo json_encode($data);
    }

}