<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('form_validation','session'));
		$this->load->helper(array('auth/login_rules'));
		$this->load->model('Auth');
	}

	public function index()
	{
		$data = array(
			'head' => $this->load->view('layout/head', '', TRUE),
			'footer' => $this->load->view('layout/footer', '', TRUE),
		);
		
		$this->load->view('v_login', $data);
	}

	public function validar() {
		// Eliminar los deliminatores que agrega por defecto la funcion form_error
		$this->form_validation->set_error_delimiters('', '');
		// Cargar las reglas de validación llamando a la función del helper
		$rules =  getLoginRules();
		$this->form_validation->set_rules($rules);
		// validar si las reglas se cumplen
		if($this->form_validation->run() == FALSE) {
			// Guardar las mensajes en caso de error de validación, dichos mensajes se encuentran en el helper
			$erros = array(
				'email' => form_error('email'),
				'password' => form_error('password'),
			);
			// Mandar respuesta al cliente
			echo json_encode($erros);
			$this->output->set_status_header(400);
		} else {
			// Si se pasa la validacion del formulario recibir los datos del formulario via post
			$usr = $this->input->post('email');
			$pass = $this->input->post('password');
			// Hacer petición al modelo y gardarla en una variable
			if(!$res = $this->Auth->login($usr, $pass)){
				// Si el modelo retorna falso mandar la siguiente respuesta al cliente
				echo json_encode(array('msg' => 'Verifique sus credenciales'));
				$this->output->set_status_header(401);
				exit;
			}
			// Guardar los datos de la consulta
			$data = array(
				'id' => $res->no_empleado,
				'email' => $res->email,
				'nombre' => $res->nombre,
				'apellido_paterno' => $res->apellido_paterno,
				'apellido_materno' => $res->apellido_materno,
				'id_rol' => $res->id_rol,
				'rol_nombre' => $res->rol_nombre,
				'id_departamento' => $res->id_departamento,
			);
			// Crear sesion de usuario
			$this->session->set_userdata($data);
			$this->session->set_flashdata('msg', 'Bienvenido al sistema '.$data['nombre']);
			// Mandar la url
			echo json_encode(array('url' => base_url($data['rol_nombre'])));
		}
	}

	// Funcion para cerrar sesion
	public function logout() {
		$vars = array(
			'id',
			'email',
			'nombre',
			'apellido paterno',
			'apellido materno',
			'id_rol',
			'rol_nombre',
			'id_departamento',
		);
		$this->session->unset_userdata($vars);
		$this->session->sess_destroy();
		redirect('login');
	}
}
