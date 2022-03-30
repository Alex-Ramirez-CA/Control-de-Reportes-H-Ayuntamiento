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

	public function editar_descripcion() {
		// Verificar que solo pueda acceder a esta funcion un usuario logeado
		if($this->session->has_userdata('id_rol')) {
			// Recibir la id de la incidencia a editar su descripcion vía post
			$id_incidencia = $this->input->post('id_incidencia');
			if($desc = $this->Incidencia->get_descripcion($id_incidencia)) {
				echo json_encode($desc);
			}
		} else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}
	public function actualizar_descripcion() {
		// Verificar que solo pueda acceder a esta funcion un usuario logeado
		if($this->session->has_userdata('id_rol')) {
			// Recibir la id de la incidencia
			$id_incidencia = $this->input->post('id_incidencia');
			// Recibir la descripcion actualizada
			$descripcion = $this->input->post('descripcion');
			$res = $this->Incidencia->update_incidencia($id_incidencia, $descripcion);
			echo json_encode(array('msg' => 'Descripcion actializada correctamente'));
		} else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}

	// Asignar 
	public function asignar_departamento() {
		// Verificar que solo pueda acceder a esta funcion un usuario logeado
		if($this->session->has_userdata('id_rol')) {
			// Recibir la id de la incidencia
			$id_incidencia = $this->input->post('id_incidencia');
			// Recibir valores de departamentos asignados
			if($soporte = $this->input->post('soporte')) {
				$datos = array(
					'id_departamento' => $soporte,
					'id_incidencia' => $id_incidencia,
				);
				$this->Incidencia_departamento->asignar_departamento($datos);
			}
			if($redes = $this->input->post('redes')) {
				$datos = array(
					'id_departamento' => $redes,
					'id_incidencia' => $id_incidencia,
				);
				$this->Incidencia_departamento->asignar_departamento($datos);
			}
			if($administracion = $this->input->post('administracion')) {
				$datos = array(
					'id_departamento' => $administracion,
					'id_incidencia' => $id_incidencia,
				);
				$this->Incidencia_departamento->asignar_departamento($datos);
			}
			echo json_encode(array('msg' => 'Departamentos asignados correctamente'));
		} else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}
}