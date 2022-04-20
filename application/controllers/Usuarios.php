<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model(array('Usuario', 'Departamento', 'Rol', 'Direccion', 'Equipo'));
	}

    // Carga el formulario de agregar usuario nuevo
    public function index()
	{
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
		
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
                'departamentos' => $this->Departamento->get_departamentos(),
                'roles' => $this->Rol->get_roles(),
				'direcciones' => $this->Direccion->get_direcciones(),
			);
			$this->load->view('v_agregar_usuario', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}

	// Funcion para el campo de busqueda de equipos
	public function buscar_direccionIP() {
        // Validar para que no puedan ingresar a esta direccion sin estar logeados
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
        // Recibir el valor del campo de busqueda via post
		$search_IP = '192';//$this->input->post('search_IP');
        // Hacer consulta a la base de datos
        if($search_IP != '' || $search_IP != NULL) {
            $data = $this->Equipo->buscarDireccionIP($search_IP);
        } else {
            $data = false;
        }
        
        echo json_encode($data);
    }

    // Funcion para guardar los datos del usuario agregado
	public function guardar_usuario() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
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
			$this->load->view('v_agregar_usuario', $data);
		} else {
			
			// Datos para hacer la insercion en la tabla de usuario
			$datos = array(
				'nombre' => $nombre,
				'apellido_paterno' => $apellido_paterno,
				'apellido_materno' => $apellido_materno,
				'email' => $email,
				'password' => $password,
				'id_direccion' => $id_direccion,
				'id_rol' => $id_rol,
				'id_departamento' => $id_departamento,
			);
            // El id_equipo para crear el vinculo con su equipo peronal
            $id_equipo = 'id_equipo';
		
            // Hacer insercion a la tabla de usuarios
			$this->Usuario->guardar_usuario($datos);

            // Crear la conexion con su equipo


			redirect('usuario');
		}
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}

}