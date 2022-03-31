<?php
class Incidencia extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // -----------------------------------------------------------------------------------

    // Insertar datos de una nueva incidencia
    public function guardar_incidencia($datos) {
        $this->db->insert('incidencia', $datos);
    }
    
    // -----------------------------------------------------------------------------------

    // Hacer la busqueda entre todas las incidencias de un usuario en particular
    public function buscar_porUsuario($no_empleado, $search) {
        // Busqueda por id_incidencia
        $data = $this->db
                ->select("id_incidencia, titulo, status, fecha_apertura")
                ->from("incidencia")
                ->where('no_empleado', $no_empleado)
                ->like('id_incidencia', $search, 'after', '', TRUE)
                ->order_by('id_incidencia')
                ->get();
        if(!$data->result()) {
            // Busqueda por titulo
            $data = $this->db
                ->select("id_incidencia, titulo, status, fecha_apertura")
                ->from("incidencia")
                ->where('no_empleado', $no_empleado)
                ->like('titulo', $search, 'after', '', TRUE)
                ->order_by('id_incidencia')
                ->get();
        }
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }
    
    // Hacer la busqueda entre todas las incidencias con status = 0 o pendientes
    // para la pantalla principal del filtro
    public function buscar_pendientes($search) {
        // Busqueda por id_incidencia
        $data = $this->db
            ->select("id_incidencia, titulo, status, fecha_apertura")
            ->from("incidencia")
            ->where('status', 0)
            ->like('id_incidencia', $search, 'after', '', TRUE)
            ->order_by('id_incidencia')
            ->get();
        if(!$data->result()) {
            // Busqueda por titulo
            $data = $this->db
                ->select("id_incidencia, titulo, status, fecha_apertura")
                ->from("incidencia")
                ->where('status', 0)
                ->like('titulo', $search, 'after', '', TRUE)
                ->order_by('id_incidencia')
                ->get();
        }
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Hacer la busqueda entre todas las incidencias de un departamento determinado
    // para la pantalla principal del tecnico
    public function buscar_departamento($id_departamento, $search) {
        // Busqueda por id_incidencia
        $data = $this->db
            ->distinct()
            ->select("i.id_incidencia, i.titulo")
            ->from("incidencia i")
            ->join("incidencia_departamento id", "i.id_incidencia=id.id_incidencia")
            ->where('id.id_departamento', $id_departamento)
            ->like('i.id_incidencia', $search, 'after', '', TRUE)
            ->order_by('i.id_incidencia')
            ->get();
        if(!$data->result()) {
            // Busqueda por titulo
            $data = $this->db
                ->distinct()
                ->select("i.id_incidencia, i.titulo")
                ->from("incidencia i")
                ->join("incidencia_departamento id", "i.id_incidencia=id.id_incidencia")
                ->where('id.id_departamento', $id_departamento)
                ->like('i.titulo', $search, 'after', '', TRUE)
                ->order_by('i.id_incidencia')
                ->get();
        }
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }
    
    // Hacer la busqueda entre todas las incidencias que atiende o ha atendido un tecnico
    // para la pantalla atendiendo del usuario tecnico
    public function buscar_atendiendo($id_departamento, $search, $no_empleado) {
        // Busqueda por id_incidencia
        $data = $this->db
            ->distinct()
            ->select("i.id_incidencia, i.titulo")
            ->from("incidencia i")
            ->join("incidencia_departamento id", "i.id_incidencia=id.id_incidencia")
            ->join("atender_incidencia ai", "i.id_incidencia=ai.id_incidencia")
            ->where(array('id.id_departamento' => $id_departamento, 'ai.no_empleado' => $no_empleado))
            ->like('i.id_incidencia', $search, 'after', '', TRUE)
            ->order_by('i.id_incidencia')
            ->get();
        if(!$data->result()) {
            // Busqueda por titulo
            $data = $this->db
                ->distinct()
                ->select("i.id_incidencia, i.titulo")
                ->from("incidencia i")
                ->join("incidencia_departamento id", "i.id_incidencia=id.id_incidencia")
                ->join("atender_incidencia ai", "i.id_incidencia=ai.id_incidencia")
                ->where(array('id.id_departamento' => $id_departamento, 'ai.no_empleado' => $no_empleado))
                ->like('i.titulo', $search, 'after', '', TRUE)
                ->order_by('i.id_incidencia')
                ->get();
        }
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // -----------------------------------------------------------------------------------

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
                ->select("id_incidencia, titulo, status, fecha_apertura, (SELECT GROUP_CONCAT(d.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN incidencia_departamento as i_d ON i.id_incidencia=i_d.id_incidencia 
                INNER JOIN departamento as d ON i_d.id_departamento=d.id_departamento
                WHERE i.id_incidencia = inc.id_incidencia) as departamento, (SELECT GROUP_CONCAT(u.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN atender_incidencia as ai ON i.id_incidencia=ai.id_incidencia 
                INNER JOIN usuario as u ON ai.no_empleado=u.no_empleado
                WHERE i.id_incidencia = inc.id_incidencia) as encargado")
                ->from("incidencia inc")
                ->where(array('no_empleado' => $no_empleado, 'status' => $status))
                ->group_by('id_incidencia')
                ->get();
        } else if($status == 2) { //Incidencias finalizadas
            $data = $this->db
                ->select("id_incidencia, titulo, status, fecha_apertura, (SELECT GROUP_CONCAT(d.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN incidencia_departamento as i_d ON i.id_incidencia=i_d.id_incidencia 
                INNER JOIN departamento as d ON i_d.id_departamento=d.id_departamento
                WHERE i.id_incidencia = inc.id_incidencia) as departamento, (SELECT GROUP_CONCAT(u.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN atender_incidencia as ai ON i.id_incidencia=ai.id_incidencia 
                INNER JOIN usuario as u ON ai.no_empleado=u.no_empleado
                WHERE i.id_incidencia = inc.id_incidencia) as encargado")
                ->from("incidencia inc")
                ->where(array('no_empleado' => $no_empleado, 'status' => $status))
                ->group_by('id_incidencia')
                ->get();
        }
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Obtner todas las incidencias nuevas de todos los usuarios para mostrarselas al filtro
    public function get_new_incidencias() {
        $data = $this->db
            ->select("id_incidencia, titulo, fecha_apertura")
            ->from("incidencia")
            ->where(array('status' => 0, 'asignado' => 0))
            ->order_by('fecha_apertura')
            ->get();
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Consulta todas las incidencias de un departamento por sus diferentes status
    public function get_incidenciasDepar($id_departamento, $status) {
        $data;
        if($status == 0) { //Incidencias pendientes
            $data = $this->db
                ->distinct()
                ->select("i.id_incidencia, i.titulo, i.status, i.fecha_apertura")
                ->from("incidencia i")
                ->join("incidencia_departamento id", "i.id_incidencia=id.id_incidencia")
                ->where(array('id.id_departamento' => $id_departamento, 'status' => $status))
                ->order_by('i.id_incidencia')
                ->get();
        } else if($status == 1) { //Incidencias en proceso
            $data = $this->db
                ->distinct()
                ->select("inc.id_incidencia, inc.titulo, inc.status, inc.fecha_apertura, (SELECT GROUP_CONCAT(d.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN incidencia_departamento as i_d ON i.id_incidencia=i_d.id_incidencia 
                INNER JOIN departamento as d ON i_d.id_departamento=d.id_departamento
                WHERE i.id_incidencia = inc.id_incidencia) as departamento, (SELECT GROUP_CONCAT(u.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN atender_incidencia as ai ON i.id_incidencia=ai.id_incidencia 
                INNER JOIN usuario as u ON ai.no_empleado=u.no_empleado
                WHERE i.id_incidencia = inc.id_incidencia) as encargado")
                ->from("incidencia inc")
                ->join("incidencia_departamento id", "inc.id_incidencia=id.id_incidencia")
                ->where(array('id.id_departamento' => $id_departamento, 'status' => $status))
                ->group_by('inc.id_incidencia')
                ->get();
        } else if($status == 2) { //Incidencias finalizadas
            $data = $this->db
                ->distinct()
                ->select("inc.id_incidencia, inc.titulo, inc.status, inc.fecha_apertura, (SELECT GROUP_CONCAT(d.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN incidencia_departamento as i_d ON i.id_incidencia=i_d.id_incidencia 
                INNER JOIN departamento as d ON i_d.id_departamento=d.id_departamento
                WHERE i.id_incidencia = inc.id_incidencia) as departamento, (SELECT GROUP_CONCAT(u.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN atender_incidencia as ai ON i.id_incidencia=ai.id_incidencia 
                INNER JOIN usuario as u ON ai.no_empleado=u.no_empleado
                WHERE i.id_incidencia = inc.id_incidencia) as encargado")
                ->from("incidencia inc")
                ->join("incidencia_departamento id", "inc.id_incidencia=id.id_incidencia")
                ->where(array('id.id_departamento' => $id_departamento, 'status' => $status))
                ->group_by('inc.id_incidencia')
                ->get();
        }
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }
    
    // Consulta las incidencias en proceso y finalizadas que un determinado tecnico
    // esta atendiendo
    public function get_incidenciasQueAtiendiendo($id_departamento, $status, $no_empleado) {
        $data;
        if($status == 1) { //Incidencias en proceso
            $data = $this->db
                ->distinct()
                ->select("inc.id_incidencia, inc.titulo, inc.status, inc.fecha_apertura, (SELECT GROUP_CONCAT(d.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN incidencia_departamento as i_d ON i.id_incidencia=i_d.id_incidencia 
                INNER JOIN departamento as d ON i_d.id_departamento=d.id_departamento
                WHERE i.id_incidencia = inc.id_incidencia) as departamento, (SELECT GROUP_CONCAT(u.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN atender_incidencia as ai ON i.id_incidencia=ai.id_incidencia 
                INNER JOIN usuario as u ON ai.no_empleado=u.no_empleado
                WHERE i.id_incidencia = inc.id_incidencia) as encargado")
                ->from("incidencia inc")
                ->join("incidencia_departamento id", "inc.id_incidencia=id.id_incidencia")
                ->join("atender_incidencia ai", "inc.id_incidencia=ai.id_incidencia")
                ->where(array('id.id_departamento' => $id_departamento, 'status' => $status, 'ai.no_empleado' => $no_empleado))
                ->group_by('inc.id_incidencia')
                ->get();
        } else if($status == 2) { //Incidencias finalizadas
            $data = $this->db
                ->distinct()
                ->select("inc.id_incidencia, inc.titulo, inc.status, inc.fecha_apertura, (SELECT GROUP_CONCAT(d.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN incidencia_departamento as i_d ON i.id_incidencia=i_d.id_incidencia 
                INNER JOIN departamento as d ON i_d.id_departamento=d.id_departamento
                WHERE i.id_incidencia = inc.id_incidencia) as departamento, (SELECT GROUP_CONCAT(u.nombre SEPARATOR ', ') 
                FROM incidencia as i 
                INNER JOIN atender_incidencia as ai ON i.id_incidencia=ai.id_incidencia 
                INNER JOIN usuario as u ON ai.no_empleado=u.no_empleado
                WHERE i.id_incidencia = inc.id_incidencia) as encargado")
                ->from("incidencia inc")
                ->join("incidencia_departamento id", "inc.id_incidencia=id.id_incidencia")
                ->join("atender_incidencia ai", "inc.id_incidencia=ai.id_incidencia")
                ->where(array('id.id_departamento' => $id_departamento, 'status' => $status, 'ai.no_empleado' => $no_empleado))
                ->group_by('inc.id_incidencia')
                ->get();
        }
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // -----------------------------------------------------------------------------------

    // Obtener todos los datos necesarios para crear el reporte
    public function datos_incidencia($id_incidencia) {
        $data = $this->db
                ->select("i.id_incidencia, i.titulo, i.fecha_apertura, i.fecha_cierre, i.descripcion, i.status, i.archivo, i.ext, concat_ws(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as usuario, u.email, e.nombre, e.direccion_ip, e.inventario, e.serie, e.serie, e.marca, e.procesador, e.ram, e.disco_duro, e.teclado, e.mouse, e.dvd, e.inventario_monitor, e.serie_monitor, e.marca_monitor, e.tamano_monitor, e.sistema_operativo, e.observaciones, di.nombre as direccion, de.nombre as dependencia")
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
    }

    // -----------------------------------------------------------------------------------

    // Traer traer la descripcion de una incidencia
    public function get_descripcion($id_incidencia) {
        $data = $this->db
            ->select("id_incidencia, titulo, fecha_apertura, descripcion")
            ->from("incidencia")
            ->where('id_incidencia', $id_incidencia, 1)
            ->get();
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }
    
    // Actualizar la descripcion de la incidencia
    public function update_incidencia($id_incidencia, $descripcion) {
        $this->db->set('descripcion', $descripcion);
        $this->db->where('id_incidencia', $id_incidencia);
        $this->db->update('incidencia');
    }

    // -----------------------------------------------------------------------------------

    // Poner el estatus del campo asignado en 1 
    // para indicar que la incidencia ya ha sido asignada a un departamento
    public function status_asignado($id_incidencia) {
        $this->db->set('asignado', 1);
        $this->db->where('id_incidencia', $id_incidencia);
        $this->db->update('incidencia');
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