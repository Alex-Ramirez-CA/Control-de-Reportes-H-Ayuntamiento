<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model(array('Incidencia', 'Atender_incidencia', 'Archivo'));
	}
    
    public function index()
	{
        // $id_incidencia = 1;
		// $generales = $this->Incidencia->datos_reporte($id_incidencia);
		// $comentarios = $this->Atender_incidencia->get_comentarios($id_incidencia);
		// $archivos = $this->Archivo->get_archivos($id_incidencia);
        $data = array(
			'head' => $this->load->view('layout/head', '', TRUE),
			'footer' => $this->load->view('layout/footer', '', TRUE)
		);
		
		$this->load->view('v_reporte', $data);
	}

    // Recibe un id desde la vista y traes los datos necesario para crear el reporte
    public function generar_reporte($id_incidencia){
        // $id_incidencia = 1;
		$generales = $this->Incidencia->datos_reporte($id_incidencia);
		$comentarios = $this->Atender_incidencia->get_comentarios($id_incidencia);
		$archivos = $this->Archivo->get_archivos($id_incidencia);
        $data = array(
            'generales' => $generales,
            'comentarios' => $comentarios,
            'archivos' => $archivos
		);
        echo json_encode($data);
    }

}