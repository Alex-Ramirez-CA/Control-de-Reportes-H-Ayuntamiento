(function($) {

    //Función para cuando le de click al boton de ver
    $(document).on('click', '.ver', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idReporte');
        $.post('reporte/visualizar_reporte', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            window.open(json.url);
        });
    });

    //Función para el boton de atender incidencia
    $(document).on('click', '.atender', function(){
        let elemento = $(this)[0];
        let id = $(elemento).attr('idReporte');
        let titulo = $(elemento).attr('titulo');
        $('.folio').html("Folio: " + id);
        $('.participante').html("0");
        $('.nombres-asignados').html("Por definir");
        $('.titulo-reporte-tecnico').html("Titulo: " + titulo);
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
        $('.enviar-comentario').attr('idReporte',id);
        $('.enviar-comentario').attr('titulo',titulo);

        $(document).on('click', '.enviar-comentario', function(){
            let elemento = $(this)[0];
            let id_incidencia = $(elemento).attr('idReporte');
            let comentario = $('#comentario-tecnico').val();
            $.post('tecnico/atender', {id_incidencia, comentario}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });

        });
    });

    $(document).on('click', '.unirme', function(){
        let elemento = $(this)[0];
        let id = $(elemento).attr('idReporte');
        let titulo = $(elemento).attr('titulo');
        let participantes = ($(elemento).attr('participantes')).split(',');
        $('.folio').html("Folio: " + id);
        //$('.participante').css({'padding-left':'8px'});
        $('.participante').html(participantes.length);
        $('.nombres-asignados').html("Atendido por " + participantes);
        $('.titulo-reporte-tecnico').html("Titulo: " + titulo);
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
        $('.enviar-comentario').attr('idReporte',id);
        $(document).on('click', '.enviar-comentario', function(){
            let elemento = $(this)[0];
            let id_incidencia = $(elemento).attr('idReporte');
            let comentario = $('#comentario-tecnico').val();
            console.log(id_incidencia);
            console.log(comentario);
            $.post('tecnico/unirme', {id_incidencia, comentario}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });

        });
    });

    $(document).on('click', '.reabrir', function(){
        let elemento = $(this)[0];
        let id = $(elemento).attr('idReporte');
        let titulo = $(elemento).attr('titulo');
        let participantes = ($(elemento).attr('participantes')).split(',');
        $('.folio').html("Folio: " + id);
        $('.participante').html(participantes.length);
        $('.nombres-asignados').html("Atendido por " + participantes);
        $('.titulo-reporte-tecnico').html("Titulo: " + titulo);
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
        $('.enviar-comentario').attr('idReporte',id);

        $(document).on('click', '.enviar-comentario', function(){
            let elemento = $(this)[0];
            let id_incidencia = $(elemento).attr('idReporte');
            let comentario = $('#comentario-tecnico').val();
            $.post('tecnico/reabrir', {id_incidencia, comentario}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });

        });
    });

    $(document).on('click', '.finalizar', function(){
        let elemento = $(this)[0];
        let id = $(elemento).attr('idReporte');
        let titulo = $(elemento).attr('titulo');
        let participantes = ($(elemento).attr('participantes')).split(',');
        $('.folio').html("Folio: " + id);
        $('.participante').html(participantes.length);
        $('.nombres-asignados').html("Atendido por " + participantes);
        $('.titulo-reporte-tecnico').html("Titulo: " + titulo);
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
        $('.enviar-comentario').attr('idReporte',id);

        $(document).on('click', '.enviar-comentario', function(){
            let elemento = $(this)[0];
            let id_incidencia = $(elemento).attr('idReporte');
            let comentario = $('#comentario-tecnico').val();
            $.post('atendiendo/finalizar', {id_incidencia, comentario}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });

        });
    });

    $(document).on('click', '.reabrir-atendido', function(){
        let elemento = $(this)[0];
        let id = $(elemento).attr('idReporte');
        let titulo = $(elemento).attr('titulo');
        let participantes = ($(elemento).attr('participantes')).split(',');
        $('.folio').html("Folio: " + id);
        $('.participante').html(participantes.length);
        $('.nombres-asignados').html("Atendido por " + participantes);
        $('.titulo-reporte-tecnico').html("Titulo: " + titulo);
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
        $('.enviar-comentario').attr('idReporte',id);

        $(document).on('click', '.enviar-comentario', function(){
            let elemento = $(this)[0];
            let id_incidencia = $(elemento).attr('idReporte');
            let comentario = $('#comentario-tecnico').val();
            $.post('atendiendo/reabrir', {id_incidencia, comentario}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });

        });
    });

    //Función para cerrar el modal
    $(document).on('click', '.cerrar-mensaje-tecnico', function(){
        $('.enviar-comentario').removeAttr('idReporte');
        $('.mensaje').css({'visibility':'hidden'});
        $('.contenedor-mensaje').css({'transform':'translateY(-200%)'});
        $.post('tecnico/recargar', {}, function(response){
            let json = JSON.parse(response);
            window.location.replace(json.url);
        });
    });

    

})(jQuery)