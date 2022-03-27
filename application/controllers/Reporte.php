<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session', 'form_validation'));
		$this->load->model(array('Incidencia', 'Atender_incidencia'));
		$this->load->helper(array('incidence/incidencia_rules'));
	}
    
    public function index()
	{
        
	}

	// Funcion que manda a llamar la vista del formulario para crear una nueva incidencia
	public function agregar_incidencia() {
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
		$data = array(
			'head' => $this->load->view('layout/head', '', TRUE),
			'nav' => $this->load->view('layout/nav', '', TRUE),
			'footer' => $this->load->view('layout/footer', '', TRUE),
		);
        $this->load->view('v_crear_incidencia', $data);
	}

	// Funcion para guardar la incidencia
	public function guardar_incidencia() {
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
		// Eliminar los deliminatores que agrega por defecto la funcion form_error
		$this->form_validation->set_error_delimiters('', '');
		// Cargar las reglas de validación llamando a la función del helper
		$rules = getIncidenciaRules();
		$this->form_validation->set_rules($rules);
		// validar si las reglas se cumplen
		if($this->form_validation->run() == FALSE) {
			// Guardar las mensajes en caso de error de validación, dichos mensajes se encuentran en el helper
			$erros = array(
				'titulo' => form_error('titulo'),
				'descripcion' => form_error('descripcion'),
			);
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
			);
			$this->load->view('v_crear_incidencia', $data);
			// Mandar respuesta al cliente
			// echo json_encode($erros);
			// $this->output->set_status_header(400);
		} else {
			// Si se pasa la validacion del formulario
			// generar un nombre para el archivo con la fecha actual y un valor aleatorio
			$time = time();
			$date = date("dmYHis", $time);
			// extraer extension del archivo
			$path = $_FILES['archivo']['name'];
			$extension = pathinfo($path, PATHINFO_EXTENSION);
			// asignar nuevo nombre
			$nombre_archivo = $date.''.rand(0, 99).'.'.$extension;
			// Subir archivo al servidor
			$mi_archivo = 'archivo';
			$config['upload_path'] = "uploads/";
			$config['file_name'] = $nombre_archivo;
			$config['allowed_types'] = "*";
			$config['max_size'] = "5000"; //40mb
		
			$this->load->library('upload', $config);
		
			if (!$this->upload->do_upload($mi_archivo)) {
				//Si ocurrio un error al subir la imagen
				echo $this->upload->display_errors();
				return;
			}
			// Recibir los datos del formulario via post
			$titulo = $this->input->post('titulo');
			$descripcion = $this->input->post('descripcion');
			// Obtener fecha actual
			$fecha = date("Y").'-'.date("m").'-'.date("d");
			// Meter los datos en un array para la insercion a la bd
			$datos = array(
				'titulo' => $titulo,
				'no_empleado' => $this->session->userdata('id'),
				'fecha_apertura' => $fecha,
				'fecha_cierre' => '',
				'descripcion' => $descripcion,
				'status' => 0,
				'archivo' => $nombre_archivo,
			);
		
			$this->Incidencia->guardar_incidencia($datos);
			redirect('cliente');
			// echo json_encode($datos);
		}
	}

	public function visualizar_reporte(){
        $id_incidencia = $this->input->post('id_incidencia');
        echo json_encode(array('url' => base_url('reporte/nuevo_reporte/'.$id_incidencia)));
    }
	
    // Recibe el id_incidencia por parametro y traes los datos necesario para crear el reporte
    public function nuevo_reporte($id_incidencia){
        $generales = $this->Incidencia->datos_incidencia($id_incidencia);
		$comentarios = $this->Atender_incidencia->get_comentarios($id_incidencia);
		$data = array(
			'head' => $this->load->view('layout/head', '', TRUE),
			'footer' => $this->load->view('layout/footer', '', TRUE),
            'generales' => $generales,
            'comentarios' => $comentarios,
		);
		$this->load->view('v_reporte', $data);
    }

}