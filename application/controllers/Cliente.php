<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session', 'form_validation'));
		$this->load->model('Incidencia');
		$this->load->helper(array('incidence/incidencia_rules'));
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
		// Validar que la variable traiga datos
		if(!empty($search)) {
			// Hacer consulta al modelo
			$data = $this->Incidencia->get_incidencia($no_empleado, $search);
		}
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

	// Funcion que manda a llamar al formulario para crear una nueva incidencia
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
			// Mandar respuesta al cliente
			echo json_encode($erros);
			$this->output->set_status_header(400);
		} else {
			// Si se pasa la validacion del formulario
			// Subir archivo al servidor
			$mi_archivo = 'archivo';
			$config['upload_path'] = "uploads/";
			$config['file_name'] = "nombre_archivo";
			$config['allowed_types'] = "*";
			$config['max_size'] = "5000"; //40mb
			// $config['max_width'] = "2000";
			// $config['max_height'] = "2000";
		
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
				'status' => 0
			);
		
			// $this->Incidencia->guardar_incidencia($datos);
			// redirect('cliente');
			echo json_encode($datos);
		}
	}

	private function cargar_archivo($nombre_archivo) {

		$mi_archivo = 'archivo';
		$config['upload_path'] = "../uploads/";
		$config['file_name'] = "nombre_archivo";
		$config['allowed_types'] = "*";
		$config['max_size'] = "5000"; //40mb
		// $config['max_width'] = "2000";
		// $config['max_height'] = "2000";
	
		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload($mi_archivo)) {
			//*** ocurrio un error
			// $data['uploadError'] = $this->upload->display_errors();
			echo $this->upload->display_errors();
			return;
		}
	
		var_dump($this->upload->data()); 
		}

}