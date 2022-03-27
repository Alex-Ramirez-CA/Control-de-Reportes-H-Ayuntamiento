<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model(array('Incidencia', 'Atender_incidencia'));
	}
    
    public function index()
	{
        
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