<?php
function getEquipoRules() {
    return array(
        array(
                'field' => 'nombre',
                'label' => 'Nombre',
                'rules' => 'required|max_length[50]',
                'errors' => array(
                    'required' => 'El %s es requerido',
                    'max_length' => 'El %s debe ser más corto',
                ),
        ),
        array(
                'field' => 'sistema_operativo',
                'label' => 'Sistema Operativo',
                'rules' => 'required|max_length[50]',
                'errors' => array(
                        'required' => 'El %s es requerido',
                        'max_length' => 'El nombre del %s debe ser más corto',
                ),
        ),
        array(
                'field' => 'marca',
                'label' => 'Marca',
                'rules' => 'required|max_length[25]',
                'errors' => array(
                        'required' => 'La %s es requerida',
                        'max_length' => 'El nombre de la %s debe ser más corto',
                ),
        ),
        array(
                'field' => 'inventario',
                'label' => 'Inventario',
                'rules' => 'required|max_length[50]',
                'errors' => array(
                        'required' => 'El %s es requerido',
                        'max_length' => 'El %s debe ser más corto',
                ),
        ),
        array(
                'field' => 'serie',
                'label' => 'Serie',
                'rules' => 'required|max_length[50]',
                'errors' => array(
                        'required' => 'La %s es requerida',
                        'max_length' => 'La %s debe ser más corta',
                ),
        ),
        array(
                'field' => 'direccion_ip',
                'label' => 'Dirección IP',
                'rules' => 'required|max_length[50]|valid_ip',
                'errors' => array(
                        'required' => 'La %s es requerida',
                        'max_length' => 'La %s debe ser más corta',
                        'valid_ip' => 'Ingrese formato válido de %s',
                ),
        ),
        array(
                'field' => 'procesador',
                'label' => 'Procesador',
                'rules' => 'required|max_length[50]',
                'errors' => array(
                    'required' => 'El %s es requerido',
                    'max_length' => 'La %s debe ser más corta',
                ),
        ),
        array(
                'field' => 'segmento_de_red',
                'label' => 'Segmento de red',
                'rules' => 'required|max_length[10]',
                'errors' => array(
                    'required' => 'El %s es requerido',
                    'max_length' => 'El %s debe ser más corto',
                ),
        ),
    );
}