(function($) {
    //Función para cuando le de click al boton de ver
    $(document).on('click', '.ver', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idReporte');
        console.log(id_incidencia);
        $.post('reporte/visualizar_reporte', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            window.open(json.url);
        });
    });

    //Función para el boton de atender incidencia
    $(document).on('click', '.atender', function(){
        $('.mensaje').css({'visibility':'visible'});
    });

})(jQuery)