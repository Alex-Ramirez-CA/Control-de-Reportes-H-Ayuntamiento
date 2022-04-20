<?php
class Equipo extends CI_Model {
    function __construct() {
        $this->load->database();
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
            ->order_by('id_equipo')
            ->get();
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

}