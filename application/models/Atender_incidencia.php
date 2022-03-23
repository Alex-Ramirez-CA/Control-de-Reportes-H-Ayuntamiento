<?php
class Atender_incidencia extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function get_comentarios($id_incidencia) {
        $data = $this->db
                ->select("ai.comentario, ai.fecha, d.nombre as departamento, concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as comentario_by")
                ->from("atender_incidencia ai")
                ->join("departamento d", "ai.id_departamento=d.id_departamento")
                ->join("usuario u", "d.id_departamento=u.id_departamento")
                ->where('ai.id_incidencia', $id_incidencia)
                ->order_by('ai.fecha')
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
        
        /* Cometarios de la incidencia
        SELECT  ai.comentario, ai.fecha, d.nombre as 'departamento', concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as 'comentario_by'
        FROM atender_incidencia as ai 
        INNER JOIN departamento as d ON ai.id_departamento=d.id_departamento 
        INNER JOIN usuario as u ON d.id_departamento=u.id_departamento
        WHERE ai.id_incidencia = '1';
        */
    }
}