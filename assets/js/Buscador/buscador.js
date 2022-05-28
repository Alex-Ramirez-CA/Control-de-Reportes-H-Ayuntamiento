(function($) {
    $(document).on('click', '.usuario-icono', function(){
        if($('.menu-cerrar-sesion').css('display') == 'none'){
            $('.menu-cerrar-sesion').css('display','block');
        }else{
            $('.menu-cerrar-sesion').css('display','none');
        }
    });

    $(document).on('click', 'body', function(){
        if($('#opciones-buscar').css('display') == 'flex'){
            $('#opciones-buscar').css('display','none');
        }
    });

    $(document).on('click', '.card', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idCard');
        $.post('reporte/visualizar_reporte', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            window.open(json.url);
        });
    });

    $(document).on('click', '.autocompletado', function(){
        let elemento = $(this)[0]; 
        let id_incidencia = $(elemento).attr('idCard');
        $.post('reporte/visualizar_reporte', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            window.open(json.url);
        });
    });

})(jQuery)