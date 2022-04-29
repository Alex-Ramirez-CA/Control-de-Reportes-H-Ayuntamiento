<?php
class Usuario extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // Insertar datos de un usuario nuevo
    public function guardar_usuario($datos) {
        $this->db->insert('usuario', $datos);
    }

    // Buscador de empleado por sus diferentes campos
    public function buscarEmpleado($search) {
        // Busqueda por no_empleado
        $data = $this->db
            ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno, d.nombre as direccion")
            ->from("usuario u")
            ->join("direccion d", "u.id_direccion=d.id_direccion")
            ->where('u.status', 1)
            ->like('u.no_empleado', $search, 'after', '', TRUE)
            ->limit(5)
            ->order_by('u.no_empleado')
            ->get();
        if(!$data->result()) {
            // Busqueda por nombre
            $data = $this->db
                ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno, d.nombre as direccion")
                ->from("usuario u")
                ->join("direccion d", "u.id_direccion=d.id_direccion")
                ->where('u.status', 1)
                ->like('u.nombre', $search, 'after', '', TRUE)
                ->limit(5)
                ->order_by('u.no_empleado')
                ->get();
        }
        if(!$data->result()) {
            // Busqueda por apellido paterno
            $data = $this->db
                ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno, d.nombre as direccion")
                ->from("usuario u")
                ->join("direccion d", "u.id_direccion=d.id_direccion")
                ->where('u.status', 1)
                ->like('u.apellido_paterno', $search, 'after', '', TRUE)
                ->limit(5)
                ->order_by('u.no_empleado')
                ->get();
        }
        if(!$data->result()) {
            // Busqueda por apellido materno
            $data = $this->db
                ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno, d.nombre as direccion")
                ->from("usuario u")
                ->join("direccion d", "u.id_direccion=d.id_direccion")
                ->where('u.status', 1)
                ->like('u.apellido_materno', $search, 'after', '', TRUE)
                ->limit(5)
                ->order_by('u.no_empleado')
                ->get();
        }
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    public function obtenerNoEmpleado($email) {
        $data = $this->db
                ->select("no_empleado")
                ->from("usuario")
                ->where('email', $email)
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

    // Obtiene todos los usuarios existentes
    public function getUsuarios() {
        $data = $this->db
            ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno, dir.nombre as direccion, r.nombre as rol, u.status")
            ->from("usuario u")
            ->join("rol r", "u.id_rol=r.id_rol")
            ->join("direccion dir", "u.id_direccion=dir.id_direccion")
            ->order_by('u.no_empleado')
            ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Filtros para las incidencias con status dos
    public function filtrarUsuarios($rol, $departamento,  $dependencia, $direccion, $status) {
        $queryRol = 'r.id_rol IS NOT NULL';
        $queryDepa = 'depa.id_departamento IS NOT NULL';
        $queryDepen = 'depen.id_dependencia IS NOT NULL';
        $queryDirecc = 'dir.id_direccion IS NOT NULL';
        $queryStatus = 'u.status IS NOT NULL';

        if($rol !== NULL) {
            $queryRol = 'r.id_rol = '.$rol;
        }
        if($departamento !== NULL) {
            $queryDepa = 'depa.id_departamento = '.$departamento;
        }
        if($dependencia !== NULL) {
            $queryDepen = 'depen.id_dependencia = '.$dependencia;
        }
        if($direccion !== NULL) {
            $queryDirecc = 'dir.id_direccion = '.$direccion;
        }
        if($status !== NULL) {
            $queryStatus = 'u.status = '.$status;
        }
        $data = $this->db
            ->distinct()
            ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno, dir.nombre as direccion, r.nombre as rol, u.status")
            ->from("usuario u")
            ->join("rol r", "u.id_rol=r.id_rol")
            ->join("departamento depa", "u.id_departamento=depa.id_departamento")
            ->join("direccion dir", "u.id_direccion=dir.id_direccion")
            ->join("dependencia depen", "dir.id_dependencia=depen.id_dependencia")
            ->where($queryRol)
            ->where($queryDepa)
            ->where($queryDepen)
            ->where($queryDirecc)
            ->where($queryStatus)
            ->group_by('u.no_empleado')
            ->get();
        
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Función que permite modificar el status de un usuario, ya sea como activo o inactivo
    public function statusUsuario($status, $no_empleado) {
        $this->db->set('status', $status);
        $this->db->where('no_empleado', $no_empleado);
        $this->db->update('usuario');
    }

    public function obtenerDireccion($no_empleado) {
        $data = $this->db
            ->select("id_direccion")
            ->from("usuario")
            ->where('no_empleado', $no_empleado)
            ->get();

        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

    public function getUsuario($no_empleado) {
        $data = $this->db
            ->select("no_empleado, nombre, apellido_paterno, apellido_materno, email, password, id_direccion, id_rol, id_departamento")
            ->from("usuario")
            ->where('no_empleado', $no_empleado)
            ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

    // Por si se actualizara campo por campo
    public function update_nombre($no_empleado, $nombre) {
        $this->db->set('nombre', $nombre);
        $this->db->where('no_empleado', $no_empleado);
        $this->db->update('usuario');
    }

    // Por si la actualizacion sera de todos los datos
    public function update_usuario($no_empleado, $datos){
		$this->db->update('usuario', $datos, array('no_empleado' => $no_empleado));
	}

    public function getUsuariosbyDireccion($id_direccion) {
        $data = $this->db
            ->select("no_empleado")
            ->from("usuario")
            ->where(array('id_direccion' => $id_direccion, 'status' => 1))
            ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

}