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
                ->where('eu.no_empleado', $no_empleado)
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
                ->where(array('eu.no_empleado' => $no_empleado, 'e.tipo_equipo' => "PC"))
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
                ->from("equipo_usuario")
                ->where(array('id_equipo' => $id_equipo, 'no_empleado' => $no_empleado), 1)
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

}