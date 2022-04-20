<?php
class Usuario extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // Insertar datos de un usuario nuevo
    public function guardar_usuario($datos) {
        $this->db->insert('usuario', $datos);
    }

    // Obtener los uquipo a los que esta asignado el usuario
    public function buscarEmpleado($search) {
        // Busqueda por no_empleado
        $data = $this->db
            ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno, d.nombre as direccion")
            ->from("usuario u")
            ->join("direccion d", "u.id_direccion=d.id_direccion")
            // ->where(array('status' => 0, 'asignado' => 0)) este sera de los usuarios activos
            ->like('u.no_empleado', $search, 'after', '', TRUE)
            ->order_by('u.no_empleado')
            ->get();
        if(!$data->result()) {
            // Busqueda por nombre
            $data = $this->db
                ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno, d.nombre as direccion")
                ->from("usuario u")
                ->join("direccion d", "u.id_direccion=d.id_direccion")
                // ->where(array('status' => 0, 'asignado' => 0)) este sera de los usuarios activos
                ->like('u.nombre', $search, 'after', '', TRUE)
                ->order_by('u.no_empleado')
                ->get();
        }
        if(!$data->result()) {
            // Busqueda por apellido paterno
            $data = $this->db
                ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno, d.nombre as direccion")
                ->from("usuario u")
                ->join("direccion d", "u.id_direccion=d.id_direccion")
                // ->where(array('status' => 0, 'asignado' => 0)) este sera de los usuarios activos
                ->like('u.apellido_paterno', $search, 'after', '', TRUE)
                ->order_by('u.no_empleado')
                ->get();
        }
        if(!$data->result()) {
            // Busqueda por apellido materno
            $data = $this->db
                ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno, d.nombre as direccion")
                ->from("usuario u")
                ->join("direccion d", "u.id_direccion=d.id_direccion")
                // ->where(array('status' => 0, 'asignado' => 0)) este sera de los usuarios activos
                ->like('u.apellido_materno', $search, 'after', '', TRUE)
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

}