(function($) {
    //Función para cuando le de click a la tarjeta
    $(document).on('click', '.btn-ver-filtro', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idReporte');
        console.log(id_incidencia);
        $.post('reporte/visualizar_reporte', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            window.open(json.url);
        });
    });

    //Función la opción de complementar la descripción de un reporte
    $(document).on('click', '.btn-comentar-filtro', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idReporte');
        $.post('filtro/editar_descripcion', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            $('.titulo-reporte-filtro').html(json.titulo);
            $('#folio-reporte').html("Folio: " + json.id_incidencia);
            $('#fecha-reporte').html("Creado: " + json.fecha_apertura);
            $('#descripcion-reporte').html(json.descripcion);

            //Función para enviar la descripción del reporte editado
            $(document).on('click', '.guardar-cambios', function(){
                let id_incidencia = json.id_incidencia;
                let descripcion = $('#descripcion-reporte').val()
                $.post('filtro/actualizar_descripcion', {id_incidencia,descripcion}, function(response){
                    let json = JSON.parse(response);
                    console.log(json);
                });
            });
        });
    });

    $(document).on('click', '.administracion', function(){
        if($(this).hasClass('active')){  
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
            console.log("Se activo Admi del reporte " + $(this).attr("idReporte"));
        }                
    });

    $(document).on('click', '.soporte-tecnico', function(){
        if($(this).hasClass('active')){  
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
            console.log("Se activo ST del reporte " + $(this).attr("idReporte"));
        }                
    });

    $(document).on('click', '.redes', function(){
        if($(this).hasClass('active')){  
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
            console.log("Se activo redes del reporte " + $(this).attr("idReporte"));
        }          
    });

    $(document).on('click', '.btn-enviar-filtro', function(){
        if($('.administracion').hasClass('active') || $('.soporte-tecnico').hasClass('active') || $('.redes').hasClass('active')){
            console.log($(this).attr("idReporte") + "Se puede enviar");
        }else{
            alert("No puede enviar");
        }

        //console.log("id tarjeta " + $(this).attr("idReporte"));         
    });

})(jQuery)