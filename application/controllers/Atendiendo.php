<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atendiendo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model(array('Incidencia', 'Atender_incidencia', 'Estatus_por_usuario'));
	}

	public function index()
	{
        // validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
            // Obtener el departamento al que pertenece el tecnico
			$id_departamento = $this->session->userdata('id_departamento');
			// Obtener incidencias en proceso
			$status = 1;
			$res_1 = $this->Incidencia->get_incidenciasQueAtiendiendo($id_departamento, $status, $no_empleado);
			// Obtener incidencias en proceso
			$status = 2;
			$res_2 = $this->Incidencia->get_incidenciasQueAtiendiendo($id_departamento, $status, $no_empleado);
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'en_proceso' => $res_1,
				'finalizados' => $res_2,
			);
			// Cargar la vista
        	$this->load->view('v_atendiendo', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}

	// Lo unico que hara esta funcion es pasar el estatus de dicha incidencia a 2 = finalizado
	public function finalizar(){
		// validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
			// Recibir id_incidencia vía post
			$id_incidencia = (int)$this->input->post('id_incidencia');

			// Verificar si este tecnico no habia finalizado ya antes esta incidencia
			$status = $this->Estatus_por_usuario->verificarEstatus($id_incidencia, $no_empleado);
			$status = $status->status;
			if($status != 2) {

				// Actualizar el status de la incidencia que le asigno este usuario
				$this->Estatus_por_usuario->updateEstatus($id_incidencia, $no_empleado, 2);
				// Recibir el comentario vía post
				$comentario = $this->input->post('comentario');
				//Obtener la fecha del sistema
				date_default_timezone_set('America/Mexico_City');
				$fecha = date("Y-m-d h:i:s", time());
				$data = array(
					'no_empleado' => $no_empleado,
					'id_incidencia' => $id_incidencia,
					'comentario' => $comentario,
					'fecha' => $fecha,
				);
				// Hacer la insercion del registro
				$this->Atender_incidencia->insertar($data);
				
				// Hacer el proceso de finalizar incidencia
				//Obtener el valor de la variable contador
				$res = $this->Incidencia->getValorContador($id_incidencia);
				$contador = $res->contador;
				// Sumarle 1 al contador
				$this->Incidencia->updateContador($id_incidencia, ($contador + 1));
				// Verificar si el valor de contador actualizado coincide con el del
				// numero de tecnicos que atienden dicha incidencia
				$res = $this->Atender_incidencia->noParticipantes($id_incidencia);
				$cantidad = $res->cantidad;
				$res = $this->Incidencia->getValorContador($id_incidencia);
				$contador = $res->contador;
				if($cantidad === $contador) {
					// Si los valores son iguales significan que todos los tecnicos le han dado
					// finalizar a la incidencia, por lo cual si se puede cambiar la misma a status finalizada
					// Cambiar el estatus de la incidencia a finalizada
					$this->Incidencia->modificar_status($id_incidencia, 2);
					// Agregar la fecha de cierre
					$this->Incidencia->update_fechaCierre($id_incidencia, $fecha);
				} else {
					echo json_encode(array(
						'msg' => 'Listo, esta finalizara cuando todos los técnicos le den finalizar',
						'url' => base_url('atendiendo')
					));
					exit;
				}
				
				echo json_encode(array(
					'msg' => 'Incidencia finalizada',
					'url' => base_url('atendiendo')
				));

			} else {
				echo json_encode(array(
					'msg' => 'Usted ya ha dado por finalizada esta Incidencia',
					'url' => base_url('atendiendo')
				));
			}

		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}


	// Funcion que reabrira una incidenia para pasarla a en_proceso y en caso de que no
	// Unira al usuario a la solucion de esta
	public function reabrir() {
		// validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
			// Recibir id_incidencia vía post
			$id_incidencia = $this->input->post('id_incidencia');
			// Recibir el comentario vía post
			$comentario = $this->input->post('comentario');
			//Obtener la fecha del sistema
			date_default_timezone_set('America/Mexico_City');
			$fecha = date("Y-m-d h:i:s", time());
			$data = array(
				'no_empleado' => $no_empleado,
				'id_incidencia' => $id_incidencia,
				'comentario' => $comentario,
				'fecha' => $fecha,
			);
			
			// Se agrega otra insercion
			$this->Atender_incidencia->insertar($data);
			//Obtener el valor de la variable contador
			$res = $this->Incidencia->getValorContador($id_incidencia);
			$contador = $res->contador;
			// Restarle 1 al contador
			$this->Incidencia->updateContador($id_incidencia, ($contador - 1));
			// Se le vuelve a cambiar el estatus a la misma a 1 = en proceso
			$this->Incidencia->modificar_status($id_incidencia, 1);
			// Actualizar la fecha de cierre a NULL
			$this->Incidencia->update_fechaCierre($id_incidencia, NULL);
			echo json_encode(array(
				'msg' => 'Reabriste la incidencia',
				'url' => base_url('atendiendo')
			));

		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

}