<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('form_validation','session'));
		$this->load->model(array('Usuario', 'Departamento', 'Rol', 'Direccion', 'Equipo', 'Equipo_usuario', 'Dependencia'));
		$this->load->helper(array('user/usuario_rules'));
	}

    // Carga el formulario de agregar usuario nuevo
    public function index()
	{
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
		
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
                'departamentos' => $this->Departamento->get_departamentos(),
                'roles' => $this->Rol->get_roles(),
				'direcciones' => $this->Direccion->get_direcciones(),
			);
			$this->load->view('v_agregar_usuario', $data);
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
		
	}

	// Funcion para el campo de busqueda de equipos
	public function buscar_direccionIP() {
        // Validar para que no puedan ingresar a esta direccion sin estar logeados
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
        // Recibir el valor del campo de busqueda via post
		$search_IP = $this->input->post('search_IP');
        // Hacer consulta a la base de datos
        if($search_IP != '' || $search_IP != NULL) {
            $data = $this->Equipo->buscarDireccionIP($search_IP);
        } else {
            $data = false;
        }
        
        echo json_encode($data);
    }

	// Funcion para buscar usuarios
	public function buscar_empleado() {
        // Validar para que no puedan ingresar a esta direccion sin estar logeados
		if(!$this->session->has_userdata('id_rol')){
            redirect('login');
        }
        // Recibir el valor del campo de busqueda via post
		$search_empleado = $this->input->post('search_empleado');
        // Hacer consulta a la base de datos
        if($search_empleado != '' || $search_empleado != NULL) {
            $data = $this->Usuario->buscarUsuarios($search_empleado);
        } else {
            $data = NULL;
        }
        
        echo json_encode($data);
    }

    // Funcion para guardar los datos del usuario agregado
	public function guardar_usuario() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
		// Eliminar los deliminatores que agrega por defecto la funcion form_error
		$this->form_validation->set_error_delimiters('', '');
		// Cargar las reglas de validaci??n llamando a la funci??n del helper
		$rules = getUsuarioRules();
		$this->form_validation->set_rules($rules);
		// validar si las reglas se cumplen
		if($this->form_validation->run() == FALSE) {
			// Guardar las mensajes en caso de error de validaci??n, dichos mensajes se encuentran en el helper
			$erros = array(
				'nombre' => form_error('nombre'),
				'apellido_paterno' => form_error('apellido_paterno'),
				'apellido_materno' => form_error('apellido_materno'),
				'email' => form_error('email'),
				'password' => form_error('password'),
				'id_direccion' => form_error('id_direccion'),
				'id_rol' => form_error('id_rol'),
				'id_departamento' => form_error('id_departamento'),
				//'id_equipo' => form_error('id_equipo'),
			);
			// Mandar respuesta al cliente
			echo json_encode($erros);
			$this->output->set_status_header(400);
		} else {
			
			// Datos para hacer la insercion en la tabla de usuario
			$datos = array(
				'nombre' => $this->input->post('nombre'),
				'apellido_paterno' => $this->input->post('apellido_paterno'),
				'apellido_materno' => $this->input->post('apellido_materno'),
				'email' => $this->input->post('email'),
				'password' => md5($this->input->post('password')),
				'status' => 1,
				'id_direccion' => (int)$this->input->post('id_direccion'),
				'id_rol' => (int)$this->input->post('id_rol'),
				'id_departamento' => (int)$this->input->post('id_departamento'),
			);

			// Hacer insercion a la tabla de usuarios
			$this->Usuario->guardar_usuario($datos);
			
			// Obtener el numero de empleado por su email
			$res = $this->Usuario->obtenerNoEmpleado($this->input->post('email'));
			$no_empleado = $res->no_empleado;

			// Crear el vinculo entre el usuario y su equipo personal
			if($this->input->post('id_equipo')) { // Validar que si se haya asignado un equipo
				$data = array(
					'id_equipo' => (int)$this->input->post('id_equipo'),
					'no_empleado' => $no_empleado,
				);
				$this->Equipo_usuario->insertar($data);
			}
			

			// Crear el vinculo del usuario con la impresora de su direccion
			// Validar que dicha direccion si tenga ya una impresora
			if($res = $this->Equipo->obtenerImpresora((int)$this->input->post('id_direccion'))) {
				foreach($res as $id_equipo) {
					$data = array(
						'id_equipo' => $id_equipo->id_equipo,
						'no_empleado' => $no_empleado,
					);
					$this->Equipo_usuario->insertar($data);
				}
				
			}

			echo json_encode(array(
				'msg' => 'Usuario agregado correctamente',
				'url' => base_url('usuarios'),
			));
		}
        } else {
            // Si no hay datos de sesion redireccionar a login
            redirect('login');
        }
	}

	// Funcion que trae los datos de todos los usuarios existentes
	public function lista_usuarios() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
				'departamentos' => $this->Departamento->get_departamentos(),
				'roles' => $this->Rol->get_roles(),
				'direcciones' => $this->Direccion->get_direcciones(),
				'dependencias' => $this->Dependencia->get_dependencias(),
			);
			$this->load->view('v_listar_usuarios', $data);
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}
	
	// Funcion que trae los datos de todos los usuarios existentes
	public function obtener_lista() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			// Validar que existan usuarios
			if($res = $this->Usuario->getUsuarios()) {
				echo json_encode($res);
			}
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Filtrar los usuarios
	public function filtrar_usuarios() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			$rol = $this->input->post('rol');
			$departamento = $this->input->post('departamento'); 
			$dependencia = $this->input->post('dependencia');
			$direccion = $this->input->post('direccion');
			$status = $this->input->post('status');
			if($rol === ""){
				$rol = NULL;
			}
			if($departamento === ""){
				$departamento = NULL;
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
			$data = $this->Usuario->filtrarUsuarios($rol, $departamento,  $dependencia, $direccion, $status);
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
			$no_empleado = (int)$this->input->post('no_empleado');
			$this->Usuario->statusUsuario($status, $no_empleado);
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Funcion para cuando se clicke el boton de estidar usuario
	public function editar_usuario($no_empleado) {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
                'departamentos' => $this->Departamento->get_departamentos(),
                'roles' => $this->Rol->get_roles(),
				'direcciones' => $this->Direccion->get_direcciones(),
				'datos_usuario' => $this->Usuario->getUsuario($no_empleado),
				'PC_usuario' => $this->Equipo->obtenerPC($no_empleado),
			);
			// Cargar la vista y mandar los datos
			$this->load->view('v_editar_usuario', $data);
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Funcion que guarda los cambios realizados en los datos del usuario de forma tradicional
	public function actualizar_usuario() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			// Proceso de validaci??n del formulario
			// Eliminar los deliminatores que agrega por defecto la funcion form_error
			$this->form_validation->set_error_delimiters('', '');
			// Cargar las reglas de validaci??n llamando a la funci??n del helper
			$rules = getUsuarioRules();
			$this->form_validation->set_rules($rules);
			// validar si las reglas se cumplen
			if($this->form_validation->run() == FALSE) {
				// Guardar las mensajes en caso de error de validaci??n, dichos mensajes se encuentran en el helper
				$erros = array(
					'nombre' => form_error('nombre'),
					'apellido_paterno' => form_error('apellido_paterno'),
					'apellido_materno' => form_error('apellido_materno'),
					'email' => form_error('email'),
					'password' => form_error('password'),
				);
				// Mandar respuesta al cliente
				echo json_encode($erros);
				$this->output->set_status_header(400);
			} else {
				// Si pasa la validaci??n, realizar el proceso de actualizado
				// validar si el password se modifico, para agregarlo a los datos que se actualizaran
				if((int)$this->input->post('password_modif') === 1) {
					// Datos para hacer la actualizac??n del usuario
					$datos = array(
						'nombre' => $this->input->post('nombre'),
						'apellido_paterno' => $this->input->post('apellido_paterno'),
						'apellido_materno' => $this->input->post('apellido_materno'),
						'email' => $this->input->post('email'),
						'password' => md5($this->input->post('password')),
						'id_direccion' => (int)$this->input->post('id_direccion'),
						'id_rol' => (int)$this->input->post('id_rol'),
						'id_departamento' => (int)$this->input->post('id_departamento'),
					);
				} else {
					// Datos para hacer la actualizac??n del usuario
					$datos = array(
						'nombre' => $this->input->post('nombre'),
						'apellido_paterno' => $this->input->post('apellido_paterno'),
						'apellido_materno' => $this->input->post('apellido_materno'),
						'email' => $this->input->post('email'),
						'id_direccion' => (int)$this->input->post('id_direccion'),
						'id_rol' => (int)$this->input->post('id_rol'),
						'id_departamento' => (int)$this->input->post('id_departamento'),
					);
				}
				

				// Obtener el no_empleado v??a post
				$no_empleado = (int)$this->input->post('no_empleado');

				// Cuando la direccion a la que pertenece el usuario es modificada
				if((int)$this->input->post('id_direccion_modif') === 1) {
					// Obtener el id_direccion actual del ususario
					$id_direccion = $this->Usuario->obtenerDireccion($no_empleado);
					$id_direccion = $id_direccion->id_direccion;
					// Borrar los registros que vinculan al usuario con las impresoras de dicha direccion
					if($res = $this->Equipo->obtenerImpresora($id_direccion)) {
						foreach($res as $equipo) {
							$id_equipo = $equipo->id_equipo;
							$this->Equipo_usuario->borrarVinculoEyU($id_equipo, $no_empleado);
						}
						
					}
					// Realizar la vinculaci??n del usuario con las nuevas impresoras de la nueva direccion
					// Validar que dicha direccion si tenga ya una impresora
					if($res = $this->Equipo->obtenerImpresora((int)$this->input->post('id_direccion'))) {
						foreach($res as $id_equipo) {
							$data = array(
								'id_equipo' => $id_equipo->id_equipo,
								'no_empleado' => $no_empleado,
							);
							$this->Equipo_usuario->insertar($data);
						}
						
					}
				}

				// Si el equipo PC del usuario es modificado
				if((int)$this->input->post('id_equipo_modif') === 1) {
					if($this->input->post('id_equipo')) {
						// Actualizar el equipo o PC del suarios
						// Obtener el id_equipo v??a post
						$id_equipo = (int)$this->input->post('id_equipo');
						// Obtner el id del antiguo equipo del usuario
						if($res = $this->Equipo->getIdEquipo($no_empleado)) {
							$old_id_equipo = $res->id_equipo;
							// Realizar la actualizacion
							$this->Equipo_usuario->updateEquipo($id_equipo, $no_empleado, $old_id_equipo);
						} else {
							// Si no tiene equipo anterior realizar una incersion
							$data = array(
								'id_equipo' => $id_equipo,
								'no_empleado' => $no_empleado,
							);
							$this->Equipo_usuario->insertar($data);
						}
					} else {
						// Si el usuario borra el equipo del usuario
						$res = $this->Equipo->getIdEquipo($no_empleado);
						$id_equipo = $res->id_equipo;
						$this->Equipo_usuario->borrarVinculoEyU($id_equipo, $no_empleado);
					}
				}

				// Hacer actualizaci??n de la tabla de usuarios
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