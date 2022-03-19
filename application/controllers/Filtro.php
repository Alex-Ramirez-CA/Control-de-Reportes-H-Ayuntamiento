<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filtro extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
	}

	public function index()
	{
		$data = array(
			'head' => $this->load->view('layout/head', '', TRUE),
			'nav' => $this->load->view('layout/nav', '', TRUE),
			'footer' => $this->load->view('layout/footer', '', TRUE),
		);

        if($this->session->userdata('id_rol') == 1) {
        	$this->load->view('v_Filtro', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}

}