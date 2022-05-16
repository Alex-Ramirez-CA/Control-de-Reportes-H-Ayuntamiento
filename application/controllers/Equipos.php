<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipos extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('form_validation','session'));
		$this->load->model(array('Usuario', 'Departamento', 'Rol', 'Direccion', 'Equipo', 'Equipo_usuario', 'Dependencia'));
		$this->load->helper(array('other/equipo_rules'));
	}

    // Carga el formulario de agregar usuario nuevo
    public function index()
	{
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
		
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'direcciones' => $this->Direccion->get_direcciones(),
			);
			$this->load->view('v_agregar_equipo', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}

	// Funcion para buscar el usuario al que se asociara dicho equipo
	public function buscar_empleado() {
        // Validar para que no puedan ingresar a esta direccion sin estar logeados
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
        // Recibir el valor del campo de busqueda via post
		$search_usuario = $this->input->post('search_usuario');
        // Hacer consulta a la base de datos
        if($search_usuario != '' || $search_usuario != NULL) {
            $data = $this->Usuario->buscarEmpleado($search_usuario);
        } else {
            $data = NULL;
        }
        
        echo json_encode($data);
    }

    // Funcion para guardar los datos del usuario agregado
	public function guardar_equipo() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
		// Eliminar los deliminatores que agrega por defecto la funcion form_error
		$this->form_validation->set_error_delimiters('', '');
		// Cargar las reglas de validación llamando a la función del helper
		$rules = getEquipoRules();
		$this->form_validation->set_rules($rules);
		// validar si las reglas se cumplen
		if($this->form_validation->run() == FALSE) {
			// Guardar las mensajes en caso de error de validación, dichos mensajes se encuentran en el helper
			$erros = array(
				'nombre' => form_error('nombre'),
				'sistema_operativo' => form_error('sistema_operativo'),
				'marca' => form_error('marca'),
				'inventario' => form_error('inventario'),
				'serie' => form_error('serie'),
				'direccion_ip' => form_error('direccion_ip'),
				'procesador' => form_error('procesador'),
				'segmento_de_red' => form_error('segmento_de_red'),
			);
			// Mandar respuesta al cliente
			echo json_encode($erros);
			$this->output->set_status_header(400);
		} else {

			// Validar que la direccion IP no este ya asignada a un equipo activo
			if(!$this->Equipo->direccionIpYaExistente($this->input->post('direccion_ip'))) {
				if(!$this->input->post('ram')) {
					$ram = NULL;
				} else {
					$ram = $this->input->post('ram');
				}
				if(!$this->input->post('disco_duro')) {
					$disco_duro = NULL;
				} else {
					$disco_duro = $this->input->post('disco_duro');
				}
				if(!$this->input->post('inventario_monitor')) {
					$inventario_monitor = NULL;
				} else {
					$inventario_monitor = $this->input->post('inventario_monitor');
				}
				if(!$this->input->post('serie_monitor')) {
					$serie_monitor = NULL;
				} else {
					$serie_monitor = $this->input->post('serie_monitor');
				}
				if(!$this->input->post('marca_monitor')) {
					$marca_monitor = NULL;
				} else {
					$marca_monitor = $this->input->post('marca_monitor');
				}
				if(!$this->input->post('tamano_monitor')) {
					$tamano_monitor = NULL;
				} else {
					$tamano_monitor = $this->input->post('tamano_monitor');
				}
				if(!$this->input->post('observaciones')) {
					$observaciones = NULL;
				} else {
					$observaciones = $this->input->post('observaciones');
				}
				
				// Datos para hacer la insercion en la tabla de usuario
				$datos = array(
					'direccion_ip' => $this->input->post('direccion_ip'),
					'ram' => $ram,
					'dvd' => (int)$this->input->post('dvd'),
					'procesador' => $this->input->post('procesador'),
					'inventario_monitor' => $inventario_monitor,
					'marca' => $this->input->post('marca'),
					'marca_monitor' => $marca_monitor,
					'segmento_de_red' => $this->input->post('segmento_de_red'),
					'tamano_monitor' => $tamano_monitor,
					'nombre' => $this->input->post('nombre'),
					'inventario' => $this->input->post('inventario'),
					'serie' => $this->input->post('serie'),
					'status' => 1,
					'serie_monitor' => $serie_monitor,
					'disco_duro' => $disco_duro,
					'teclado' => (int)$this->input->post('teclado'),
					'observaciones' => $observaciones,
					'mouse' => (int)$this->input->post('mouse'),
					'sistema_operativo' => $this->input->post('sistema_operativo'),
					'tipo_equipo' => $this->input->post('tipo_equipo'),
					'id_direccion' => (int)$this->input->post('id_direccion'),
				);

				if($this->input->post('tipo_equipo') === 'PC') {
					$no_empleados = $this->input->post('no_empleados');
					if(!empty($no_empleados)) {
						// validad que los usuarios no tengan PC's ya asignadas
						foreach($no_empleados as $no_empleado) {
							if($this->Equipo_usuario->usuarioTienePC($no_empleado)) {
								echo json_encode(array(
									'msg' => 'Operación fallida, el usuario con ID '.$no_empleado.', ya tiene una PC asosiada',
								));
								$this->output->set_status_header(500);
								exit;
							}
						}
						// Hacer insercion a la tabla de equipos
						$this->Equipo->guardar_equipo($datos);
						// Crear el vinculo entre el equipo personal y su usuario en caso de ser necesario
						// Obtener el id_equipo por su direccion ip
						$res = $this->Equipo->obtenerIdEquipo($this->input->post('direccion_ip'));
						$id_equipo = $res->id_equipo;
						foreach($no_empleados as $no_empleado) {
							$data = array(
								'id_equipo' => $id_equipo,
								'no_empleado' => $no_empleado,
							);
							$this->Equipo_usuario->insertar($data);
						}
						
					} else {
						// Solo insertar los datos del equipo sin asignarle usuarios
						$this->Equipo->guardar_equipo($datos);
					}
					
				} else if($this->input->post('tipo_equipo') === 'Impresora') {
					// verificar que si se va a insertar una impresora, que no esxita otra activa 
					// relacionada con la misma direccion
					if(!$this->Equipo->obtenerImpresora((int)$this->input->post('id_direccion'))) {
						// Hacer insercion a la tabla de equipos
						$this->Equipo->guardar_equipo($datos);
						// Crear el vinculo entre la impresora y la direccion a la que pertenece
						if($res = $this->Equipo->obtenerImpresora((int)$this->input->post('id_direccion'))) {
							$id_equipo = $res->id_equipo;
							if($usuarios = $this->Usuario->getUsuariosbyDireccion((int)$this->input->post('id_direccion'))) {
								foreach($usuarios as $usuario) {
									$no_empleado = $usuario->no_empleado;
									$data = array(
										'id_equipo' => $id_equipo,
										'no_empleado' => $no_empleado,
									);
									$this->Equipo_usuario->insertar($data);
								}
							}
							
						}
					} else {
						echo json_encode(array(
							'msg' => 'Esta dirección ya tiene una impresora activa asociada',
						));
						$this->output->set_status_header(500);
						exit;
					}
				}
				
				echo json_encode(array(
					'msg' => 'Equipo agregado correctamente',
					'url' => base_url('equipos'),
				));	
			} else {
				echo json_encode(array(
					'msg' => 'La Dirección IP ya esta asignada a otro equipo activo. Intenta con otra o da de baja dicho equipo',
					'url' => base_url('equipos'),
				));	
			}
		}
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}

	// Funcion que trae los datos de todos los equipos existentes
	public function lista_equipos() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'direcciones' => $this->Direccion->get_direcciones(),
				'dependencias' => $this->Dependencia->get_dependencias(),
			);
			$this->load->view('v_listar_equipos', $data);
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}
	
	// Funcion que trae los datos de todos los usuarios existentes
	public function obtener_listaEquipos() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			// Validar que existan usuarios
			if($res = $this->Equipo->getEquipos()) {
				echo json_encode($res);
			}
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Filtrar los equipos
	public function filtrar_equipos() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			
			$dependencia = $this->input->post('dependencia');
			$direccion = $this->input->post('direccion');
			$status = $this->input->post('status');
			$tipo_equipo = $this->input->post('tipo_equipo');
			
			if($dependencia === ""){
				$dependencia = NULL;
			}
			if($direccion === ""){
				$direccion = NULL;
			}
			if($status === ""){
				$status = NULL;
			}
			if($tipo_equipo === ""){
				$tipo_equipo = NULL;
			}
			$data = $this->Equipo->filtrarEquipos($dependencia, $direccion, $status, $tipo_equipo);
			echo json_encode($data);
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Funcion que permitira actualizar el status de un usuario
	public function modificar_status() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			$status = (int)$this->input->post('status');
			$id_equipo = (int)$this->input->post('id_equipo');
			if($this->Equipo->direccionIpYaExistente($this->input->post('direccion_ip')) && $status === 1){
				echo json_encode(array(
					'msg' => 'Ya existe un equipo activo con la misma Dirección IP',
				));
			} else {
				$this->Equipo->statusEquipo($status, $id_equipo);
			}
			
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Funcion para el campo de busqueda de equipos
	public function buscar_equipo() {
        // Validar para que no puedan ingresar a esta direccion sin estar logeados
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
        // Recibir el valor del campo de busqueda via post
		$search_equipo = $this->input->post('search_equipo');
        // Hacer consulta a la base de datos
        if($search_equipo != '' || $search_equipo != NULL) {
            $data = $this->Equipo->buscarEquipobyNameAndIP($search_equipo);
        } else {
            $data = false;
        }
        
        echo json_encode($data);
    }

	// Funcion para cuando se clicke el boton de estidar equipo
	public function editar_equipo($id_equipo) {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'direcciones' => $this->Direccion->get_direcciones(),
				'datos_equipo' => $this->Equipo->getEquipo($id_equipo),
				'usuarios' => $this->Equipo_usuario->obtener_usuarios($id_equipo),
			);
			// Cargar la vista y mandar los datos
			$this->load->view('v_editar_equipo', $data);
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Funcion que guarda los cambios realizados en los datos del usuario de forma tradicional
	public function actualizar_equipo() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			// Eliminar los deliminatores que agrega por defecto la funcion form_error
			$this->form_validation->set_error_delimiters('', '');
			// Cargar las reglas de validación llamando a la función del helper
			$rules = getEquipoRules();
			$this->form_validation->set_rules($rules);
			// validar si las reglas se cumplen
			if($this->form_validation->run() == FALSE) {
				// Guardar las mensajes en caso de error de validación, dichos mensajes se encuentran en el helper
				$erros = array(
					'nombre' => form_error('nombre'),
					'sistema_operativo' => form_error('sistema_operativo'),
					'marca' => form_error('marca'),
					'inventario' => form_error('inventario'),
					'serie' => form_error('serie'),
					'direccion_ip' => form_error('direccion_ip'),
					'procesador' => form_error('procesador'),
					'segmento_de_red' => form_error('segmento_de_red'),
				);
				// Mandar respuesta al cliente
				echo json_encode($erros);
				$this->output->set_status_header(400);
			} else {
				// Si pasa la validación, realizar el proceso de actualizado
				// Datos para hacer la actualización en la tabla de usuario
				$datos = array(
					'direccion_ip' => $this->input->post('direccion_ip'),
					'ram' => $this->input->post('ram'),
					'dvd' => (int)$this->input->post('dvd'),
					'procesador' => $this->input->post('procesador'),
					'inventario_monitor' => $this->input->post('inventario_monitor'),
					'marca' => $this->input->post('marca'),
					'marca_monitor' => $this->input->post('marca_monitor'),
					'segmento_de_red' => $this->input->post('segmento_de_red'),
					'tamano_monitor' => $this->input->post('tamano_monitor'),
					'nombre' => $this->input->post('nombre'),
					'inventario' => $this->input->post('inventario'),
					'serie' => $this->input->post('serie'),
					'status' => 1,
					'serie_monitor' => $this->input->post('serie_monitor'),
					'disco_duro' => $this->input->post('disco_duro'),
					'teclado' => (int)$this->input->post('teclado'),
					'observaciones' => $this->input->post('observaciones'),
					'mouse' => (int)$this->input->post('mouse'),
					'sistema_operativo' => $this->input->post('sistema_operativo'),
					'tipo_equipo' => $this->input->post('tipo_equipo'),
					'id_direccion' => (int)$this->input->post('id_direccion'),
				);

				// Obtener el id_equipo vía post
				$id_equipo = (int)$this->input->post('id_equipo');

				// Cuando es de tipo Impresora
				if($this->input->post('tipo_equipo') === 'Impresora') {
					// Si se modifica la direccion a la que pertenece la impresora
					// Verificar si la direccion cambio
					if((int)$this->input->post('id_direccion_modif') === 1) {
						// verificar que si se va a insertar una impresora, que no esxita otra activa 
						// relacionada con la misma direccion
						if(!$this->Equipo->obtenerImpresora((int)$this->input->post('id_direccion'))) {
							// Eliminar los registros que asocian dicha impresora con los usuarios 
							// de la antigua direccion
							$this->Equipo_usuario->borrarRelacion($id_equipo);
							// Desues del borrado proceder a hacer los nuevos registros
							if($usuarios = $this->Usuario->getUsuariosbyDireccion((int)$this->input->post('id_direccion'))) {
								foreach($usuarios as $usuario) {
									$no_empleado = $usuario->no_empleado;
									$data = array(
										'id_equipo' => $id_equipo,
										'no_empleado' => $no_empleado,
									);
									$this->Equipo_usuario->insertar($data);
								}
							}
						} else {
							echo json_encode(array(
								'msg' => 'Esta dirección ya tiene una impresora activa asociada',
							));
							$this->output->set_status_header(500);
							exit;
						}
					}
				}
				
				// Cuando es de tipo PC
				if($this->input->post('tipo_equipo') === 'PC') {
					// Si los usuarios asignados a la PC son modificados
					if((int)$this->input->post('no_empleados_modif') === 1) {
						// Eliminar los registros que asocian la PC con sus usuarios
						$this->Equipo_usuario->borrarRelacion($id_equipo);
						$no_empleados = $this->input->post('no_empleados');
						if(!empty($no_empleados)) {
							// validar que los usuarios no tengan PC's ya asignadas
							foreach($no_empleados as $no_empleado) {
								if($this->Equipo_usuario->usuarioTienePC($no_empleado)) {
									echo json_encode(array(
										'msg' => 'Operación fallida, el usuario con ID '.$no_empleado.', ya tiene una PC asosiada',
									));
									$this->output->set_status_header(500);
									exit;
								}
							}
							foreach($no_empleados as $no_empleado) {
								$data = array(
									'id_equipo' => $id_equipo,
									'no_empleado' => $no_empleado,
								);
								$this->Equipo_usuario->insertar($data);
							}	
						}
					}
				}
				
				// Hacer actualización de la tabla de equipo
				$this->Equipo->update_equipo($id_equipo, $datos);

				echo json_encode(array(
					'msg' => 'Equipo actualizado correctamente',
					'url' => base_url('equipos/lista_equipos'),
				));
			}
			

		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

}