<?php
class Dependencia extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function get_dependencias() {
        $data = $this->db
            ->select("id_dependencia, nombre")
            ->from("dependencia")
            ->get();

        if(!$data->result()) {
            return false;
        }

        return $data->result();
    }   
}