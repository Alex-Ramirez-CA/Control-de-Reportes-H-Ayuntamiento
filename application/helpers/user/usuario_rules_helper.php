<?php
function getUsuarioRules() {
    return array(
        array(
                'field' => 'nombre',
                'label' => 'Nombre',
                'rules' => 'required|max_length[50]',
                'errors' => array(
                    'required' => 'El %s es requerido',
                    'max_length' => 'El %s debe ser mas corto',
                ),
        ),
        array(
                'field' => 'apellido_paterno',
                'label' => 'Apellido Paterno',
                'rules' => 'required|max_length[25]',
                'errors' => array(
                        'required' => 'El %s es requerido',
                        'max_length' => 'El %s debe ser mas corto',
                ),
        ),
        array(
                'field' => 'apellido_materno',
                'label' => 'Apellido Materno',
                'rules' => 'required|max_length[25]',
                'errors' => array(
                        'required' => 'El %s es requerido',
                        'max_length' => 'El %s debe ser mas corto',
                ),
        ),
        array(
            'field' => 'email',
            'label' => 'Correo',
            'rules' => 'required|trim|valid_email',
            'errors' => array(
                'required' => 'El %s es requerido.',
                'valid_email' => 'El formato de %s es invalido',
            ),
        ),
        array(
            'field' => 'password',
            'label' => 'Contraseña',
            'rules' => 'required',
            'errors' => array(
                    'required' => 'La %s es requerida',
            ),
        ),
        array(
                'field' => 'id_direccion',
                'label' => 'Direccion',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'La %s es requerida',
                ),
        ),
        array(
                'field' => 'id_rol',
                'label' => 'Rol',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'El %s es requerido',
                ),
        ),
        array(
                'field' => 'id_departamento',
                'label' => 'Departamento',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'El %s es requerida',
                ),
        ),
        array(
                'field' => 'id_equipo',
                'label' => 'Direccion IP',
                'rules' => 'required|max_length[45]',
                'errors' => array(
                    'required' => 'La %s es requerida',
                ),
        ),
    );
}