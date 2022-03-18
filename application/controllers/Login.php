<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('form_validation'));
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
			// Si todo salio bien, guardar los datos y mandarlos al cliente
			$data = array(
				'id' => $res->no_empleado,
				'email' => $res->email,
				'nombre' => $res->nombre,
				'apellido paterno' => $res->apellido_paterno,
				'apellido materno' => $res->apellido_materno,
				'rol' => $res->id_rol,
			);
			echo json_encode($data);
		}
	}
}
