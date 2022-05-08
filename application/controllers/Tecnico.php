<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnico extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model(array('Incidencia', 'Atender_incidencia', 'Estatus_por_usuario'));
	}

	public function index()
	{
		// validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el departamento al que pertenece el tecnico
			$id_departamento = $this->session->userdata('id_departamento');
			// Obtener incidencias pendientes
			$status = 0;
			$res_0 = $this->Incidencia->get_incidenciasDepar($id_departamento, $status);
			// Obtener incidencias en proceso
			$status = 1;
			$res_1 = $this->Incidencia->get_incidenciasDepar($id_departamento, $status);
			// Obtener incidencias en proceso
			$status = 2;
			$res_2 = $this->Incidencia->get_incidenciasDepar($id_departamento, $status);
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'pendientes' => $res_0,
				'en_proceso' => $res_1,
				'finalizados' => $res_2,
			);
			// Cargar la vista
        	$this->load->view('v_tecnico', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}

	// Funcion que resgistrara cuando un tercnico le de atender una incidencia
	public function atender() {
		// validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
			// Recibir id_incidencia vía post
			$id_incidencia = (int)$this->input->post('id_incidencia');
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
			// Agregar registro
			$this->Atender_incidencia->insertar($data);
			// Cambiar el estatus de la incidencia a en_proceso
			$this->Incidencia->modificar_status($id_incidencia, 1);
			
			// Asignarle el status de esa incidencia con relacion al tecnico que la cambio
			$datos = array(
				'id_incidencia' => $id_incidencia,
				'no_empleado' => $no_empleado,
				'status' => 1,
			);
			$this->Estatus_por_usuario->insertar($datos);

			
			echo json_encode(array('url' => base_url('tecnico')));
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Funcion que llevara a cabo el proceso de vincular la incidenica con el tecnico
	// Responde al boton de unirme
	public function unirme() {
		// validar que el usuario este logeado y sea de tipo tecnico
        if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 2) {
			// Obtener el id del empleado de los datos de sesion
			$no_empleado = $this->session->userdata('id');
			// Recibir id_incidencia vía post
			$id_incidencia = $this->input->post('id_incidencia');
			// Recibir el comentario vía post
			$comentario = $this->input->post('comentario');
			// Se hace una consulta a la bd para verificar que dicho usuario no haya
			// atendido antes dicho incidencia y no repetir registros
			if($this->Atender_incidencia->verificar($id_incidencia, $no_empleado)) {
				echo json_encode(array(
					'msg' => 'Ya se había unido con anterioridad',
					'url' => base_url('tecnico')
				));
			} else {
				//Obtener la fecha del sistema
				date_default_timezone_set('America/Mexico_City');
				$fecha = date("Y-m-d h:i:s", time());
				$data = array(
					'no_empleado' => $no_empleado,
					'id_incidencia' => $id_incidencia,
					'comentario' => $comentario,
					'fecha' => $fecha,
				);
				// Agregar registro
				$this->Atender_incidencia->insertar($data);

				// Asignarle el status de esa incidencia con relacion al tecnico que la cambio
				$datos = array(
					'id_incidencia' => $id_incidencia,
					'no_empleado' => $no_empleado,
					'status' => 1,
				);
				$this->Estatus_por_usuario->insertar($datos);
				
				echo json_encode(array(
					'msg' => 'Se ha unido para la solución del reporte',
					'url' => base_url('tecnico')
				));
				//redirect('tecnico');
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
			
			// Se verifica si dicho usuario ya atendia esta incidecnia o apenas se unira a ella
			if(!$this->Atender_incidencia->verificar($id_incidencia, $no_empleado)) {
				// Se agrega otra insercion
				$this->Atender_incidencia->insertar($data);
				// Hacer la incercion a la tabla de Estatus_por_usuario
				// Asignarle el status de esa incidencia con relacion al tecnico que la cambio
				$datos = array(
					'id_incidencia' => $id_incidencia,
					'no_empleado' => $no_empleado,
					'status' => 1,
				);
				$this->Estatus_por_usuario->insertar($datos);
			} else {
				// Se agrega otra insercion
				$this->Atender_incidencia->insertar($data);
				// Hacer solo la actualizacion a la tabla de Estatus_por_usuario
				// Actualizar el status de la incidencia que le asigno este usuario de finalizada a en proceso
				$this->Estatus_por_usuario->updateEstatus($id_incidencia, $no_empleado, 1);
				//Obtener el valor de la variable contador
				$res = $this->Incidencia->getValorContador($id_incidencia);
				$contador = $res->contador;
				// Restarle 1 al contador
				$this->Incidencia->updateContador($id_incidencia, ($contador - 1));
			}
			// Se le vuelve a cambiar el estatus a la misma a 1 = en proceso
			$this->Incidencia->modificar_status($id_incidencia, 1);
			// Actualizar la fecha de cierre a NULL
			$this->Incidencia->update_fechaCierre($id_incidencia, NULL);
			echo json_encode(array(
				'msg' => 'Reabriste la incidencia',
				'url' => base_url('tecnico')
			));

		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	public function recargar() {
		echo json_encode(array('url' => base_url('tecnico')));
	}

}