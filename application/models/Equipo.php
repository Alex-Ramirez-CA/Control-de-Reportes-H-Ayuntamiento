<?php
class Equipo extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // Insertar datos de un usuario nuevo
    public function guardar_equipo($datos) {
        $this->db->insert('equipo', $datos);
    }

    // Obtener los uquipo a los que esta asignado el usuario
    public function buscarEquipo($search) {
        // Busqueda por nombre
        $data = $this->db
            ->select("id_equipo, nombre")
            ->from("equipo")
            ->like('nombre', $search, 'after', '', TRUE)
            ->limit(5)
            ->order_by('id_equipo')
            ->get();
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }
    
    // Hacer la busqueda de los equipos por su direccion ip
    public function buscarDireccionIP($search) {
        // Busqueda por nombre
        $data = $this->db
            ->select("id_equipo, direccion_ip")
            ->from("equipo")
            ->like('direccion_ip', $search, 'after', '', TRUE)
            ->limit(5)
            ->where(array('status' => 1, 'tipo_equipo' => 'PC'))
            ->order_by('id_equipo')
            ->get();
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Obtener la impresora asosiada a una determinada direccion
    public function obtenerImpresora($id_direccion) {
        $data = $this->db
            ->select("id_equipo")
            ->from("equipo")
            ->where(array('id_direccion' => $id_direccion, 'tipo_equipo' => 'Impresora', 'status' => 1), 1)
            ->get();

        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row(); 
    }

    public function obtenerPC($no_empleado) {
        $data = $this->db
            ->select("e.id_equipo, e.direccion_ip")
            ->from("equipo e")
            ->join("equipo_usuario eu", "e.id_equipo=eu.id_equipo")
            ->where(array('eu.no_empleado' => $no_empleado, 'e.tipo_equipo' => 'PC', 'e.status' => 1), 1)
            ->get();

        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }
    
    public function obtenerOldImpresora($no_empleado) {
        $data = $this->db
            ->select("e.id_equipo")
            ->from("equipo e")
            ->join("equipo_usuario eu", "e.id_equipo=eu.id_equipo")
            ->where(array('eu.no_empleado' => $no_empleado, 'e.tipo_equipo' => 'Impresora', 'e.status' => 1), 1)
            ->get();

        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

    public function obtenerIdEquipo($direccion_ip) {
        $data = $this->db
                ->select("id_equipo")
                ->from("equipo")
                ->where(array('direccion_ip' => $direccion_ip, 'tipo_equipo' => 'PC'), 1)
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

}