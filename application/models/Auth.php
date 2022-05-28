<?php
class Auth extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function login($usuario, $password) {
        $data = $this->db
            ->select("b.no_empleado, b.email, b.nombre, b.apellido_paterno, b.apellido_materno, a.id_rol, a.nombre as rol_nombre, b.id_departamento")
            ->from("rol a")
            ->join("usuario b", "a.id_rol = b.id_rol")
            ->where(array('b.email' => $usuario, 'b.password' => md5($password), 'b.status' => 1))
            ->limit(1)
            ->get();

        if(!$data->result()) {
            return false;
        }

        return $data->row();
    }   
}