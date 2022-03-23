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
		// validar que el usuario este logeado y sea de tipo cliente
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 0) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
			
			// Obtener incidencias pendientes
			$status = 0;
			$res_0 = $this->Incidencia->get_incidencias($no_empleado, $status);
			
			// Obtener incidencias en proceso
			$status = 1;
			$res_1 = $this->Incidencia->get_incidencias($no_empleado, $status);

			// Meter la información en un array para mandarlo a la vista
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'pendientes' => $res_0,
				'en_proceso' => $res_1,
			);

			// Cargar vista y mandarle los datos
        	$this->load->view('v_cliente', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}

	public function buscar_incidencia() {
		// Validar para que no puedan ingresar a esta direccion sin estar logeados
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
		// Extraer id del empleado de las variabes de sesion 
		$no_empleado = $this->session->userdata('id');
		// Recibir el valor del campo de busqueda via post
		$search = $this->input->post('search');
		// Hacer consulta al modelo
		$data = $this->Incidencia->get_incidencia($no_empleado, $search);
		// Mandar datos al cliente via ajax
		echo json_encode($data);
	}

	// Recibe un id desde la vista y traes los datos necesario para crear el reporte
    public function nuevo_reporte($id_incidencia){
        // $id_incidencia = 1;
		$generales = $this->Incidencia->datos_reporte($id_incidencia);
		$comentarios = $this->Atender_incidencia->get_comentarios($id_incidencia);
		$archivos = $this->Archivo->get_archivos($id_incidencia);
        $data = array(
			'head' => $this->load->view('layout/head', '', TRUE),
			'footer' => $this->load->view('layout/footer', '', TRUE),
            'generales' => $generales,
            'comentarios' => $comentarios,
            'archivos' => $archivos
		);
		$this->load->view('v_reporte', $data);
        // echo json_encode($data);
    }

	public function nueva_incidencia() {
		$fecha = date("Y").'-'.date("m").'-'.date("d");
		$datos = array(
			'titulo' => $this->input->post('titulo'),
			'no_empleado' => $this->session->userdata('id'),
			'fecha_apertura' => $fecha,
			'fecha_cierre' => '',
			'descripcion' => $this->input->post('descripcion'),
			'status' => 0
		);
		$this->incidencia->guardar_incidencia($datos);
		redirect('cliente');
	}

}