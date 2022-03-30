<?php
class Incidencia_departamento extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // Insertar datos de una nueva incidencia
    public function asignar_departamento($id_departamento, $id_incidencia) {
        $datos = array(
            'id_departamento' => $id_departamento,
            'id_incidencia' => $id_incidencia,
        );
        $this->db->insert('incidencia_departamento', $datos);
    }

}