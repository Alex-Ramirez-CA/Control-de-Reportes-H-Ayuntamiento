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
		// validar que el usuario este logeado y sea de tipo filtro
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 1) {
			// Obtener los datos necesarios para la vista principal
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'incidencias' => $this->Incidencia->get_new_incidencias(),
			);
			// Cargar la vista
        	$this->load->view('v_filtro', $data);
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
			echo json_encode(array(
				'msg' => 'Descripcion actializada correctamente',
				'url' => base_url('filtro')
			));
		} else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}

	// Asignar 
	public function asignar_departamento() {
		// Verificar que solo pueda acceder a esta funcion un usuario logeado
		if($this->session->has_userdata('id_rol')) {
			$validar = FALSE;
			// Recibir la id de la incidencia
			$id_incidencia = $this->input->post('id_incidencia');
			// Recibir valores de departamentos y verificar cuales no vienen como datos nulos
			// para hacer la insercion con los que si traen valor
			if($id_soporte = $this->input->post('soporte')) {
				$this->Incidencia_departamento->asignar_departamento($id_soporte, $id_incidencia);
				$validar = TRUE;
			}
			if($id_redes = $this->input->post('redes')) {
				$this->Incidencia_departamento->asignar_departamento($id_redes, $id_incidencia);
				$validar = TRUE;
			}
			if($id_administracion = $this->input->post('administracion')) {
				$this->Incidencia_departamento->asignar_departamento($id_administracion, $id_incidencia);
				$validar = TRUE;
			}
			// cambiar el estatus de la incidancia a 1 para indicar que ya ha sido asignada
			// a los departamentos
			if($validar){
				$this->Incidencia->status_asignado($id_incidencia);
				echo json_encode(array('url' => base_url('filtro')));
			}
			echo json_encode(array('msg' => 'Es necesario asignar al menos un departamento'));
			$this->output->set_status_header(500);
		} else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}
}