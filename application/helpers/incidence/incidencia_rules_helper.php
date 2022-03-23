<?php
function getIncidenciaRules() {
    return array(
        array(
                'field' => 'titulo',
                'label' => 'Titulo',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'El %s es requerido.',
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