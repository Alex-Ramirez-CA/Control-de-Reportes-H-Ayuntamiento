<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Auth');
	}

	public function index()
	{
		$this->load->view('login');
		// var_dump($this->Autenticacion->login('emiramirez991@gmail.com', '1234'));
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
		);
		echo json_encode($data);
	}
}
