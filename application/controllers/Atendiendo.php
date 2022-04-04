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

	// Lo unico que hara esta funcion es pasar el estatus de dicha incidencia a 2 = finalizado
	public function finalizar(){
		// validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
			// Recibir id_incidencia vía post
			$id_incidencia = $this->input->post('id_incidencia');
			// Recibir el comentario vía post
			$comentario = $this->input->post('comentario');
			//Obtener la fecha del sistema
			date_default_timezone_set('America/Mexico_City');
			$fecha = date("Y-m-d h:i:s", time());
			$data = array(
				'no_empleado' => $no_empleado,
				'id_incidencia' => $id_incidencia,
				'comentario' => $comentario,
				'fecha' => $fecha,
			);
			// Hacer la insercion del registro
			$this->Atender_incidencia->insertar($data);
			// Cambiar el estatus de la incidencia a finalizada
			$this->Incidencia->modificar_status($id_incidencia, 2);
			redirect('tecnico');
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Funcion que reabrira una incidenia para pasarla a en_proceso y en caso de que no
	// Unira al usuario a la solucion de esta
	public function reabrir() {
		// validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
			// Recibir id_incidencia vía post
			$id_incidencia = $this->input->post('id_incidencia');
			// Recibir el comentario vía post
			$comentario = $this->input->post('comentario');
			//Obtener la fecha del sistema
			date_default_timezone_set('America/Mexico_City');
			$fecha = date("Y-m-d h:i:s", time());
			$data = array(
				'no_empleado' => $no_empleado,
				'id_incidencia' => $id_incidencia,
				'comentario' => $comentario,
				'fecha' => $fecha,
			);
			// Se hace una consulta a la bd para saber si dicho tecnico ya
			// habia atendido esta esta incidencia
			if($this->Atender_incidencia->verificar($id_incidencia, $no_empleado)) {
				// Si dicho tecnico formas parte de quienes atendieron esta incidencia
				// Se agrega otra insercion
				$this->Atender_incidencia->insertar($data);
				// Se le vuelve a cambiar el estatus a la misma a 1 = en proceso
				$this->Incidencia->modificar_status($id_incidencia, 1);
				// redirect('tecnico');
				echo json_encode(array('msg' => 'Reabriste la incidencia'));
			} else {
				// SI el usuario no esta vinculado con la incidencia se vincula y tambien
				// se hace el cambio de estatus de la misma
				// Agregar registro
				$this->Atender_incidencia->insertar($data);
				// Cambiar el estatus de la incidencia a en_proceso
				$this->Incidencia->modificar_status($id_incidencia, 1);
				echo json_encode(array('msg' => 'Reabriste la incidencia y te unes a ella'));
				// redirect('tecnico');
			}
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

}