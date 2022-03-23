<?php
class Archivo extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function get_archivos($id_incidencia) {
        $data = $this->db
                ->select("id_archivo, nombre as 'nombre_archivo'")
                ->from("archivo")
                ->where('id_incidencia', $id_incidencia)
                ->order_by('id_archivo')
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
        /* Obtener archivos de dicha incidencia
        SELECT  nombre as 'nombre_archivo'
        FROM archivo 
        WHERE id_incidencia = '1';
        */
    }
}