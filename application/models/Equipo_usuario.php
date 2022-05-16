<?php
class Equipo_usuario extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // Crear la relacion de usuario con el equipo
    public function insertar($data) {
        $this->db->insert('equipo_usuario', $data);
    }

    // Obtener los uquipo a los que esta asignado el usuario
    public function obtener_equipos($no_empleado) {
        $data = $this->db
                ->select("e.id_equipo, e.nombre")
                ->from("equipo_usuario eu")
                ->join("equipo e", "eu.id_equipo=e.id_equipo")
                ->where(array('eu.no_empleado' => $no_empleado, 'e.status' => 1))
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }
    
    // Obtener los usuarios que estan asignados al equipo tipo PC
    public function obtener_usuarios($id_equipo) {
        $data = $this->db
                ->select("u.no_empleado, u.nombre, u.apellido_paterno, u.apellido_materno")
                ->from("equipo_usuario eu")
                ->join("usuario u", "eu.no_empleado=u.no_empleado")
                ->join("equipo e", "eu.id_equipo=e.id_equipo")
                ->where(array('eu.id_equipo' => $id_equipo, 'e.tipo_equipo' => 'PC', 'u.status' => 1))
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }
    
    // Obtener los datos de la PC de un usuario
    public function get_equipo($no_empleado) {
        $data = $this->db
                ->select("e.id_equipo")
                ->from("equipo_usuario eu")
                ->join("equipo e", "eu.id_equipo=e.id_equipo")
                ->where(array('eu.no_empleado' => $no_empleado, 'e.tipo_equipo' => "PC", 'e.status' => 1))
                ->limit(1)
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

    public function updateEquipo($id_equipo, $no_empleado, $old_id_equipo) {
        $this->db->set('id_equipo', $id_equipo);
        $this->db->where(array('no_empleado' => $no_empleado, 'id_equipo' => $old_id_equipo));
        $this->db->update('equipo_usuario');
    }

    public function comprobarRelacion($id_equipo, $no_empleado) {
        $data = $this->db
                ->select("*")
                ->from("equipo_usuario eu")
                ->join("equipo e", "eu.id_equipo=e.id_equipo")
                ->where(array('id_equipo' => $id_equipo, 'no_empleado' => $no_empleado, 'e.status' => 1))
                ->limit(1)
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }
    
    public function borrarRelacion($id_equipo) {
        $data = $this->db->delete('equipo_usuario', array('id_equipo' => $id_equipo));
    }

    // Funcion que nos ayudara a saber si un usuario no tiene ya una PC activa asosiada
    public function usuarioTienePC($no_empleado) {
        $data = $this->db
                ->select("*")
                ->from("equipo_usuario eu")
                ->join("equipo e", "eu.id_equipo=e.id_equipo")
                ->where(array('eu.no_empleado' => $no_empleado, 'e.status' => 1, 'e.tipo_equipo' => 'PC'))
                ->limit(1)
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

}