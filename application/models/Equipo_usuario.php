<?php
class Equipo_usuario extends CI_Model {
    function __construct() {
        $this->load->database();
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

}