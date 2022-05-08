<?php
class Estatus_por_usuario extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // Insertar datos de una nueva incidencia
    public function insertar($data) {
        $this->db->insert('estatus_por_usuario', $data);
    }

    public function verificarEstatus($id_incidencia, $no_empleado) {
        $data = $this->db
            ->select("status")
            ->from("estatus_por_usuario")
            ->where(array('id_incidencia' => $id_incidencia, 'no_empleado' => $no_empleado))
            ->limit(1)
            ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }
    
    public function updateEstatus($id_incidencia, $no_empleado, $status) {
        $this->db->set('status', $status);
        $this->db->where(array('id_incidencia' => $id_incidencia, 'no_empleado' => $no_empleado));
        $this->db->update('estatus_por_usuario');
    }
}