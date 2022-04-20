<?php
class Direccion extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function get_direcciones() {
        $data = $this->db
            ->select("id_direccion, nombre")
            ->from("direccion")
            ->get();

        if(!$data->result()) {
            return false;
        }

        return $data->result();
    }   
}