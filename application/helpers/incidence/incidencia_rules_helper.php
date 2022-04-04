<?php
function getIncidenciaRules() {
    return array(
        array(
                'field' => 'titulo',
                'label' => 'Titulo',
                'rules' => 'required|max_length[45]',
                'errors' => array(
                    'required' => 'El %s es requerido',
                    'max_length' => 'El %s debe ser mas corto',
                ),
        ),
        array(
                'field' => 'descripcion',
                'label' => 'Descripcion',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'La %s es requerida',
                ),
        ),
    );
}