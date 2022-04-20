<?php
class Departamento extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function get_departamentos() {
        $data = $this->db
            ->select("id_departamento, nombre")
            ->from("departamento")
            ->where("id_departamento != ", 0)
            ->get();

        if(!$data->result()) {
            return false;
        }

        return $data->result();
    }   
}