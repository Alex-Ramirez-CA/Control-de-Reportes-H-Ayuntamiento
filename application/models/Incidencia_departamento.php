<?php
class Incidencia_departamento extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // Insertar datos de una nueva incidencia
    public function asignar_departamento($datos) {
        $this->db->insert('incidencia_departamento', $datos);
    }
}