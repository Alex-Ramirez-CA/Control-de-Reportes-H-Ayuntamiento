<?php
class Incidencia extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // Insertar datos de una nueva incidencia
    public function guardar_incidencia($datos) {
        $this->db->insert('incidencia', $datos);
    }
    
    // Obtener las incidencias que conincidan con la busqueda de la barra de busqueda
    public function get_incidencia($no_empleado, $search) {
        $data = $this->db
                ->select("id_incidencia, titulo, status, fecha_apertura")
                ->from("incidencia")
                ->where('no_empleado', $no_empleado)
                ->like('id_incidencia', $search, 'after', '', TRUE)
                ->or_like('titulo', $search, 'after', '', TRUE)
                ->group_by('id_incidencia')
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Consulta todas las incidencias de un usuario por sus diferentes status
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
                ->select("i.id_incidencia, i.titulo, i.status, i.fecha_apertura, GROUP_CONCAT(DISTINCT d.nombre SEPARATOR ', ') as departamento, GROUP_CONCAT( u.nombre SEPARATOR ', ') as encargado")
                ->from("incidencia i")
                ->join("atender_incidencia a", "i.id_incidencia=a.id_incidencia")
                ->join("departamento d", "a.id_departamento=d.id_departamento")
                ->join("usuario u", "d.id_departamento=u.id_departamento")
                ->where(array('i.no_empleado' => $no_empleado, 'i.status' => $status))
                ->group_by('i.id_incidencia')
                ->get();
        } else if($status == 2) { //Incidencias finalizadas
            $data = $this->db
                ->select("i.id_incidencia, i.titulo, i.status, i.fecha_apertura, GROUP_CONCAT(DISTINCT d.nombre SEPARATOR ', ') as departamento, GROUP_CONCAT( u.nombre SEPARATOR ', ') as encargado")
                ->from("incidencia i")
                ->join("atender_incidencia a", "i.id_incidencia=a.id_incidencia")
                ->join("departamento d", "a.id_departamento=d.id_departamento")
                ->join("usuario u", "d.id_departamento=u.id_departamento")
                ->where(array('i.no_empleado' => $no_empleado, 'i.status' => $status))
                ->group_by('i.id_incidencia')
                ->get();
        }
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    public function datos_reporte($id_incidencia) {
        $data = $this->db
                ->select("i.id_incidencia, i.titulo, i.status, i.fecha_apertura, i.fecha_cierre, i.descripcion, concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as usuario, u.email, e.nombre, e.direccion_ip, e.inventario, e.serie, e.serie, e.marca, e.procesador, e.ram, e.disco_duro, e.teclado, e.mause, e.dvd, e.inventario_monitor, e.serie_monitor, e.marca_monitor, e.tamano_monitor, e.sistema_operativo, e.observaciones, di.nombre as direccion, de.nombre as dependencia")
                ->from("incidencia i")
                ->join("usuario u", "i.no_empleado=u.no_empleado")
                ->join("equipo e", "u.id_equipo=e.id_equipo")
                ->join("direccion di", "e.id_direccion=di.id_direccion")
                ->join("dependencia de", "di.id_dependencia=de.id_dependencia")
                ->where('i.id_incidencia', $id_incidencia)
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
        /* Datos de la incidencia, el usuario que la creo, datos de su equipo, direccion y dependencia a la que pertenece
        SELECT i.id_incidencia, i.titulo, i.status, i.fecha_apertura, i.fecha_cierre, i.descripcion, concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as 'usuario', u.email, e.nombre, e.direccion_ip, e.inventario, e.serie, e.serie, e.marca, e.procesador, e.ram, e.disco_duro, e.teclado, e.mause, e.dvd, e.inventario_monitor, e.serie_monitor, e.marca_monitor, e.tamano_monitor, e.sistema_operativo, e.observaciones, di.nombre as 'dirección', de.nombre as 'dependencía' 
        FROM incidencia as i 
        INNER JOIN usuario as u ON i.no_empleado=u.no_empleado 
        INNER JOIN equipo as e ON u.id_equipo=e.id_equipo
        INNER JOIN direccion as di ON e.id_direccion=di.id_direccion
        INNER JOIN dependencia as de ON di.id_dependencia=de.id_dependencia 
        WHERE i.id_incidencia = '1';
        */
    }
}
/*
// Esta es la buena
SELECT i.id_incidencia, i.titulo, i.status, i.fecha_apertura, GROUP_CONCAT(DISTINCT d.nombre SEPARATOR ', ') as 'departamento', GROUP_CONCAT( u.nombre SEPARATOR ', ') as 'encargado' 
FROM incidencia as i 
INNER JOIN atender_incidencia as a ON i.id_incidencia=a.id_incidencia 
INNER JOIN departamento as d ON a.id_departamento=d.id_departamento 
INNER JOIN usuario as u ON d.id_departamento=u.id_departamento 
WHERE i.no_empleado = '55555' AND i.status = '1'
GROUP BY i.id_incidencia;


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