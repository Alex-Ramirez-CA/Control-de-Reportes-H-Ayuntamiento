<?php
class Rol extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function get_roles() {
        $data = $this->db
            ->select("id_rol, nombre")
            ->from("rol")
            ->get();

        if(!$data->result()) {
            return false;
        }

        return $data->result();
    }   
}