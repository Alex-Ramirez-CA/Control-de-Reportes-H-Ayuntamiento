<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session', 'form_validation'));
		$this->load->model(array('Incidencia', 'Atender_incidencia', 'Equipo_usuario', 'Usuario'));
		$this->load->helper(array('incidence/incidencia_rules'));
	}
    
    public function index()
	{
        // Cargar la vista de los reportes de cada usuario, al presionar el boton mis reportes de la barra de nav
		// validar que el usuario este logeado
        if($this->session->has_userdata('id_rol')) {
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
        	$this->load->view('v_misReportes', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}

	// Funcion que manda a llamar la vista del formulario para crear una nueva incidencia
	public function agregar_incidencia() {
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
		$es_cliente = TRUE;
		if($this->session->userdata('id_rol') != 0) {
			// Cuando no es de tipo cliente
			// Agregarle la opcion de elegir el cliente que hace el reporte
			$no_empleado = $this->session->userdata('id');
			$es_cliente = FALSE;
		} else {
			// Si es cliente obtener sus datos de las variables de sesión
			$no_empleado = $this->session->userdata('id');
		}
		
		// Obtener los datos de los equipos
		$equipos = $this->Equipo_usuario->obtener_equipos($no_empleado);
		$data = array(
			'head' => $this->load->view('layout/head', '', TRUE),
			'nav' => $this->load->view('layout/nav', '', TRUE),
			'footer' => $this->load->view('layout/footer', '', TRUE),
			'equipos' => $equipos,
			'es_cliente' => $es_cliente,
		);
        $this->load->view('v_crear_incidencia', $data);
	}

	// Obtener equipos de usuario ajeno
	public function obtener_equipos() {
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
		$no_empleado = $this->input->post('id_usuario');
		$equipos = $this->Equipo_usuario->obtener_equipos($no_empleado);
		echo json_encode($equipos);
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
		} else {
			// Si se pasa la validacion del formulario
			$nombre_archivo = NULL;
			$extension = NULL;
			// Verificar si existe un archivo para subir al servidor
			if($_FILES['archivo']['name']) {
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
					//Si ocurrio un error al subir el archivo
					echo $this->upload->display_errors();
					return;
				}
			}
			// Recibir los datos del formulario via post
			$titulo = $this->input->post('titulo');
			$descripcion = $this->input->post('descripcion');
			//Por si el usuario no selecciona ningun equipo
			if($this->input->post('id_equipo') == 0){
				$id_equipo = NULL;
			}else{
				$id_equipo = $this->input->post('id_equipo');
			}
			// Obtener el no_empleado de quien sera la incidencia
			if($this->input->post('id_usuario') == 0){ 
				$no_empleado = $this->session->userdata('id');
			}else{
				$no_empleado = $this->input->post('id_usuario');
			}
			// Obtener fecha actual
			date_default_timezone_set('America/Mexico_City');
			$fecha = date("Y").'-'.date("m").'-'.date("d");
			// Meter los datos en un array para la insercion a la bd
			$datos = array(
				'titulo' => $titulo,
				'no_empleado' => $no_empleado,
				'fecha_apertura' => $fecha,
				'fecha_cierre' => NULL,
				'descripcion' => $descripcion,
				'status' => 0,
				'contador' => 0,
				'archivo' => $nombre_archivo,
				'ext' => $extension,
				'asignado' => 0,
				'id_equipo' => $id_equipo,
			);
		
			$this->Incidencia->guardar_incidencia($datos);
			redirect($this->session->userdata('rol_nombre'));
		}
	}

	// Funcion que recive la id_incidencia cliceada por el usuario y la regrea junto con la url
	public function visualizar_reporte(){
        $id_incidencia = $this->input->post('id_incidencia');
        echo json_encode(array('url' => base_url('reporte/nuevo_reporte/'.$id_incidencia)));
    }
	
    // Recibe el id_incidencia por parametro y trae los datos necesario para crear el reporte
    public function nuevo_reporte($id_incidencia){
        $generales = $this->Incidencia->datos_incidencia($id_incidencia);
        $equipo = $this->Incidencia->datos_equipo($id_incidencia);
		$comentarios = $this->Atender_incidencia->get_comentarios($id_incidencia);
		$data = array(
			'head' => $this->load->view('layout/head', '', TRUE),
			'footer' => $this->load->view('layout/footer', '', TRUE),
            'generales' => $generales,
			'equipo' => $equipo,
            'comentarios' => $comentarios,
		);
		$this->load->view('v_reporte', $data);
    }

	// Funcion que realiza la consulta de la busqueda y manda los resultados al front
	public function buscar_empleado() {
        // Validar para que no puedan ingresar a esta direccion sin estar logeados
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
        // Recibir el valor del campo de busqueda via post
		$search_usuario = $this->input->post('search_usuario');
        // Hacer consulta a la base de datos
        if($search_usuario != '' || $search_usuario != NULL) {
            $data = $this->Usuario->buscarEmpleado($search_usuario);
        } else {
            $data = NULL;
        }
        
        echo json_encode($data);
    }

}