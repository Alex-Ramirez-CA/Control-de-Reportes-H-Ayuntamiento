<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('form_validation','session'));
		$this->load->model(array('Usuario', 'Departamento', 'Rol', 'Direccion', 'Equipo', 'Equipo_usuario'));
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

    // Funcion para guardar los datos del usuario agregado
	public function guardar_usuario() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
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
				'id_direccion' => form_error('id_direccion'),
				'id_rol' => form_error('id_rol'),
				'id_departamento' => form_error('id_departamento'),
				'id_equipo' => form_error('id_equipo'),
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
				'password' => $this->input->post('password'),
				'status' => 1,
				'id_direccion' => $this->input->post('id_direccion'),
				'id_rol' => $this->input->post('id_rol'),
				'id_departamento' => $this->input->post('id_departamento'),
			);
			// Hacer insercion a la tabla de usuarios
			$this->Usuario->guardar_usuario($datos);

			// Crear el vinculo entre el usuario y su equipo personal
			// Obtener el numero de empleado por su email
			$res = $this->Usuario->obtenerNoEmpleado($this->input->post('email'));
			$no_empleado = $res->no_empleado;
			$data = array(
				'id_equipo' => $this->input->post('id_equipo'),
				'no_empleado' => $no_empleado,
			);
            $this->Equipo_usuario->insertar($data);

			// Crear el vinculo del usuario con la impresora de su direccion
			// Validar que dicha direccion si tenga ya una impresora
			if($res = $this->Equipo->obtenerImpresora($this->input->post('id_direccion'))) {
				$id_equipo = $res->id_equipo;
				$data = array(
					'id_equipo' => $id_equipo,
					'no_empleado' => $no_empleado,
				);
				$this->Equipo_usuario->insertar($data);
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
			// Validar que existan usuarios
			if($res = $this->Usuario->getUsuarios()) {
				$data = array(
					'head' => $this->load->view('layout/head', '', TRUE),
					'nav' => $this->load->view('layout/nav', '', TRUE),
					'footer' => $this->load->view('layout/footer', '', TRUE),
					'departamentos' => $this->Departamento->get_departamentos(),
					'roles' => $this->Rol->get_roles(),
					'direcciones' => $this->Direccion->get_direcciones(),
				);
				$this->load->view('v_listar_usuarios', $data);
			}
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
			$status = $this->input->post('status');
			$no_empleado = $this->input->post('no_empleado');
			$this->Usuario->statusUsuario($status, $no_empleado);
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Funcion para cuando se clicke el boton de estidar usuario
	public function editar_usuario() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			// Recibir el no_empleado del usuario seleccionado
			$no_empleado = $this->input->post('no_empleado');
			// Traer los datos del usuario
			$data = array(
				'head' => $this->load->view('layout/head', '', TRUE),
				'nav' => $this->load->view('layout/nav', '', TRUE),
				'footer' => $this->load->view('layout/footer', '', TRUE),
                'departamentos' => $this->Departamento->get_departamentos(),
                'roles' => $this->Rol->get_roles(),
				'direcciones' => $this->Direccion->get_direcciones(),
				'datos_usuario' => $this->Usuario->getUsuario(),
			);
			// Cargar la vista y mandar los datos
			$this->load->view('v_agregar_usuario', $data);
		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

	// Funcion que guarda los cambios realizados en los datos del usuario
	public function actualizar_usuario() {
		if($this->session->has_userdata('id_rol') && $this->session->userdata('id_rol') == 3) {
			
			// Datos para hacer la actualizacón del usuario
			$datos = array(
				'nombre' => $this->input->post('nombre'),
				'apellido_paterno' => $this->input->post('apellido_paterno'),
				'apellido_materno' => $this->input->post('apellido_materno'),
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password'),
				'id_direccion' => $this->input->post('id_direccion'),
				'id_rol' => $this->input->post('id_rol'),
				'id_departamento' => $this->input->post('id_departamento'),
			);

			// Obtener el no_empleado vía post
			$no_empleado = 1;//$this->input->post('no_empleado');

			// Si la direccion a la que pertenece es modificada
			// Modificar tambien la impresora a la que estara asociado el usuario
			$oldDireccion = $this->Usuario->obtenerDireccion($no_empleado);
			$oldDireccion = $oldDireccion->id_direccion;
			$newDireccion = 2;//$this->input->post('id_direccion');
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
			
			// Actualizar el equipo o PC del suarios
			// Obtener el id_equipo vía post
			$id_equipo = 1;//$this->input->post('id_equipo');
			// Obtner el id del antiguo equipo del usuario
			if($res = $this->Equipo->obtenerPC($no_empleado)) {
				$old_id_equipo = $res->id_equipo;
				// Realizar la actualizacion
				$this->Equipo_usuario->updateEquipo($id_equipo, $no_empleado, $old_id_equipo);
			}

			// Hacer actualización de la tabla de usuarios
			$this->Usuario->update_usuario($datos);

		} else {
			// Si no hay datos de sesion redireccionar a login
			redirect('login');
		}
	}

}