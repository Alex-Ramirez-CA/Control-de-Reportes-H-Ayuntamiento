<?php
class Incidencia extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function get_incidencia($id_incidencia, $titulo) {

        $data = $this->db
            ->select("i.id_incidencia, i.titulo, i.status, i.fecha_apertura, d.nombre as Departamento, concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as Encargado")
            ->from("incidencia i")
            ->join("atender_incidencia a", "i.id_incidencia=a.id_incidencia")
            ->join("departamento d", "a.id_departamento=d.id_departamento")
            ->join("usuario u", "d.id_departamento=u.id_departamento")
            ->where(array('i.id_incidencia' => $id_incidencia))
            ->or_where(array('i.titulo' => $titulo))
            ->get();

        if(!$data->result()) {
            return false;
        }

        return $data->result();
    }   
}
/*
// $data = $this->db->get_where('incidencia', array('email' => $usuario, 'password' => $password),1);
//         if(!$data->result()) {
//             return false;
//         }
//         return $data->row();



SELECT i.id_incidencia, i.titulo, i.status, i.fecha_apertura, d.nombre as 'Departamento', concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as 'Encargados'
FROM incidencia as i
INNER JOIN atender_incidencia as a ON i.id_incidencia=a.id_incidencia
INNER JOIN departamento as d ON a.id_departamento=d.id_departamento
INNER JOIN usuario as u ON d.id_departamento=u.id_departamento
WHERE i.id_incidencia = '1';
*/