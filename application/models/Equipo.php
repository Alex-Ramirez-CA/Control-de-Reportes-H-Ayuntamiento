<?php
class Equipo extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    // Insertar datos de un usuario nuevo
    public function guardar_equipo($datos) {
        $this->db->insert('equipo', $datos);
    }

    // Por si la actualizacion sera de todos los datos
    public function update_equipo($id_equipo, $datos){
		$this->db->update('equipo', $datos, array('id_equipo' => $id_equipo));
	}

    // Hacer la busqueda de los equipos existentes, por su nombre
    public function buscarEquipo($search) {
        // Busqueda por nombre
        $data = $this->db
            ->select("id_equipo, nombre")
            ->from("equipo")
            ->like('nombre', $search, 'after', '', TRUE)
            ->limit(5)
            ->order_by('id_equipo')
            ->get();
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }
    
    // Hacer la busqueda de los equipos por su direccion ip
    public function buscarDireccionIP($search) {
        // Busqueda por direccion IP
        $data = $this->db
            ->select("id_equipo, direccion_ip")
            ->from("equipo")
            ->like('direccion_ip', $search, 'after', '', TRUE)
            ->limit(5)
            ->where(array('status' => 1, 'tipo_equipo' => 'PC'))
            ->order_by('id_equipo')
            ->get();
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Obtener la impresora asosiada a una determinada direccion
    public function obtenerImpresora($id_direccion) {
        $data = $this->db
            ->select("id_equipo")
            ->from("equipo")
            ->where(array('id_direccion' => $id_direccion, 'tipo_equipo' => 'Impresora', 'status' => 1))
            ->get();

        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result(); 
    }

    public function obtenerPC($no_empleado) {
        $data = $this->db
            ->select("e.id_equipo, e.direccion_ip")
            ->from("equipo e")
            ->join("equipo_usuario eu", "e.id_equipo=eu.id_equipo")
            ->where(array('eu.no_empleado' => $no_empleado, 'e.tipo_equipo' => 'PC', 'e.status' => 1))
            ->limit(1)
            ->get();

        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }
    
    public function getIdEquipo($no_empleado) {
        $data = $this->db
            ->select("e.id_equipo")
            ->from("equipo e")
            ->join("equipo_usuario eu", "e.id_equipo=eu.id_equipo")
            ->where(array('eu.no_empleado' => $no_empleado, 'e.tipo_equipo' => 'PC'))
            ->limit(1)
            ->get();

        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }
    
    public function obtenerOldImpresora($no_empleado) {
        $data = $this->db
            ->select("e.id_equipo")
            ->from("equipo e")
            ->join("equipo_usuario eu", "e.id_equipo=eu.id_equipo")
            ->where(array('eu.no_empleado' => $no_empleado, 'e.tipo_equipo' => 'Impresora', 'e.status' => 1))
            ->limit(1)
            ->get();

        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

    public function obtenerIdEquipo($direccion_ip) {
        $data = $this->db
                ->select("id_equipo")
                ->from("equipo")
                ->where(array('direccion_ip' => $direccion_ip, 'tipo_equipo' => 'PC', 'status' =>1))
                ->limit(1)
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }
    
    public function obtenerIdImpresora($direccion_ip) {
        $data = $this->db
                ->select("id_equipo")
                ->from("equipo")
                ->where(array('direccion_ip' => $direccion_ip, 'tipo_equipo' => 'Impresora', 'status' =>1))
                ->limit(1)
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

    // Obtiene todos los equipos existentes
    public function getEquipos() {
        $data = $this->db
            ->select("e.id_equipo, e.direccion_ip, e.inventario, e.nombre, e.tipo_equipo, dir.nombre as direccion, e.status")
            ->from("equipo e")
            ->where("e.status", 1)
            ->join("direccion dir", "e.id_direccion=dir.id_direccion")
            ->order_by('e.id_equipo')
            ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Filtros para los equipos
    public function filtrarEquipos($dependencia, $direccion, $status, $tipo_equipo) {
        $queryDepen = 'depen.id_dependencia IS NOT NULL';
        $queryDirecc = 'dir.id_direccion IS NOT NULL';
        $queryStatus = 'e.status IS NOT NULL';
        $queryTipo = 'e.tipo_equipo IS NOT NULL';

        if($dependencia !== NULL) {
            $queryDepen = 'depen.id_dependencia = '.$dependencia;
        }
        if($direccion !== NULL) {
            $queryDirecc = 'dir.id_direccion = '.$direccion;
        }
        if($status !== NULL) {
            $queryStatus = 'e.status = '.$status;
        }
        if($tipo_equipo !== NULL) {
            $queryTipo = 'e.tipo_equipo = '.'"'.$tipo_equipo.'"';
        }
        $data = $this->db
            ->distinct()
            ->select("e.id_equipo, e.direccion_ip, e.inventario, e.nombre, e.tipo_equipo, dir.nombre as direccion, e.status")
            ->from("equipo e")
            ->join("direccion dir", "e.id_direccion=dir.id_direccion")
            ->join("dependencia depen", "dir.id_dependencia=depen.id_dependencia")
            ->where($queryDepen)
            ->where($queryDirecc)
            ->where($queryStatus)
            ->where($queryTipo)
            ->group_by('e.id_equipo')
            ->get();
        
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Funci??n que permite modificar el status de un equipo, ya sea como activo o inactivo
    public function statusEquipo($status, $id_equipo) {
        $this->db->set('status', $status);
        $this->db->where('id_equipo', $id_equipo);
        $this->db->update('equipo');
    }

    // Obtener los uquipo a los que esta asignado el usuario
    public function buscarEquipobyNameAndIP($search_equipo) {
        // Busqueda por nombre
        $data = $this->db
            ->select("e.id_equipo, e.direccion_ip, e.segmento_de_red, e.nombre, e.tipo_equipo, dir.nombre as direccion, e.status")
            ->from("equipo e")
            ->join("direccion dir", "e.id_direccion=dir.id_direccion")
            ->like('e.nombre', $search_equipo, 'after', '', TRUE)
            ->order_by('e.id_equipo')
            ->get();
        // buscar por direccion IP
        if(!$data->result()) {
            $data = $this->db
                ->select("e.id_equipo, e.direccion_ip, e.segmento_de_red, e.nombre, e.tipo_equipo, dir.nombre as direccion, e.status")
                ->from("equipo e")
                ->join("direccion dir", "e.id_direccion=dir.id_direccion")
                ->like('e.direccion_ip', $search_equipo, 'after', '', TRUE)
                ->order_by('e.id_equipo')
                ->get();
        }
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->result();
    }

    // Obtiene los datos de un equipo en especifico
    public function getEquipo($id_equipo) {
        $data = $this->db
            ->select("id_equipo, tipo_equipo, nombre, direccion_ip, segmento_de_red, id_direccion, marca, inventario, serie, sistema_operativo, procesador, ram, disco_duro, teclado, mouse, dvd, inventario_monitor, serie_monitor, marca_monitor, tamano_monitor, observaciones")
            ->from("equipo")
            ->where('id_equipo', $id_equipo)
            ->limit(1)
            ->order_by('id_equipo')
            ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

    public function direccionIpYaExistente($direccion_ip) {
        $data = $this->db
                ->select("*")
                ->from("equipo")
                ->where(array('direccion_ip' => $direccion_ip, 'status' =>1))
                ->limit(1)
                ->get();
        
        // Si no se encuentra resultados
        if(!$data->result()) {
            return false;
        }
        return $data->row();
    }

}