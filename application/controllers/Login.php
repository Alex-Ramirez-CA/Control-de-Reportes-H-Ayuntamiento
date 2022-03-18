<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
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
		$usr = $this->input->post('email');
		$pass = $this->input->post('password');
		if(!$res = $this->Auth->login($usr, $pass)){
			echo json_encode(array('msg' => 'Verifique sus credenciales'));
			$this->output->set_status_header(401);
			exit;
		}
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
