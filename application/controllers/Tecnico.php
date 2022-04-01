<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnico extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model(array('Incidencia', 'Atender_incidencia'));
	}

	public function index()
	{
		// validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el departamento al que pertenece el tecnico
			$id_departamento = $this->session->userdata('id_departamento');
			// Obtener incidencias pendientes
			$status = 0;
			$res_0 = $this->Incidencia->get_incidenciasDepar($id_departamento, $status);
			// Obtener incidencias en proceso
			$status = 1;
			$res_1 = $this->Incidencia->get_incidenciasDepar($id_departamento, $status);
			// Obtener incidencias en proceso
			$status = 2;
			$res_2 = $this->Incidencia->get_incidenciasDepar($id_departamento, $status);
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'pendientes' => $res_0,
				'en_proceso' => $res_1,
				'finalizados' => $res_2,
			);
			// Cargar la vista
        	$this->load->view('v_tecnico', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}

	// Funcion que resgistrara cuando un tercnico le de atender una incidencia
	public function Atender() {
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
			// Agregar registro
			$this->Atender_incidencia->insertar($data);
			// Cambiar el estatus de la incidencia a en_proceso
			$this->Incidencia->modificar_status($id_incidencia, 1);
			redirect('tecnico');
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}
	public function Unirme() {
		// validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
			// Recibir id_incidencia vía post
			$id_incidencia = 5;//$this->input->post('id_incidencia');
			// Recibir el comentario vía post
			$comentario = 'Me uní a ustedes';//$this->input->post('comentario');
			// Se hace una consulta a la bd para verificar que dicho usuario no haya
			// atendido antes dicho incidencia y no repetir registros
			if($this->Atender_incidencia->verificar($id_incidencia, $no_empleado)) {
				echo json_encode(array('msg' => 'Ya se había unido con anterioridad'));
			} else {
				//Obtener la fecha del sistema
				date_default_timezone_set('America/Mexico_City');
				$fecha = date("Y-m-d h:i:s", time());
				$data = array(
					'no_empleado' => $no_empleado,
					'id_incidencia' => $id_incidencia,
					'comentario' => $comentario,
					'fecha' => $fecha,
				);
				// Agregar registro
				$this->Atender_incidencia->insertar($data);
				redirect('tecnico');
			}
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}
	public function Reabrir() {
		// Primeramente se hara una consulta para verificar que el tecnico no este atendiendo
		// ya dicha incidencia
		// Si la consulta regresa false es porque no hay tal relacion y se procese a lo siguiente
		// Hacer una insercion a la tabla atender_incidencia
		// agregando el id_incidencia, el no_empleado, el comentario y la fecha actual
		// Si la consulta regresa algo entonces solo se cambia
		// el estatus de la incidencia que regresara a ser 1, o en proceso
		date_default_timezone_set('America/Mexico_City');
		$date = date("Y-m-d h:i:s", time());
	}
	public function finalizar(){
		// Lo unico que hara esta funcion es pasar el estatus de dicha incidencia a 2
	}

}