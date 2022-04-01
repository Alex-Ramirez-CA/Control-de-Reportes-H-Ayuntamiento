<?php
class Atender_incidencia extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // Insertar datos de una nueva incidencia
    public function insertar($data) {
        $this->db->insert('atender_incidencia', $data);
    }

    public function get_comentarios($id_incidencia) {
        $data = $this->db
                ->select("ai.comentario, ai.fecha, concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as comentario_by")
                ->from("atender_incidencia ai")
                ->join("usuario u", "ai.no_empleado=u.no_empleado")
                ->where('ai.id_incidencia', $id_incidencia)
                ->order_by('ai.fecha')
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    public function verificar($id_incidencia, $no_empleado) {
        $data = $this->db
                ->select("*")
                ->from("atender_incidencia")
                ->where(array('id_incidencia' => $id_incidencia, 'no_empleado' => $no_empleado))
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }
}