(function($) {
    //Función para cuando le de click a la tarjeta
    $(document).on('click', '.card-filtro', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idCard');
        $.post('reporte/visualizar_reporte', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            window.open(json.url);
        });
    });

    //Función la opción de complementar la descripción de un reporte
    
})(jQuery)