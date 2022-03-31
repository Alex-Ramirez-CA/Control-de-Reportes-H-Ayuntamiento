<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnico extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Incidencia');
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
		// Esta funcion hara una insercion a la tabla atender_incidencia
		// agregando el id_incidencia, el no_empleado, el comentario y la fecha actual
		// de esta manera creando la relación entre ambos
		// Por ultimo el estatus de la incidencia pasara a ser 1, o en proceso
	}
	public function Unirme() {
		// Primeramente se hara una consulta para verificar que el tecnico no este atendiendo
		// ya dicha incidencia
		// Si la consulta regresa false es porque no hay tal relacion y se procese a lo siguiente
		// Hacer una insercion a la tabla atender_incidencia
		// agregando el id_incidencia, el no_empleado, el comentario y la fecha actual
		// Si regresa algo es porque ya existe la relacion y no se hara ninguna accion
		// El estatus de la incidencia no se modificara
	}
	public function Reabrir() {
		// Primeramente se hara una consulta para verificar que el tecnico no este atendiendo
		// ya dicha incidencia
		// Si la consulta regresa false es porque no hay tal relacion y se procese a lo siguiente
		// Hacer una insercion a la tabla atender_incidencia
		// agregando el id_incidencia, el no_empleado, el comentario y la fecha actual
		// Si la consulta regresa algo entonces solo se cambia
		// el estatus de la incidencia que regresara a ser 1, o en proceso
	}
	public function finalizar(){
		// Lo unico que hara esta funcion es pasar el estatus de dicha incidencia a 2
	}

}