<?php
class Incidencia extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function get_incidencia($no_empleado, $id_incidencia, $titulo) {
        // Para las incidencias que ya han sido atendidas
        $data = $this->db
            ->select("i.id_incidencia, i.titulo, i.status, i.fecha_apertura, d.nombre as Departamento, concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as Encargado")
            ->from("incidencia i")
            ->join("atender_incidencia a", "i.id_incidencia=a.id_incidencia")
            ->join("departamento d", "a.id_departamento=d.id_departamento")
            ->join("usuario u", "d.id_departamento=u.id_departamento")
            ->where(array('i.no_empleado' => $no_empleado, 'i.id_incidencia' => $id_incidencia))
            ->or_where(array('i.titulo' => $titulo))
            ->order_by('id_incidencia')
            ->get();
        // Para las que no han sido atendidas
        if(!$data->result()) {
            $data = $this->db
                ->select("id_incidencia, titulo, status, fecha_apertura")
                ->from("incidencia")
                ->where(array('no_empleado' => $no_empleado, 'id_incidencia' => $id_incidencia))
                ->or_where(array('titulo' => $titulo))
                ->order_by('id_incidencia')
                ->get();
        }
        // Si no se encuentra ninguna
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Consulta las incidencias de por usuario y status
    public function get_incidencias($no_empleado, $status) {
        $data;
        if($status == 0) { //Incidencias pendientes
            $data = $this->db
                ->select("id_incidencia, titulo, status, fecha_apertura")
                ->from("incidencia")
                ->where(array('no_empleado' => $no_empleado, 'status' => $status))
                ->order_by('id_incidencia')
                ->get();
        } else if($status == 1) { //Incidencias en proceso
            $data = $this->db
                ->select("i.id_incidencia, i.titulo, i.status, i.fecha_apertura, d.nombre as 'Departamento', concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as Encargado")
                ->from("incidencia i")
                ->join("atender_incidencia a", "i.id_incidencia=a.id_incidencia")
                ->join("departamento d", "a.id_departamento=d.id_departamento")
                ->join("usuario u", "d.id_departamento=u.id_departamento")
                ->where(array('i.no_empleado' => $no_empleado, 'i.status' => $status))
                ->order_by('i.id_incidencia')
                ->get();
        } else if($status == 2) { //Incidencias finalizadas
            $data = $this->db
                ->select("i.id_incidencia, i.titulo, i.status, i.fecha_apertura, d.nombre as 'Departamento', concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as Encargado")
                ->from("incidencia i")
                ->join("atender_incidencia a", "i.id_incidencia=a.id_incidencia")
                ->join("departamento d", "a.id_departamento=d.id_departamento")
                ->join("usuario u", "d.id_departamento=u.id_departamento")
                ->where(array('i.no_empleado' => $no_empleado, 'i.status' => $status))
                ->order_by('i.id_incidencia')
                ->get();
        }
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

Para las que tienen estatus 1 o en proceso
SELECT i.id_incidencia, i.titulo, i.status, i.fecha_apertura, d.nombre as 'Departamento', concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as 'Encargados' 
FROM incidencia as i 
INNER JOIN atender_incidencia as a ON i.id_incidencia=a.id_incidencia 
INNER JOIN departamento as d ON a.id_departamento=d.id_departamento 
INNER JOIN usuario as u ON d.id_departamento=u.id_departamento 
WHERE i.no_empleado = '55555' AND i.status = '1'
ORDER BY i.id_incidencia;

Para las que tienen estatus 0 o pendientes
SELECT id_incidencia, titulo, status, fecha_apertura
FROM incidencia
WHERE no_empleado = '55555' AND status = '0'
ORDER BY id_incidencia;
*/