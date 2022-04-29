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
                // Hacer insercion a la tabla de equipos
                $this->Equipo->guardar_equipo($datos);
                // Crear el vinculo entre el equipo personal y su usuario en caso de ser necesario
                $no_empleado = (int)$this->input->post('no_empleado');
				if($no_empleado != 0) {
					// Obtener el id_equipo por su direccion ip
					$res = $this->Equipo->obtenerIdEquipo($this->input->post('direccion_ip'));
					$id_equipo = $res->id_equipo;
					$data = array(
						'id_equipo' => $id_equipo,
						'no_empleado' => $no_empleado,
					);
					$this->Equipo_usuario->insertar($data);
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
                        'url' => base_url('equipos'),
                    ));
                    $this->output->set_status_header(500);
					exit;
                }
            }
			
            echo json_encode(array(
				'msg' => 'Equipo agregado correctamente',
				'url' => base_url('equipos'),
			));
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
			$segmento_de_red = $this->input->post('segmento_de_red'); 
			$dependencia = $this->input->post('dependencia');
			$direccion = $this->input->post('direccion');
			$status = $this->input->post('status');
			
			if($segmento_de_red === ""){
				$segmento_de_red = NULL;
			}
			if($dependencia === ""){
				$dependencia = NULL;
			}
			if($direccion === ""){
				$direccion = NULL;
			}
			if($status === ""){
				$status = NULL;
			}
			$data = $this->Equipo->filtrarEquipos($segmento_de_red,  $dependencia, $direccion, $status);
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
			$this->Equipo->statusEquipo($status, $id_equipo);
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
	public function editar_equipo(/*$id_equipo*/) {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			
			$data = array(
				// 'head' => $this->load->view('layout/head', '', TRUE),
				// 'nav' => $this->load->view('layout/nav', '', TRUE),
				// 'footer' => $this->load->view('layout/footer', '', TRUE),
				'direcciones' => $this->Direccion->get_direcciones(),
				'datos_equipo' => $this->Equipo->getEquipo(1),
				'usuarios' => $this->Equipo->getEquipo(1),
			);
			// Cargar la vista y mandar los datos
			// $this->load->view('v_editar_equipo', $data);
			echo json_encode($data);
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Funcion que guarda los cambios realizados en los datos del usuario de forma tradicional
	public function actualizar_usuario() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			// Proceso de validación del formulario
			// Eliminar los deliminatores que agrega por defecto la funcion form_error
			$this->form_validation->set_error_delimiters('', '');
			// Cargar las reglas de validación llamando a la función del helper
			$rules = getUsuarioRules();
			$this->form_validation->set_rules($rules);
			// validar si las reglas se cumplen
			if($this->form_validation->run() == FALSE) {
				// Guardar las mensajes en caso de error de validación, dichos mensajes se encuentran en el helper
				$erros = array(
					'nombre' => form_error('nombre'),
					'apellido_paterno' => form_error('apellido_paterno'),
					'apellido_materno' => form_error('apellido_materno'),
					'email' => form_error('email'),
					'password' => form_error('password'),
					'id_equipo' => form_error('id_equipo'),
				);
				// Mandar respuesta al cliente
				echo json_encode($erros);
				$this->output->set_status_header(400);
			} else {
				// Si pasa la validación, realizar el proceso de actualizado
				// Datos para hacer la actualizacón del usuario
				$datos = array(
					'nombre' => $this->input->post('nombre'),
					'apellido_paterno' => $this->input->post('apellido_paterno'),
					'apellido_materno' => $this->input->post('apellido_materno'),
					'email' => $this->input->post('email'),
					'password' => $this->input->post('password'),
					'id_direccion' => (int)$this->input->post('id_direccion'),
					'id_rol' => (int)$this->input->post('id_rol'),
					'id_departamento' => (int)$this->input->post('id_departamento'),
				);

				// Obtener el no_empleado vía post
				$no_empleado = (int)$this->input->post('no_empleado');

				// Si la direccion a la que pertenece es modificada
				// Modificar tambien la impresora a la que estara asociado el usuario
				$oldDireccion = $this->Usuario->obtenerDireccion($no_empleado);
				$oldDireccion = $oldDireccion->id_direccion;
				$newDireccion = (int)$this->input->post('id_direccion');
				if($oldDireccion !== $newDireccion){
					// Obtener el id_equipo de la impresora a la que estaba asignado dicho usuario anteriormente
					if($res = $this->Equipo->obtenerOldImpresora($no_empleado)) {
						$old_id_equipo = $res->id_equipo;
						// Obtener el id_equipo de la impresora de la nueva direccion
						if($res = $this->Equipo->obtenerImpresora($newDireccion)) {
							$id_equipo = $res->id_equipo;
							// Realizar la actualizacion
							$this->Equipo_usuario->updateEquipo($id_equipo, $no_empleado, $old_id_equipo);
						}
					}
				}
				
				// Si el equipo PC del usuario es modificado
				// Actualizar el equipo o PC del suarios
				// Obtener el id_equipo vía post
				$id_equipo = (int)$this->input->post('id_equipo');
				// Obtner el id del antiguo equipo del usuario
				if($res = $this->Equipo->obtenerPC($no_empleado)) {
					$old_id_equipo = $res->id_equipo;
					// Realizar la actualizacion
					$this->Equipo_usuario->updateEquipo($id_equipo, $no_empleado, $old_id_equipo);
				}

				// Hacer actualización de la tabla de usuarios
				$this->Usuario->update_usuario($no_empleado, $datos);
				echo json_encode(array(
					'msg' => 'Usuario actualizado correctamente',
					'url' => base_url('usuarios/lista_usuarios'),
				));
			}
			

		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

}